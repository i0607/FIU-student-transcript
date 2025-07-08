<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curriculum;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CurriculumController extends Controller
{
    /**
     * Get curriculum by department ID and version
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurriculumByDepartmentAndVersion(Request $request)
    {
        $request->validate([
            'department_id' => 'required|integer|exists:departments,id',
            'version' => 'required|string|in:old,new,Old,New'
        ]);

        $departmentId = $request->department_id;
        $version = ucfirst(strtolower($request->version)); // Normalize to 'Old' or 'New'

        try {
            // Get department information
            $department = Department::find($departmentId);
            
            if (!$department) {
                return response()->json([
                    'success' => false,
                    'message' => 'Department not found'
                ], 404);
            }

            // Get curriculum data with course details and proper ordering
            $curriculumData = DB::table('curriculums')
                ->join('courses', 'curriculums.course_id', '=', 'courses.id')
                ->join('faculties', 'curriculums.faculty_id', '=', 'faculties.id')
                ->where('curriculums.department_id', $departmentId)
                ->where('curriculums.version', $version)
                ->select([
                    'curriculums.*',
                    'courses.code as course_code',
                    'courses.title as course_title',
                    'courses.credits as course_credits',
                    'courses.category as course_category',
                    'courses.semester as course_semester',
                    'courses.ects as course_ects',
                    'faculties.title as faculty_title'
                ])
                ->orderByRaw($this->getCategoryOrderSql())
                ->orderByRaw($this->getSemesterOrderSql()) // Fixed semester ordering
                ->orderBy('courses.code')
                ->get();

            if ($curriculumData->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => "No curriculum found for department '{$department->name}' with version '{$version}'"
                ], 404);
            }

            // Group courses by semester and category
            $groupedCourses = $this->groupCoursesBySemesterAndCategory($curriculumData);
            
            // Calculate curriculum statistics
            $statistics = $this->calculateCurriculumStatistics($curriculumData);

            return response()->json([
                'success' => true,
                'data' => [
                    'department' => [
                        'id' => $department->id,
                        'name' => $department->name,
                        'faculty_id' => $department->faculty_id
                    ],
                    'version' => $version,
                    'faculty_title' => $curriculumData->first()->faculty_title,
                    'department_title' => $curriculumData->first()->department_title,
                    'statistics' => $statistics,
                    'courses_by_semester' => $groupedCourses['by_semester'],
                    'courses_by_category' => $groupedCourses['by_category'],
                    'all_courses' => $this->formatCourseData($curriculumData)
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching curriculum data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get curriculum by department ID (all versions)
     * 
     * @param int $departmentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurriculumByDepartment($departmentId)
    {
        try {
            $department = Department::find($departmentId);
            
            if (!$department) {
                return response()->json([
                    'success' => false,
                    'message' => 'Department not found'
                ], 404);
            }

            // Get all versions for this department
            $versions = DB::table('curriculums')
                ->where('department_id', $departmentId)
                ->distinct()
                ->pluck('version')
                ->filter()
                ->values();

            if ($versions->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => "No curriculum found for department '{$department->name}'"
                ], 404);
            }

            $allVersionsData = [];

            foreach ($versions as $version) {
                $curriculumData = DB::table('curriculums')
                    ->join('courses', 'curriculums.course_id', '=', 'courses.id')
                    ->join('faculties', 'curriculums.faculty_id', '=', 'faculties.id')
                    ->where('curriculums.department_id', $departmentId)
                    ->where('curriculums.version', $version)
                    ->select([
                        'curriculums.*',
                        'courses.code as course_code',
                        'courses.title as course_title',
                        'courses.credits as course_credits',
                        'courses.category as course_category',
                        'courses.semester as course_semester',
                        'courses.ects as course_ects',
                        'faculties.title as faculty_title'
                    ])
                    ->orderByRaw($this->getCategoryOrderSql())
                    ->orderByRaw($this->getSemesterOrderSql()) // Fixed semester ordering
                    ->orderBy('courses.code')
                    ->get();

                $groupedCourses = $this->groupCoursesBySemesterAndCategory($curriculumData);
                $statistics = $this->calculateCurriculumStatistics($curriculumData);

                $allVersionsData[] = [
                    'version' => $version,
                    'statistics' => $statistics,
                    'courses_by_semester' => $groupedCourses['by_semester'],
                    'courses_by_category' => $groupedCourses['by_category'],
                    'total_courses' => $curriculumData->count()
                ];
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'department' => [
                        'id' => $department->id,
                        'name' => $department->name,
                        'faculty_id' => $department->faculty_id
                    ],
                    'available_versions' => $versions,
                    'versions_data' => $allVersionsData
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching curriculum data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available departments and their versions
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableDepartments()
    {
        try {
            $departments = DB::table('departments')
                ->join('curriculums', 'departments.id', '=', 'curriculums.department_id')
                ->select([
                    'departments.id',
                    'departments.name',
                    'departments.faculty_id',
                    DB::raw('GROUP_CONCAT(DISTINCT curriculums.version) as versions')
                ])
                ->groupBy('departments.id', 'departments.name', 'departments.faculty_id')
                ->get()
                ->map(function ($department) {
                    return [
                        'id' => $department->id,
                        'name' => $department->name,
                        'faculty_id' => $department->faculty_id,
                        'available_versions' => $department->versions ? 
                            array_filter(explode(',', $department->versions)) : []
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => [
                    'departments' => $departments,
                    'total_departments' => $departments->count()
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching departments',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get SQL for category ordering: AC, FC, UC, AE, FE, UE
     * 
     * @return string
     */
    private function getCategoryOrderSql()
    {
        return "CASE courses.category 
                    WHEN 'AC' THEN 1 
                    WHEN 'FC' THEN 2 
                    WHEN 'UC' THEN 3 
                    WHEN 'AE' THEN 4 
                    WHEN 'FE' THEN 5 
                    WHEN 'UE' THEN 6 
                    ELSE 7 
                END";
    }

    /**
     * Get SQL for proper semester ordering - Fixed to handle numeric sorting properly
     * 
     * @return string
     */
    private function getSemesterOrderSql()
    {
        return "CASE 
                    WHEN courses.semester IS NULL OR courses.semester = '' OR courses.semester = 'Elective' THEN 999
                    WHEN courses.semester REGEXP '^[0-9]+$' THEN CAST(courses.semester AS UNSIGNED)
                    ELSE 999
                END";
    }

    /**
     * Group courses by semester and category
     * 
     * @param \Illuminate\Support\Collection $curriculumData
     * @return array
     */
    private function groupCoursesBySemesterAndCategory($curriculumData)
    {
        // Group by semester with proper ordering
        $bySemester = $curriculumData->groupBy('course_semester')->map(function ($courses, $semester) {
            // Sort courses within each semester by category priority
            $sortedCourses = $courses->sortBy(function ($course) {
                return $this->getCategoryPriority($course->course_category);
            })->values();

            return [
                'semester' => $semester ?: 'Elective',
                'courses' => $sortedCourses->map(function ($course) {
                    return $this->formatSingleCourse($course);
                })->values(),
                'total_credits' => $courses->sum('course_credits'),
                'total_ects' => $courses->sum('course_ects'),
                'course_count' => $courses->count()
            ];
        });

        // Sort semesters properly
        $sortedBySemester = $bySemester->sort(function ($a, $b) {
            return $this->compareSemesters($a['semester'], $b['semester']);
        })->values();

        // Group by category and sort categories by priority
        $byCategory = $curriculumData->groupBy('course_category')->map(function ($courses, $category) {
            return [
                'category' => $category ?: 'Others',
                'category_name' => $this->getCategoryName($category),
                'category_priority' => $this->getCategoryPriority($category),
                'courses' => $courses->map(function ($course) {
                    return $this->formatSingleCourse($course);
                })->values(),
                'total_credits' => $courses->sum('course_credits'),
                'total_ects' => $courses->sum('course_ects'),
                'course_count' => $courses->count()
            ];
        })->sortBy('category_priority')->values();

        return [
            'by_semester' => $sortedBySemester,
            'by_category' => $byCategory
        ];
    }

    /**
     * Compare semesters for proper ordering
     * 
     * @param string $semesterA
     * @param string $semesterB
     * @return int
     */
    private function compareSemesters($semesterA, $semesterB)
    {
        // Handle null/empty/elective cases
        if (($semesterA === null || $semesterA === '' || $semesterA === 'Elective') && 
            ($semesterB === null || $semesterB === '' || $semesterB === 'Elective')) {
            return 0;
        }
        
        if ($semesterA === null || $semesterA === '' || $semesterA === 'Elective') {
            return 1; // Put electives at the end
        }
        
        if ($semesterB === null || $semesterB === '' || $semesterB === 'Elective') {
            return -1; // Put electives at the end
        }

        // Convert to numeric values for comparison
        $numA = is_numeric($semesterA) ? (int)$semesterA : 999;
        $numB = is_numeric($semesterB) ? (int)$semesterB : 999;

        return $numA - $numB;
    }

    /**
     * Get category priority for sorting: AC=1, FC=2, UC=3, AE=4, FE=5, UE=6
     * 
     * @param string $category
     * @return int
     */
    private function getCategoryPriority($category)
    {
        return match (strtoupper($category ?? '')) {
            'AC' => 1,
            'FC' => 2,
            'UC' => 3,
            'AE' => 4,
            'FE' => 5,
            'UE' => 6,
            default => 7
        };
    }

    /**
     * Calculate curriculum statistics with proper semester ordering
     * 
     * @param \Illuminate\Support\Collection $curriculumData
     * @return array
     */
    private function calculateCurriculumStatistics($curriculumData)
    {
        $totalCredits = $curriculumData->sum('course_credits');
        $totalEcts = $curriculumData->sum('course_ects');
        $totalCourses = $curriculumData->count();
        
        $categoryCounts = $curriculumData->groupBy('course_category')->map(function ($courses, $category) {
            return [
                'category' => $category ?: 'Others',
                'category_name' => $this->getCategoryName($category),
                'category_priority' => $this->getCategoryPriority($category),
                'count' => $courses->count(),
                'credits' => $courses->sum('course_credits'),
                'ects' => $courses->sum('course_ects')
            ];
        })->sortBy('category_priority')->values();

        $semesterCounts = $curriculumData->groupBy('course_semester')->map(function ($courses, $semester) {
            return [
                'semester' => $semester ?: 'Elective',
                'count' => $courses->count(),
                'credits' => $courses->sum('course_credits'),
                'ects' => $courses->sum('course_ects')
            ];
        })->sort(function ($a, $b) {
            return $this->compareSemesters($a['semester'], $b['semester']);
        })->values();

        return [
            'total_courses' => $totalCourses,
            'total_credits' => $totalCredits,
            'total_ects' => $totalEcts,
            'average_credits_per_course' => $totalCourses > 0 ? round($totalCredits / $totalCourses, 2) : 0,
            'category_breakdown' => $categoryCounts,
            'semester_breakdown' => $semesterCounts
        ];
    }

    /**
     * Format course data for response
     * 
     * @param \Illuminate\Support\Collection $curriculumData
     * @return \Illuminate\Support\Collection
     */
    private function formatCourseData($curriculumData)
    {
        return $curriculumData->map(function ($course) {
            return $this->formatSingleCourse($course);
        })->values();
    }

    /**
     * Format single course data
     * 
     * @param object $course
     * @return array
     */
    private function formatSingleCourse($course)
    {
        return [
            'course_id' => $course->course_id,
            'code' => $course->course_code,
            'title' => $course->course_title,
            'credits' => (int) $course->course_credits,
            'ects' => (int) $course->course_ects,
            'category' => $course->course_category,
            'category_name' => $this->getCategoryName($course->course_category),
            'semester' => $course->course_semester ?: 'Elective',
            'lecture_hours' => (int) $course->lecture_hours,
            'lab_hours' => (int) $course->lab_hours,
            'total_credits' => (int) $course->total_credits,
            'pre_requisite' => $course->pre_requisite,
            'curriculum_id' => $course->id
        ];
    }

    /**
     * Get category full name
     * 
     * @param string $category
     * @return string
     */
    private function getCategoryName($category)
    {
        return match (strtoupper($category ?? '')) {
            'AC' => 'Area Core',
            'AE' => 'Area Elective', 
            'UC' => 'University Core',
            'FC' => 'Faculty Core',
            'FE' => 'Faculty Elective',
            'UE' => 'University Elective',
            default => 'Others'
        };
    }
}