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

class TranscriptController extends Controller
{
    public function getTranscript($studentNumber)
    {
        $student = Student::where('student_number', $studentNumber)->first();

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $transcripts = $student->transcripts()->with('course')->orderBy('semester')->get();
        $grouped = $transcripts->groupBy('semester');

        $structuredTranscript = [];
        $grandTotalGradePoints = 0;
        $grandTotalCredits = 0;
        $grandTotalECTS = 0;
        $grandTotalCreditsEarned = 0;

        foreach ($grouped as $semester => $entries) {
            $semesterGradePoints = 0;
            $semesterCredits = 0;
            $semesterCreditsEarned = 0;
            $semesterECTS = 0;
            $courses = [];

            foreach ($entries as $entry) {
                $ectsCredits = $entry->course->ects_credits ?? $entry->course->credits ?? 0;
                $credits = $entry->course->credits ?? 0;
                $gradePoint = $this->gradeToPoint($entry->grade);
                
                $courseGradePoints = 0;
                $countsInGPA = true;
                $isEarned = false;
                
                $semesterCredits += $credits;
                $semesterECTS += $ectsCredits;
                
                if ($gradePoint === null) {
                    $countsInGPA = true;
                    $courseGradePoints = 0;
                    $semesterGradePoints += 0;
                } else {
                    $courseGradePoints = $credits * $gradePoint;
                    $semesterGradePoints += $courseGradePoints;
                    
                    if ($gradePoint > 0) {
                        $isEarned = true;
                        $semesterCreditsEarned += $credits;
                    }
                }

                $courses[] = [
                    'code' => $entry->course->code,
                    'title' => $entry->course->title,
                    'grade' => $entry->grade,
                    'ects_credits' => $ectsCredits,
                    'credits' => $credits,
                    'grade_points' => number_format($courseGradePoints, 2, '.', ''),
                    'category' => $entry->course->category ?? 'Others',
                    'color' => $this->getCategoryColor($entry->course->category ?? 'Others'),
                    'counts_in_gpa' => $countsInGPA,
                    'is_earned' => $isEarned,
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

        return response()->json([
            'student' => [
                'name' => $student->name,
                'studentNumber' => $student->student_number,
                'departmentId' => $student->department_id,
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
        ]);
    }

    /**
     * Get remaining courses from student's department only
     */
    private function getRemainingCourses($student, $transcripts)
    {
        // Get course codes and their latest grades
        $courseCodeGrades = [];
        
        foreach ($transcripts as $transcript) {
            $courseCode = trim(strtoupper($transcript->course->code ?? ''));
            $grade = strtoupper(trim($transcript->grade));
            
            if ($courseCode && $grade) {
                if (!isset($courseCodeGrades[$courseCode])) {
                    $courseCodeGrades[$courseCode] = [];
                }
                $courseCodeGrades[$courseCode][] = $grade;
            }
        }

        // Get the latest grade for each course
        $finalCourseGrades = [];
        foreach ($courseCodeGrades as $courseCode => $grades) {
            $latestIndex = count($grades) - 1;
            $finalCourseGrades[$courseCode] = $grades[$latestIndex];
        }
        
        // Define grade categories
        $passingGrades = ['A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-'];
        $failingGrades = ['F', 'FF'];
        $nonGpaGrades = ['NG', 'W', 'S', 'I', 'U', 'P', 'E', 'TS', 'T1', 'CS', 'H', 'PS', 'TU', 'TR', 'T', 'P0', 'TP', 'TF'];
        
        // Get passed course codes
        $passedCourseCodes = [];
        foreach ($finalCourseGrades as $courseCode => $grade) {
            if (in_array($grade, $passingGrades)) {
                $passedCourseCodes[] = $courseCode;
            }
        }
        
        // Get curriculum courses from student's department only
        $curriculumVersion = $this->determineCurriculumVersion($student);
        $curriculumCourses = $this->getCurriculumCourses($student, $curriculumVersion);
        
        // Build remaining courses list
        $remainingCourses = collect();
        
        foreach ($curriculumCourses as $course) {
            $courseCode = trim(strtoupper($course->code));
            
            // Skip if already passed
            if (in_array($courseCode, $passedCourseCodes)) {
                continue;
            }
            
            // Determine status
            $status = 'Not Taken';
            $isRetake = false;
            $lastGrade = null;
            
            if (array_key_exists($courseCode, $finalCourseGrades)) {
                $grade = $finalCourseGrades[$courseCode];
                $lastGrade = $grade;
                
                if (in_array($grade, $failingGrades)) {
                    $status = 'Retake Required (Failed: ' . $grade . ')';
                    $isRetake = true;
                } elseif (in_array($grade, $nonGpaGrades)) {
                    $status = 'Retake Required (' . $grade . ')';
                    $isRetake = true;
                } else {
                    $status = 'In Progress (' . $grade . ')';
                    $isRetake = true;
                }
            }
            
            $remainingCourses->push([
                'code' => $course->code,
                'title' => $course->title,
                'credits' => $course->credits,
                'ects_credits' => $course->ects_credits ?? $course->credits,
                'category' => $course->category ?? 'Others',
                'semester' => $course->semester ?? 'N/A',
                'department_id' => $course->department_id,
                'version' => $course->version ?? $curriculumVersion,
                'status' => $status,
                'is_retake' => $isRetake,
                'last_grade' => $lastGrade,
                'color' => $this->getCategoryColor($course->category ?? 'Others'),
            ]);
        }
        
        // Sort by semester and category
        return $remainingCourses->sortBy([
            ['semester', 'asc'],
            ['category', 'asc'],
            ['code', 'asc']
        ])->values();
    }

    /**
     * Get curriculum courses from student's department only
     */
    private function getCurriculumCourses($student, $curriculumVersion)
    {
        // Method 1: Try using curriculums table with version filtering (preferred)
        $curriculumCourses = DB::table('curriculums')
            ->join('courses', 'curriculums.course_id', '=', 'courses.id')
            ->where('curriculums.department_id', $student->department_id)
            ->where('curriculums.version', $curriculumVersion) // Add version filter
            ->select(
                'courses.id',
                'courses.code', 
                'courses.title',
                'courses.credits',
                'courses.category',
                'courses.semester',
                'courses.ects',
                'courses.department_id',
                'curriculums.version'
            )
            ->get();

        if ($curriculumCourses->isNotEmpty()) {
            // Convert to Course models for consistency
            return $curriculumCourses->map(function ($course) {
                $courseModel = new Course();
                $courseModel->id = $course->id;
                $courseModel->code = $course->code;
                $courseModel->title = $course->title;
                $courseModel->credits = $course->credits;
                $courseModel->category = $course->category;
                $courseModel->semester = $course->semester;
                $courseModel->ects_credits = $course->ects; // Map ects to ects_credits
                $courseModel->department_id = $course->department_id;
                $courseModel->version = $course->version;
                return $courseModel;
            });
        }

        // Method 2: Try curriculums table without version filter (in case version column is empty)
        $curriculumCoursesNoVersion = DB::table('curriculums')
            ->join('courses', 'curriculums.course_id', '=', 'courses.id')
            ->where('curriculums.department_id', $student->department_id)
            ->select(
                'courses.id',
                'courses.code', 
                'courses.title',
                'courses.credits',
                'courses.category',
                'courses.semester',
                'courses.ects',
                'courses.department_id',
                'curriculums.version'
            )
            ->get();

        if ($curriculumCoursesNoVersion->isNotEmpty()) {
            return $curriculumCoursesNoVersion->map(function ($course) {
                $courseModel = new Course();
                $courseModel->id = $course->id;
                $courseModel->code = $course->code;
                $courseModel->title = $course->title;
                $courseModel->credits = $course->credits;
                $courseModel->category = $course->category;
                $courseModel->semester = $course->semester;
                $courseModel->ects_credits = $course->ects;
                $courseModel->department_id = $course->department_id;
                $courseModel->version = $course->version ?? $curriculumVersion;
                return $courseModel;
            });
        }

        // Method 3: Fallback to courses table directly with department filter
        return Course::where('department_id', $student->department_id)->get();
    }

    /**
     * Determine curriculum version
     */
    private function determineCurriculumVersion($student)
    {
        // Strategy 1: Use student's entry_date if available
        if ($student->entry_date) {
            $entryYear = date('Y', strtotime($student->entry_date));
            return $entryYear >= 2021 ? 'new' : 'old';
        }
        
        // Strategy 2: Use student number prefix (more accurate for Turkish system)
        $studentNumber = $student->student_number;
        if ($studentNumber && strlen($studentNumber) >= 2) {
            $prefix = substr($studentNumber, 0, 2);
            
            // Students starting with 19, 20 are old curriculum
            if (in_array($prefix, ['19', '20'])) {
                return 'old';
            }
            // Students starting with 21, 22, 23, 24, 25 are new curriculum
            elseif (in_array($prefix, ['21', '22', '23', '24', '25'])) {
                return 'new';
            }
        }
        
        // Strategy 3: Check first semester in transcript to determine year
        if ($student->transcripts && $student->transcripts->isNotEmpty()) {
            $firstSemester = $student->transcripts->sortBy('semester')->first()->semester ?? '';
            
            // Extract year from semester format (e.g., "2019-2020 Fall" -> 2019)
            if (preg_match('/(\d{4})/', $firstSemester, $matches)) {
                $year = (int)$matches[1];
                return $year >= 2021 ? 'new' : 'old';
            }
        }
        
        // Default based on current year - if before 2021, assume old
        return 'old'; // Changed default to 'old' for safety
    }

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
            
            // Special grades that don't count toward GPA
            'NG', 'W', 'S', 'I', 'U', 'P', 'E', 'TS', 'T1', 'CS', 'H', 'PS', 'TU', 'TR', 'T', 'P0', 'TP', 'TF' => null,
            
            default => 0.00,
        };
    }

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

    public function exportPdf($studentNumber)
    {
        $student = Student::where('student_number', $studentNumber)->firstOrFail();
        $records = $student->transcripts()->with('course')->get();
    
        $grouped = [];
        $grandTotalCredits = 0;
        $grandTotalGradePoints = 0;
        $grandTotalECTS = 0;
        
        foreach ($records as $record) {
            $semester = $record->semester;
            $grade = $record->grade;
            $credits = $record->course->credits ?? 0;
            $ectsCredits = $record->course->ects_credits ?? 0;
            $gradePoint = $this->gradeToPoint($grade);
            
            $courseData = [
                'code' => $record->course->code,
                'title' => $record->course->title,
                'grade' => $grade,
                'credits' => $credits,
                'ects_credits' => $ectsCredits,
                'status' => in_array($grade, ["A", "A-", "B+", "B", "B-", "C+", "C", "C-", "D+", "D", "D-"]) ? 'Passed' : 'Failed',
            ];
            
            $grouped[$semester]['courses'][] = $courseData;
            $grouped[$semester]['total_ects'] = ($grouped[$semester]['total_ects'] ?? 0) + $ectsCredits;
            $grouped[$semester]['total_credits_attempted'] = ($grouped[$semester]['total_credits_attempted'] ?? 0) + $credits;
            
            if ($gradePoint !== null) {
                $points = $gradePoint * $credits;
                $grouped[$semester]['grade_points'] = ($grouped[$semester]['grade_points'] ?? 0) + $points;
                $grouped[$semester]['total_credits'] = ($grouped[$semester]['total_credits'] ?? 0) + $credits;
            }
        }
    
        foreach ($grouped as $sem => &$data) {
            $data['gpa'] = ($data['total_credits'] ?? 0) > 0 ? 
                number_format($data['grade_points'] / $data['total_credits'], 2) : '0.00';
            $grandTotalCredits += ($data['total_credits'] ?? 0);
            $grandTotalGradePoints += ($data['grade_points'] ?? 0);
            $grandTotalECTS += ($data['total_ects'] ?? 0);
        }
    
        $cumulativeGPA = $grandTotalCredits ? number_format($grandTotalGradePoints / $grandTotalCredits, 2) : '0.00';
    
        $pdf = Pdf::loadView('transcripts.pdf', [
            'student' => $student,
            'transcripts' => $grouped,
            'cumulativeGPA' => $cumulativeGPA,
            'totalCredits' => $grandTotalCredits,
            'totalECTS' => $grandTotalECTS,
            'totalGradePoints' => number_format($grandTotalGradePoints, 2, ',', '')
        ]);
    
        return $pdf->download("transcript_{$studentNumber}.pdf");
    }

    public function exportExcel($studentNumber)
    {
        return Excel::download(new TranscriptExport($studentNumber), "transcript_{$studentNumber}.xlsx");
    }
}