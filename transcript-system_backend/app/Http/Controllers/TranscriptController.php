<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Transcript;
use App\Models\Course;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TranscriptExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class TranscriptController extends Controller
{
    /**
     * Get curriculum-specific course data with caching
     * Prioritizes curriculum values over course defaults
     */
    private function getCurriculumCourseData($courseId, $departmentId, $version)
    {
        $cacheKey = "curriculum_{$courseId}_{$departmentId}_{$version}";
        
        return Cache::remember($cacheKey, 3600, function () use ($courseId, $departmentId, $version) {
            return DB::table('curriculums')
                ->where('course_id', $courseId)
                ->where('department_id', $departmentId)
                ->where('version', $version)
                ->select([
                    'total_credits',
                    'ects',
                    'course_category',
                    'title',
                    'pre_requisite',
                    'lecture_hours',
                    'lab_hours',
                    'tutorial',
                    'department_title',
                    'faculty_id'
                ])->first();
        });
    }

    /**
     * Get course data with curriculum priority
     */
    private function getCourseWithCurriculumData($course, $student, $curriculumVersion)
    {
        $curriculumCourse = $this->getCurriculumCourseData(
            $course->id, 
            $student->department_id, 
            $curriculumVersion
        );

        return [
            'id' => $course->id,
            'code' => $course->code,
            'title' => $curriculumCourse->title ?? $course->title,
            'credits' => (int) ($curriculumCourse->total_credits ?? $course->credits ?? 0),
            'ects_credits' => (int) ($curriculumCourse->ects ?? $course->ects ?? $course->ects_credits ?? $curriculumCourse->total_credits ?? $course->credits ?? 0),
            'category' => $curriculumCourse->course_category ?? $course->category ?? 'Others',
            'semester' => $course->semester ?? 'N/A',
            'pre_requisite' => $curriculumCourse->pre_requisite ?? 'None',
            'lecture_hours' => (int) ($curriculumCourse->lecture_hours ?? 0),
            'lab_hours' => (int) ($curriculumCourse->lab_hours ?? 0),
            'tutorial' => (int) ($curriculumCourse->tutorial ?? 0),
            'department_id' => $student->department_id,
            'faculty_id' => $curriculumCourse->faculty_id ?? null,
            'version' => $curriculumVersion,
            'source' => $curriculumCourse ? 'curriculum' : 'course',
            'has_curriculum_override' => $curriculumCourse ? true : false,
        ];
    }

    /**
     * Sort semesters in chronological order with proper handling of make-up semesters
     */
    private function sortSemesters($transcripts)
    {
        $grouped = $transcripts->groupBy('semester');
        
        $sortedSemesters = $grouped->keys()->sort(function ($a, $b) {
            return $this->compareSemesters($a, $b);
        });
        
        $sortedGrouped = collect();
        foreach ($sortedSemesters as $semester) {
            $sortedGrouped->put($semester, $grouped->get($semester));
        }
        
        return $sortedGrouped;
    }

    /**
     * Compare two semester strings for sorting
     */
    private function compareSemesters($semesterA, $semesterB)
    {
        $parsedA = $this->parseSemester($semesterA);
        $parsedB = $this->parseSemester($semesterB);
        
        if ($parsedA['isSpecial'] && !$parsedB['isSpecial']) {
            return -1;
        }
        if (!$parsedA['isSpecial'] && $parsedB['isSpecial']) {
            return 1;
        }
        if ($parsedA['isSpecial'] && $parsedB['isSpecial']) {
            return strcmp($semesterA, $semesterB);
        }
        
        if ($parsedA['year'] !== $parsedB['year']) {
            return $parsedA['year'] - $parsedB['year'];
        }
        
        $semesterOrder = ['fall' => 1, 'spring' => 2, 'summer' => 3];
        
        if ($parsedA['mainType'] !== $parsedB['mainType']) {
            return $semesterOrder[$parsedA['mainType']] - $semesterOrder[$parsedB['mainType']];
        }
        
        if ($parsedA['isMakeup'] !== $parsedB['isMakeup']) {
            return $parsedA['isMakeup'] ? 1 : -1;
        }
        
        return strcmp($parsedA['suffix'], $parsedB['suffix']);
    }

    /**
     * Parse semester string into components
     */
    private function parseSemester($semester)
    {
        $semester = trim($semester);
        
        $specialCases = [
            'Exempted Courses',
            'English Preparatory School Exemption Test',
            'Proficiency'
        ];
        
        foreach ($specialCases as $special) {
            if (stripos($semester, $special) !== false) {
                return [
                    'year' => 0,
                    'mainType' => 'special',
                    'isMakeup' => false,
                    'isSpecial' => true,
                    'suffix' => '',
                    'original' => $semester
                ];
            }
        }
        
        $result = [
            'year' => 0,
            'mainType' => 'fall',
            'isMakeup' => false,
            'isSpecial' => false,
            'suffix' => '',
            'original' => $semester
        ];
        
        if (preg_match('/(\d{4})/', $semester, $yearMatches)) {
            $result['year'] = (int) $yearMatches[1];
        }
        
        if (stripos($semester, 'fall') !== false || stripos($semester, 'güz') !== false) {
            $result['mainType'] = 'fall';
        } elseif (stripos($semester, 'spring') !== false || stripos($semester, 'bahar') !== false) {
            $result['mainType'] = 'spring';
        } elseif (stripos($semester, 'summer') !== false || stripos($semester, 'yaz') !== false) {
            $result['mainType'] = 'summer';
        }
        
        $makeupPatterns = [
            'bütünleme', 'butunleme', 'make-up', 'makeup', 'retake', 
            'supplementary', 'repeat', '13-', '17-'
        ];
        
        foreach ($makeupPatterns as $pattern) {
            if (stripos($semester, $pattern) !== false) {
                $result['isMakeup'] = true;
                if (preg_match('/(' . preg_quote($pattern, '/') . '.*)$/i', $semester, $suffixMatches)) {
                    $result['suffix'] = $suffixMatches[1];
                }
                break;
            }
        }
        
        return $result;
    }

    /**
     * Main transcript endpoint - ALL DATA FROM CURRICULUM
     */
    public function getTranscript($studentNumber)
    {
        $student = Student::where('student_number', $studentNumber)->first();

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $transcripts = $student->transcripts()->with('course')->get();
        $curriculumVersion = $this->determineCurriculumVersion($student);
        
        $sortedGrouped = $this->sortSemesters($transcripts);

        $structuredTranscript = [];
        $grandTotalGradePoints = 0;
        $grandTotalCredits = 0;
        $grandTotalECTS = 0;
        $grandTotalCreditsEarned = 0;

        foreach ($sortedGrouped as $semester => $entries) {
            $semesterGradePoints = 0;
            $semesterCredits = 0;
            $semesterCreditsEarned = 0;
            $semesterECTS = 0;
            $courses = [];

            foreach ($entries as $entry) {
                // Get curriculum-based course data
                $courseData = $this->getCourseWithCurriculumData($entry->course, $student, $curriculumVersion);
                
                $gradePoint = $this->gradeToPoint($entry->grade);
                
                $courseGradePoints = 0;
                $countsInGPA = true;
                $isEarned = false;
                
                $semesterCredits += $courseData['credits'];
                $semesterECTS += $courseData['ects_credits'];
                
                if ($gradePoint === null) {
                    $countsInGPA = false;
                    $courseGradePoints = 0;
                } else {
                    $courseGradePoints = $courseData['credits'] * $gradePoint;
                    $semesterGradePoints += $courseGradePoints;
                    
                    if ($gradePoint > 0) {
                        $isEarned = true;
                        $semesterCreditsEarned += $courseData['credits'];
                    }
                }

                $courses[] = [
                    'code' => $courseData['code'],
                    'title' => $courseData['title'],
                    'grade' => $entry->grade,
                    'ects_credits' => $courseData['ects_credits'],
                    'credits' => $courseData['credits'],
                    'grade_points' => number_format($courseGradePoints, 2, '.', ''),
                    'category' => $courseData['category'],
                    'color' => $this->getCategoryColor($courseData['category']),
                    'counts_in_gpa' => $countsInGPA,
                    'is_earned' => $isEarned,
                    'semester' => $courseData['semester'],
                    'source' => $courseData['source'],
                    'has_curriculum_override' => $courseData['has_curriculum_override'],
                ];
            }

            $semesterGPA = $semesterCredits > 0 ? floor(($semesterGradePoints / $semesterCredits) * 100) / 100 : 0.00;
            
            $grandTotalGradePoints += $semesterGradePoints;
            $grandTotalCredits += $semesterCredits;
            $grandTotalCreditsEarned += $semesterCreditsEarned;
            $grandTotalECTS += $semesterECTS;
            
            $cumulativeGPA = $grandTotalCredits > 0 ? floor(($grandTotalGradePoints / $grandTotalCredits) * 100) / 100 : 0.00;

            $structuredTranscript[] = [
                'semester' => $semester,
                'courses' => $courses,
                'semester_gpa' => number_format($semesterGPA, 2, '.', ''),
                'semester_credits' => $semesterCredits,
                'semester_credits_earned' => $semesterCreditsEarned,
                'semester_ects' => $semesterECTS,
                'semester_grade_points' => number_format($semesterGradePoints, 2, '.', ''),
                'cumulative_gpa' => number_format($cumulativeGPA, 2, '.', ''),
                'grand_total_credits' => $grandTotalCredits,
                'grand_total_credits_earned' => $grandTotalCreditsEarned,
                'grand_total_ects' => $grandTotalECTS,
                'grand_total_grade_points' => number_format($grandTotalGradePoints, 2, '.', ''),
            ];
        }

        // Get remaining courses from student's department only
        $remainingCourses = $this->getRemainingCourses($student, $transcripts);

        // Check graduation requirements
        $graduationRequirements = $this->checkGraduationRequirements($student, $transcripts);

        return response()->json([
            'student' => [
                'name' => $student->name,
                'studentNumber' => $student->student_number,
                'departmentId' => $student->department_id,
                'departmentName' => 'N/A',
                'facultyId' => null,
                'facultyName' => 'N/A',
                'curriculumVersion' => $curriculumVersion,
                'date_of_birth' => $student->date_of_birth,
                'entry_date' => $student->entry_date,
                'graduation_date' => $student->graduation_date,
            ],
            'transcript' => $structuredTranscript,
            'total_credits' => $grandTotalCredits,
            'total_ects' => $grandTotalECTS,
            'total_grade_points' => number_format($grandTotalGradePoints, 2, ',', ''),
            'cumulative_gpa' => $grandTotalCredits > 0 ? number_format($grandTotalGradePoints / $grandTotalCredits, 2, '.', '') : '0.00',
            'remaining_courses' => $remainingCourses,
            'graduation_requirements' => $graduationRequirements,
        ]);
    }

    /**
     * Get remaining courses - GLOBAL TRANSCRIPT CHECK
     * Checks if a course has been taken in ANY semester before marking as remaining
     */
    private function getRemainingCourses($student, $transcripts)
    {
        // Build a comprehensive map of all courses taken by the student
        $allTakenCourses = [];
        $courseCodeGrades = [];
        
        foreach ($transcripts as $transcript) {
            $courseCode = trim(strtoupper($transcript->course->code ?? ''));
            $grade = strtoupper(trim($transcript->grade));
            $semester = $transcript->semester;
            
            if ($courseCode && $grade) {
                // Track all attempts of this course
                if (!isset($courseCodeGrades[$courseCode])) {
                    $courseCodeGrades[$courseCode] = [];
                }
                $courseCodeGrades[$courseCode][] = [
                    'grade' => $grade,
                    'semester' => $semester,
                    'course_id' => $transcript->course->id
                ];
                
                // Mark this course as taken (regardless of grade)
                $allTakenCourses[$courseCode] = true;
            }
        }

        // Get the final status for each course taken
        $finalCourseStatuses = [];
        foreach ($courseCodeGrades as $courseCode => $attempts) {
            // Get the most recent attempt
            $latestAttempt = end($attempts);
            $finalCourseStatuses[$courseCode] = [
                'latest_grade' => $latestAttempt['grade'],
                'latest_semester' => $latestAttempt['semester'],
                'attempt_count' => count($attempts),
                'all_attempts' => $attempts
            ];
        }
        
        // Define grade categories
        $passingGrades = ['A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-'];
        $failingGrades = ['F', 'FF'];
        $nonGpaGrades = ['NG', 'W', 'S', 'I', 'U', 'P', 'E', 'TS', 'T1', 'CS', 'H', 'PS', 'TU', 'TR', 'T', 'P0', 'TP', 'TF'];
        
        // Get successfully completed course codes (passing grades only)
        $completedCourseCodes = [];
        foreach ($finalCourseStatuses as $courseCode => $status) {
            if (in_array($status['latest_grade'], $passingGrades)) {
                $completedCourseCodes[] = $courseCode;
            }
        }
        
        // Get all curriculum courses for the student's program
        $curriculumVersion = $this->determineCurriculumVersion($student);
        $allCurriculumCourses = $this->getCurriculumCoursesWithSemesters($student, $curriculumVersion);
        
        // Build remaining courses list with global transcript check
        $remainingCourses = collect();
        
        foreach ($allCurriculumCourses as $curriculumCourse) {
            $courseCode = trim(strtoupper($curriculumCourse['code']));
            
            // GLOBAL CHECK: Skip if this course has been completed (passed) in ANY semester
            if (in_array($courseCode, $completedCourseCodes)) {
                continue;
            }
            
            // Determine the current status of this course
            $status = 'Not Taken';
            $isRetake = false;
            $lastGrade = null;
            $attemptCount = 0;
            $takenInSemesters = [];
            
            // Check if the course has been attempted (but not passed)
            if (isset($finalCourseStatuses[$courseCode])) {
                $courseStatus = $finalCourseStatuses[$courseCode];
                $lastGrade = $courseStatus['latest_grade'];
                $attemptCount = $courseStatus['attempt_count'];
                
                // Collect all semesters where this course was attempted
                foreach ($courseStatus['all_attempts'] as $attempt) {
                    $takenInSemesters[] = $attempt['semester'];
                }
                
                // Determine status based on latest grade
                if (in_array($lastGrade, $failingGrades)) {
                    $status = 'Retake Required (Failed: ' . $lastGrade . ')';
                    $isRetake = true;
                } elseif (in_array($lastGrade, $nonGpaGrades)) {
                    $status = 'Retake Required (' . $lastGrade . ')';
                    $isRetake = true;
                } else {
                    // This shouldn't happen since we filtered out passing grades above
                    $status = 'In Progress (' . $lastGrade . ')';
                    $isRetake = true;
                }
            }
            
            // Add additional information about where the course was attempted
            $attemptInfo = '';
            if (!empty($takenInSemesters)) {
                $uniqueSemesters = array_unique($takenInSemesters);
                if (count($uniqueSemesters) > 1) {
                    $attemptInfo = ' (Attempted in: ' . implode(', ', $uniqueSemesters) . ')';
                } else {
                    $attemptInfo = ' (Attempted in: ' . $uniqueSemesters[0] . ')';
                }
            }
            
            $remainingCourses->push([
                'code' => $curriculumCourse['code'],
                'title' => $curriculumCourse['title'],
                'credits' => $curriculumCourse['credits'],
                'ects_credits' => $curriculumCourse['ects_credits'],
                'category' => $curriculumCourse['category'],
                'category_name' => $this->getCategoryName($curriculumCourse['category']),
                'semester' => $curriculumCourse['semester'], // Keep original curriculum semester
                'expected_semester' => $curriculumCourse['semester'], // When it should be taken (same as above for clarity)
                'department_id' => $curriculumCourse['department_id'],
                'faculty_id' => $curriculumCourse['faculty_id'] ?? null,
                'version' => $curriculumCourse['version'],
                'status' => $status . $attemptInfo,
                'is_retake' => $isRetake,
                'last_grade' => $lastGrade,
                'attempt_count' => $attemptCount,
                'attempted_semesters' => $takenInSemesters,
                'is_taken_in_wrong_semester' => !empty($takenInSemesters) && !in_array($curriculumCourse['semester'], $takenInSemesters),
                'color' => $this->getCategoryColor($curriculumCourse['category']),
                'pre_requisite' => $curriculumCourse['pre_requisite'],
                'lecture_hours' => $curriculumCourse['lecture_hours'],
                'lab_hours' => $curriculumCourse['lab_hours'],
                'tutorial' => $curriculumCourse['tutorial'],
                'source' => $curriculumCourse['source'],
                'has_curriculum_override' => $curriculumCourse['has_curriculum_override'],
            ]);
        }
        
        // Sort by original curriculum semester, then category priority, then code
        return $remainingCourses->sortBy([
            function ($course) {
                // Sort by the original curriculum semester (not where it was attempted)
                $semester = $course['semester']; // This is the curriculum semester
                return is_numeric($semester) ? (int) $semester : 999;
            },
            function ($course) {
                return $this->getCategoryPriority($course['category']);
            },
            ['code', 'asc']
        ])->values();
    }

    /**
     * Get curriculum courses with semester filtering - FULL CURRICULUM INTEGRATION
     */
    private function getCurriculumCoursesWithSemesters($student, $curriculumVersion)
    {
        // Primary query with curriculum integration (without faculty dependency)
        $query = DB::table('curriculums')
            ->join('courses', 'curriculums.course_id', '=', 'courses.id')
            ->where('curriculums.department_id', $student->department_id)
            ->where('curriculums.version', $curriculumVersion);
        
        $curriculumCourses = $query
            ->where(function($query) {
                $query->whereIn('courses.semester', ['1', '2', '3', '4', '5', '6', '7', '8'])
                      ->orWhere('courses.semester', 'REGEXP', '^[1-8]$');
            })
            ->whereNotIn('curriculums.course_category', ['AE', 'FE', 'UE'])
            ->select(
                'courses.id',
                'courses.code', 
                'courses.semester',
                'courses.department_id',
                
                // Prioritize curriculum values
                'curriculums.title as curriculum_title',
                'curriculums.total_credits as curriculum_credits',
                'curriculums.ects as curriculum_ects',
                'curriculums.course_category as curriculum_category',
                'curriculums.pre_requisite',
                'curriculums.lecture_hours',
                'curriculums.lab_hours',
                'curriculums.tutorial',
                'curriculums.department_title',
                'curriculums.version',
                'curriculums.faculty_id',
                
                // Course defaults as fallback
                'courses.title as course_title',
                'courses.credits as course_credits',
                'courses.ects as course_ects',
                'courses.category as course_category'
            )
            ->orderBy('courses.semester')
            ->orderByRaw("CASE curriculums.course_category 
                WHEN 'AC' THEN 1 
                WHEN 'FC' THEN 2 
                WHEN 'UC' THEN 3 
                WHEN 'AE' THEN 4 
                WHEN 'FE' THEN 5 
                WHEN 'UE' THEN 6 
                ELSE 7 END")
            ->orderBy('courses.code')
            ->get();

        if ($curriculumCourses->isNotEmpty()) {
            return $curriculumCourses->map(function ($course) {
                return [
                    'id' => $course->id,
                    'code' => $course->code,
                    'title' => $course->curriculum_title ?: $course->course_title,
                    'credits' => (int) ($course->curriculum_credits ?? $course->course_credits ?? 0),
                    'ects_credits' => (int) ($course->curriculum_ects ?? $course->course_ects ?? $course->curriculum_credits ?? $course->course_credits ?? 0),
                    'category' => $course->curriculum_category ?? $course->course_category ?? 'Others',
                    'semester' => $course->semester ?? 'N/A',
                    'department_id' => $course->department_id,
                    'faculty_id' => $course->faculty_id,
                    'version' => $course->version,
                    'pre_requisite' => $course->pre_requisite ?? 'None',
                    'lecture_hours' => (int) ($course->lecture_hours ?? 0),
                    'lab_hours' => (int) ($course->lab_hours ?? 0),
                    'tutorial' => (int) ($course->tutorial ?? 0),
                    'source' => 'curriculum',
                    'has_curriculum_override' => true,
                ];
            });
        }

        // Fallback without version filter
        $fallbackQuery = DB::table('curriculums')
            ->join('courses', 'curriculums.course_id', '=', 'courses.id')
            ->where('curriculums.department_id', $student->department_id);
        
        $fallbackCourses = $fallbackQuery
            ->where(function($query) {
                $query->whereIn('courses.semester', ['1', '2', '3', '4', '5', '6', '7', '8'])
                      ->orWhere('courses.semester', 'REGEXP', '^[1-8]$');
            })
            ->whereNotIn('curriculums.course_category', ['AE', 'FE', 'UE'])
            ->select(
                'courses.id',
                'courses.code', 
                'courses.semester',
                'courses.department_id',
                'curriculums.title as curriculum_title',
                'curriculums.total_credits as curriculum_credits',
                'curriculums.ects as curriculum_ects',
                'curriculums.course_category as curriculum_category',
                'curriculums.pre_requisite',
                'curriculums.lecture_hours',
                'curriculums.lab_hours',
                'curriculums.tutorial',
                'curriculums.version',
                'curriculums.faculty_id',
                'courses.title as course_title',
                'courses.credits as course_credits',
                'courses.ects as course_ects',
                'courses.category as course_category'
            )
            ->orderBy('courses.semester')
            ->orderBy('courses.code')
            ->get();

        if ($fallbackCourses->isNotEmpty()) {
            return $fallbackCourses->map(function ($course) use ($curriculumVersion) {
                return [
                    'id' => $course->id,
                    'code' => $course->code,
                    'title' => $course->curriculum_title ?: $course->course_title,
                    'credits' => (int) ($course->curriculum_credits ?? $course->course_credits ?? 0),
                    'ects_credits' => (int) ($course->curriculum_ects ?? $course->course_ects ?? $course->curriculum_credits ?? $course->course_credits ?? 0),
                    'category' => $course->curriculum_category ?? $course->course_category ?? 'Others',
                    'semester' => $course->semester ?? 'N/A',
                    'department_id' => $course->department_id,
                    'faculty_id' => $course->faculty_id,
                    'version' => $course->version ?? $curriculumVersion,
                    'pre_requisite' => $course->pre_requisite ?? 'None',
                    'lecture_hours' => (int) ($course->lecture_hours ?? 0),
                    'lab_hours' => (int) ($course->lab_hours ?? 0),
                    'tutorial' => (int) ($course->tutorial ?? 0),
                    'source' => 'curriculum_fallback',
                    'has_curriculum_override' => true,
                ];
            });
        }

        // Final fallback to courses table
        $directCourses = Course::where('department_id', $student->department_id)
            ->where(function($query) {
                $query->whereIn('semester', ['1', '2', '3', '4', '5', '6', '7', '8'])
                      ->orWhere('semester', 'REGEXP', '^[1-8]$');
            })
            ->whereNotIn('category', ['AE', 'FE', 'UE'])
            ->orderBy('semester')
            ->orderBy('code')
            ->get();

        return $directCourses->map(function ($course) use ($curriculumVersion) {
            return [
                'id' => $course->id,
                'code' => $course->code,
                'title' => $course->title,
                'credits' => (int) ($course->credits ?? 0),
                'ects_credits' => (int) ($course->ects ?? $course->credits ?? 0),
                'category' => $course->category ?? 'Others',
                'semester' => $course->semester ?? 'N/A',
                'department_id' => $course->department_id,
                'faculty_id' => null,
                'version' => $curriculumVersion,
                'pre_requisite' => 'None',
                'lecture_hours' => 0,
                'lab_hours' => 0,
                'tutorial' => 0,
                'source' => 'course_fallback',
                'has_curriculum_override' => false,
            ];
        });
    }

    /**
     * Check graduation requirements for elective courses
     */
    private function checkGraduationRequirements($student, $transcripts)
    {
        $passingGrades = ['A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-'];
        $curriculumVersion = $this->determineCurriculumVersion($student);
        
        // Get all completed courses with their curriculum-based categories and ECTS
        $completedElectives = [
            'AE' => [], // Area Electives
            'FE' => [], // Faculty Electives  
            'UE' => []  // University Electives
        ];
        
        foreach ($transcripts as $transcript) {
            $grade = strtoupper(trim($transcript->grade));
            
            // Only count courses with passing grades
            if (!in_array($grade, $passingGrades)) {
                continue;
            }
            
            // Get curriculum-based course data
            $courseData = $this->getCourseWithCurriculumData($transcript->course, $student, $curriculumVersion);
            $category = strtoupper($courseData['category']);
            
            // Only process elective categories
            if (!in_array($category, ['AE', 'FE', 'UE'])) {
                continue;
            }
            
            $completedElectives[$category][] = [
                'code' => $courseData['code'],
                'title' => $courseData['title'],
                'ects_credits' => $courseData['ects_credits'],
                'credits' => $courseData['credits'],
                'grade' => $grade,
                'semester' => $transcript->semester,
                'source' => $courseData['source']
            ];
        }
        
        // Define graduation requirements
        $requirements = [
            'AE' => ['min_courses' => 4, 'min_ects_per_course' => 6],
            'FE' => ['min_courses' => 4, 'min_ects_per_course' => 5],
            'UE' => ['min_courses' => 4, 'min_ects_per_course' => 4],
        ];
        
        $graduationStatus = [];
        $overallStatus = true;
        $verificationResults = [];
        
        foreach ($requirements as $category => $requirement) {
            $completed = $completedElectives[$category];
            
            // CHANGED: Count ALL completed courses in this category
            $totalCompletedCount = count($completed);
            
            // Separate courses by ECTS compliance
            $validCourses = array_filter($completed, function($course) use ($requirement) {
                return $course['ects_credits'] >= $requirement['min_ects_per_course'];
            });
            
            $invalidCourses = array_filter($completed, function($course) use ($requirement) {
                return $course['ects_credits'] < $requirement['min_ects_per_course'];
            });
            
            $validCount = count($validCourses);
            $invalidCount = count($invalidCourses);
            $totalECTS = array_sum(array_column($completed, 'ects_credits')); // Total from all courses
            $validECTS = array_sum(array_column($validCourses, 'ects_credits')); // Only from valid courses
            
            // CHANGED: Base compliance on total completed courses, not just valid ECTS ones
            $isCompliant = $totalCompletedCount >= $requirement['min_courses'];
            
            // CHANGED: Verification considers both course count AND ECTS requirements
            $hasEnoughCourses = $totalCompletedCount >= $requirement['min_courses'];
            $hasValidECTS = $validCount >= $requirement['min_courses']; // All courses should meet ECTS requirement
            $isVerified = $hasEnoughCourses && $hasValidECTS;
            
            if (!$isCompliant) {
                $overallStatus = false;
            }
            
            // Create verification result
            $verificationResults[$category] = [
                'category' => $category,
                'category_name' => $this->getCategoryName($category),
                'is_verified' => $isVerified,
                'verification_status' => $isVerified ? 'VERIFIED ✅' : 'NOT VERIFIED ❌',
                'required_courses' => $requirement['min_courses'],
                'completed_courses' => $totalCompletedCount, // CHANGED: Show total completed
                'valid_ects_courses' => $validCount, // NEW: Show how many meet ECTS requirement
                'remaining_courses' => max(0, $requirement['min_courses'] - $totalCompletedCount),
                'progress_percentage' => round(($totalCompletedCount / $requirement['min_courses']) * 100, 1),
                'verification_message' => $this->getVerificationMessage($category, $totalCompletedCount, $validCount, $requirement, $isVerified)
            ];
            
            $graduationStatus[$category] = [
                'category_name' => $this->getCategoryName($category),
                'requirement' => [
                    'min_courses' => $requirement['min_courses'],
                    'min_ects_per_course' => $requirement['min_ects_per_course'],
                    'description' => "At least {$requirement['min_courses']} courses with minimum {$requirement['min_ects_per_course']} ECTS each"
                ],
                'verification' => [
                    'is_verified' => $isVerified,
                    'status' => $isVerified ? 'VERIFIED ✅' : 'NOT VERIFIED ❌',
                    'progress' => "{$totalCompletedCount}/{$requirement['min_courses']} courses completed", // CHANGED
                    'progress_percentage' => round(($totalCompletedCount / $requirement['min_courses']) * 100, 1),
                    'ects_compliance' => "{$validCount}/{$totalCompletedCount} courses meet ECTS requirement", // NEW
                    'message' => $this->getVerificationMessage($category, $totalCompletedCount, $validCount, $requirement, $isVerified)
                ],
                'current_status' => [
                    'total_courses_taken' => $totalCompletedCount, // CHANGED
                    'valid_courses_count' => $validCount,
                    'invalid_courses_count' => $invalidCount,
                    'total_ects' => $totalECTS, // CHANGED: Total ECTS from all courses
                    'valid_ects' => $validECTS, // NEW: ECTS from valid courses only
                    'is_compliant' => $isCompliant,
                    'missing_courses' => max(0, $requirement['min_courses'] - $totalCompletedCount),
                    'courses_needing_higher_ects' => $invalidCount // NEW
                ],
                'completed_courses' => array_values($completed), // CHANGED: Show ALL completed courses
                'valid_ects_courses' => array_values($validCourses), // NEW: Courses that meet ECTS requirement
                'insufficient_ects_courses' => array_values($invalidCourses),
                'status_message' => $this->getElectiveStatusMessage($category, $totalCompletedCount, $validCount, $requirement, $totalECTS),
                'available_courses' => $this->getAvailableElectives($student, $transcripts, $category, $requirement['min_ects_per_course'])
            ];
        }
        
        // Calculate overall verification status
        $totalVerified = array_sum(array_column($verificationResults, 'is_verified'));
        $overallVerified = $totalVerified === 3; // All 3 categories must be verified
        
        return [
            'overall_graduation_eligible' => $overallStatus,
            'overall_verified' => $overallVerified,
            'verification_summary' => [
                'status' => $overallVerified ? 'ALL ELECTIVES VERIFIED ✅' : 'ELECTIVES NOT VERIFIED ❌',
                'verified_categories' => $totalVerified,
                'total_categories' => 3,
                'verification_percentage' => round(($totalVerified / 3) * 100, 1),
                'message' => $overallVerified 
                    ? '🎓 Student has completed all required elective courses'
                    : "⚠️ Student needs to complete {$this->getMissingCategoriesText($verificationResults)}",
                'categories' => $verificationResults
            ],
            'elective_requirements' => $graduationStatus,
            'summary' => $this->getGraduationSummary($graduationStatus, $overallStatus)
        ];
    }

    /**
     * Get verification message for each category - UPDATED
     */
    private function getVerificationMessage($category, $totalCompleted, $validCount, $requirement, $isVerified)
    {
        $categoryName = $this->getCategoryName($category);
        $required = $requirement['min_courses'];
        $minECTS = $requirement['min_ects_per_course'];
        
        if ($totalCompleted >= $required && $validCount >= $required) {
            return "✅ VERIFIED: {$totalCompleted}/{$required} {$categoryName} courses completed, all meet {$minECTS} ECTS requirement";
        } elseif ($totalCompleted >= $required && $validCount < $required) {
            $needsBetterECTS = $totalCompleted - $validCount;
            return "⚠️ PARTIALLY COMPLETE: {$totalCompleted}/{$required} courses completed, but {$needsBetterECTS} course(s) need higher ECTS (min {$minECTS} each)";
        } else {
            $missing = $required - $totalCompleted;
            return "❌ NOT COMPLETE: Need {$missing} more {$categoryName} course(s). Current: {$totalCompleted}/{$required}";
        }
    }

    /**
     * Get status message for each elective category - UPDATED
     */
    private function getElectiveStatusMessage($category, $totalCompleted, $validCount, $requirement, $totalECTS)
    {
        $categoryName = $this->getCategoryName($category);
        $required = $requirement['min_courses'];
        $minECTS = $requirement['min_ects_per_course'];
        
        if ($totalCompleted >= $required && $validCount >= $required) {
            return "✅ COMPLIANT: {$totalCompleted}/{$required} {$categoryName} courses completed ({$totalECTS} total ECTS)";
        } elseif ($totalCompleted >= $required && $validCount < $required) {
            $needsBetterECTS = $totalCompleted - $validCount;
            return "⚠️ COURSES COMPLETE, ECTS ISSUE: {$totalCompleted}/{$required} courses done, but {$needsBetterECTS} need higher ECTS";
        } else {
            $missing = $required - $totalCompleted;
            return "❌ NOT COMPLIANT: Need {$missing} more {$categoryName} courses with minimum {$minECTS} ECTS each";
        }
    }

    /**
     * Get text for missing categories
     */
    private function getMissingCategoriesText($verificationResults)
    {
        $missing = [];
        foreach ($verificationResults as $result) {
            if (!$result['is_verified']) {
                $remaining = $result['remaining_courses'];
                $categoryName = $result['category_name'];
                $missing[] = "{$remaining} more {$categoryName} course" . ($remaining > 1 ? 's' : '');
            }
        }
        
        if (count($missing) === 1) {
            return $missing[0];
        } elseif (count($missing) === 2) {
            return implode(' and ', $missing);
        } else {
            return implode(', ', array_slice($missing, 0, -1)) . ', and ' . end($missing);
        }
    }



    /**
     * Get overall graduation summary
     */
    private function getGraduationSummary($graduationStatus, $overallStatus)
    {
        $summary = [
            'overall_status' => $overallStatus ? 'ELIGIBLE' : 'NOT ELIGIBLE',
            'overall_message' => $overallStatus 
                ? '🎓 Student meets all elective graduation requirements' 
                : '⚠️ Student does not meet elective graduation requirements',
            'details' => []
        ];
        
        foreach ($graduationStatus as $category => $status) {
            $summary['details'][] = [
                'category' => $category,
                'category_name' => $status['category_name'],
                'status' => $status['current_status']['is_compliant'] ? 'COMPLETE' : 'INCOMPLETE',
                'progress' => "{$status['current_status']['valid_courses_count']}/{$status['requirement']['min_courses']} courses",
                'total_ects' => $status['current_status']['total_ects']
            ];
        }
        
        return $summary;
    }

    /**
     * Get available elective courses for remaining requirements
     */
    private function getAvailableElectives($student, $transcripts, $category, $minECTS)
    {
        $curriculumVersion = $this->determineCurriculumVersion($student);
        $takenCourseCodes = [];
        
        // Get all course codes that have been taken (regardless of grade)
        foreach ($transcripts as $transcript) {
            $courseCode = trim(strtoupper($transcript->course->code ?? ''));
            if ($courseCode) {
                $takenCourseCodes[] = $courseCode;
            }
        }
        
        // Get all available elective courses for this category
        $query = DB::table('curriculums')
            ->join('courses', 'curriculums.course_id', '=', 'courses.id')
            ->where('curriculums.department_id', $student->department_id)
            ->where('curriculums.version', $curriculumVersion)
            ->where('curriculums.course_category', $category)
            ->where('curriculums.ects', '>=', $minECTS) // Only courses that meet ECTS requirement
            ->whereNotIn('courses.code', $takenCourseCodes) // Exclude already taken courses
            ->select(
                'courses.id',
                'courses.code',
                'courses.title', 
                'courses.semester',
                'curriculums.ects as curriculum_ects',
                'curriculums.total_credits as curriculum_credits',
                'curriculums.course_category',
                'curriculums.pre_requisite'
            )
            ->orderBy('curriculums.ects', 'desc') // Show highest ECTS first
            ->orderBy('courses.code')
            ->get();
        
        return $query->map(function($course) {
            return [
                'code' => $course->code,
                'title' => $course->title,
                'ects_credits' => (int) $course->curriculum_ects,
                'credits' => (int) $course->curriculum_credits,
                'category' => $course->course_category,
                'semester' => $course->semester ?? 'Elective',
                'pre_requisite' => $course->pre_requisite ?? 'None',
                'color' => $this->getCategoryColor($course->course_category)
            ];
        });
    }

    /**
     * Determine curriculum version with enhanced logic
     */
    private function determineCurriculumVersion($student)
    {
        if ($student->entry_date) {
            $entryYear = date('Y', strtotime($student->entry_date));
            return $entryYear >= 2021 ? 'New' : 'Old';
        }
        
        $studentNumber = $student->student_number;
        if ($studentNumber && strlen($studentNumber) >= 2) {
            $prefix = substr($studentNumber, 0, 2);
            
            if (in_array($prefix, ['19', '20'])) {
                return 'Old';
            } elseif (in_array($prefix, ['21', '22', '23', '24', '25', '26', '27', '28', '29', '30'])) {
                return 'New';
            }
        }
        
        if ($student->transcripts && $student->transcripts->isNotEmpty()) {
            $firstSemester = $student->transcripts->sortBy('semester')->first()->semester ?? '';
            
            if (preg_match('/(\d{4})/', $firstSemester, $matches)) {
                $year = (int)$matches[1];
                return $year >= 2021 ? 'New' : 'Old';
            }
        }
        
        return 'Old';
    }

    /**
     * Get category priority for sorting
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
     * Get category full name
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

    /**
     * Convert grade to grade point
     */
    private function gradeToPoint($grade)
    {
        return match (strtoupper($grade)) {
            'A' => 4.00,
            'A-' => 3.70,
            'B+' => 3.30,
            'B' => 3.00,
            'B-' => 2.70,
            'C+' => 2.30,
            'C' => 2.00,
            'C-' => 1.70,
            'D+' => 1.30,
            'D' => 1.00,
            'D-' => 0.70,
            'F' => 0.00,
            'FF' => 0.00,
            'NG', 'W', 'S', 'I', 'U', 'P', 'E', 'TS', 'T1', 'CS', 'H', 'PS', 'TU', 'TR', 'T', 'P0', 'TP', 'TF' => null,
            default => 0.00,
        };
    }

    /**
     * Get category color
     */
    private function getCategoryColor($category)
    {
        return match (strtoupper($category)) {
            'AC' => '#1e90ff', // Blue
            'AE' => '#4caf50', // Green
            'UC' => '#9c27b0', // Purple
            'FC' => '#f44336', // Red
            'FE' => '#ff9800', // Orange
            'UE' => '#00bcd4', // Cyan
            default => '#9e9e9e', // Gray for Others
        };
    }

    /**
     * Export transcript as PDF - CURRICULUM-BASED DATA
     */
    public function exportPdf($studentNumber)
    {
        $student = Student::where('student_number', $studentNumber)->firstOrFail();
        $records = $student->transcripts()->with('course')->get();
        $curriculumVersion = $this->determineCurriculumVersion($student);

        $sortedGrouped = $this->sortSemesters($records);
        
        $grouped = [];
        $grandTotalCredits = 0;
        $grandTotalGradePoints = 0;
        $grandTotalECTS = 0;
        
        foreach ($sortedGrouped as $semester => $semesterRecords) {
            $semesterData = [
                'courses' => [],
                'total_credits' => 0,
                'total_credits_attempted' => 0,
                'total_ects' => 0,
                'grade_points' => 0
            ];

            foreach ($semesterRecords as $record) {
                // Get curriculum-based course data for PDF export
                $courseData = $this->getCourseWithCurriculumData($record->course, $student, $curriculumVersion);
                $gradePoint = $this->gradeToPoint($record->grade);
                
                $courseInfo = [
                    'code' => $courseData['code'],
                    'title' => $courseData['title'],
                    'grade' => $record->grade,
                    'credits' => $courseData['credits'], // From curriculum
                    'ects_credits' => $courseData['ects_credits'], // From curriculum
                    'category' => $courseData['category'], // From curriculum
                    'status' => in_array($record->grade, ["A", "A-", "B+", "B", "B-", "C+", "C", "C-", "D+", "D", "D-"]) ? 'Passed' : 'Failed',
                    'source' => $courseData['source'],
                ];
                
                $semesterData['courses'][] = $courseInfo;
                $semesterData['total_ects'] += $courseData['ects_credits'];
                $semesterData['total_credits_attempted'] += $courseData['credits'];
                
                if ($gradePoint !== null) {
                    $points = $gradePoint * $courseData['credits'];
                    $semesterData['grade_points'] += $points;
                    $semesterData['total_credits'] += $courseData['credits'];
                }
            }

            $semesterData['gpa'] = $semesterData['total_credits'] > 0 ? 
                number_format($semesterData['grade_points'] / $semesterData['total_credits'], 2) : '0.00';
            
            $grouped[$semester] = $semesterData;
            $grandTotalCredits += $semesterData['total_credits'];
            $grandTotalGradePoints += $semesterData['grade_points'];
            $grandTotalECTS += $semesterData['total_ects'];
        }

        $cumulativeGPA = $grandTotalCredits ? number_format($grandTotalGradePoints / $grandTotalCredits, 2) : '0.00';

        $pdf = Pdf::loadView('transcripts.pdf', [
            'student' => $student,
            'transcripts' => $grouped,
            'cumulativeGPA' => $cumulativeGPA,
            'totalCredits' => $grandTotalCredits,
            'totalECTS' => $grandTotalECTS,
            'totalGradePoints' => number_format($grandTotalGradePoints, 2),
            'curriculumVersion' => $curriculumVersion,
            'faculty' => 'N/A',
            'department' => 'N/A',
        ]);

        return $pdf->download("transcript_{$studentNumber}.pdf");
    }

    /**
     * Export transcript as Excel - CURRICULUM-BASED DATA
     */
    public function exportExcel($studentNumber)
    {
        try {
            return Excel::download(new TranscriptExport($studentNumber), "transcript_{$studentNumber}.xlsx");
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating Excel file',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}