<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Transcript;
use App\Models\Course;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TranscriptExport;

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
            $semesterCredits = 0; // ALL credits (including NG, E, etc.)
            $semesterCreditsEarned = 0; // Only passed courses
            $semesterECTS = 0;
            $courses = [];

            foreach ($entries as $entry) {
                // Use credits column for both ECTS and Credits if ects_credits doesn't exist
                $ectsCredits = $entry->course->ects_credits ?? $entry->course->credits ?? 0;
                $credits = $entry->course->credits ?? 0; // Actual credits for GPA
                $gradePoint = $this->gradeToPoint($entry->grade);
                
                // Calculate individual course grade points
                $courseGradePoints = 0;
                $countsInGPA = true;
                $isEarned = false;
                
                // ALWAYS add credits to semester totals, regardless of grade
                $semesterCredits += $credits; // Include ALL courses in credit calculation
                $semesterECTS += $ectsCredits; // Include ALL courses in ECTS calculation
                
                if ($gradePoint === null) {
                    // Special grades like NG, E still count toward total credits and GPA calculation with 0 points
                    $countsInGPA = true; // Changed: NG grades DO count in GPA calculation
                    $courseGradePoints = 0; // Show 0.00 for NG grades
                    $semesterGradePoints += 0; // Add 0 points to semester total
                } else {
                    $courseGradePoints = $credits * $gradePoint;
                    $semesterGradePoints += $courseGradePoints;
                    
                    // Check if credits are "earned" (passing grade)
                    if ($gradePoint > 0) { // Anything above F is considered earned
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
                    'grade_points' => number_format($courseGradePoints, 2, '.', ''), // Use dot for frontend consistency
                    'category' => $entry->course->category ?? 'Others',
                    'color' => $this->getCategoryColor($entry->course->category ?? 'Others'),
                    'counts_in_gpa' => $countsInGPA,
                    'is_earned' => $isEarned,
                ];
            }

            // Calculate semester GPA using ALL credits (including NG with 0 points) - use truncation (floor) like the sample
            $semesterGPA = $semesterCredits > 0 ? floor(($semesterGradePoints / $semesterCredits) * 100) / 100 : 0.00;
            
            // Update grand totals
            $grandTotalGradePoints += $semesterGradePoints;
            $grandTotalCredits += $semesterCredits; // ALL credits (including NG, E)
            $grandTotalCreditsEarned += $semesterCreditsEarned; // Only earned credits
            $grandTotalECTS += $semesterECTS;
            
            // Calculate cumulative GPA using ALL credits - use truncation (floor) like the sample
            $cumulativeGPA = $grandTotalCredits > 0 ? floor(($grandTotalGradePoints / $grandTotalCredits) * 100) / 100 : 0.00;

            $structuredTranscript[] = [
                'semester' => $semester,
                'courses' => $courses,
                'semester_gpa' => number_format($semesterGPA, 2, '.', ''),
                'semester_credits' => $semesterCredits, // Credits attempted (for GPA calculation)
                'semester_credits_earned' => $semesterCreditsEarned, // Credits earned (passed)
                'semester_ects' => $semesterECTS,
                'semester_grade_points' => number_format($semesterGradePoints, 2, '.', ''),
                'cumulative_gpa' => number_format($cumulativeGPA, 2, '.', ''),
                'grand_total_credits' => $grandTotalCredits, // Total attempted
                'grand_total_credits_earned' => $grandTotalCreditsEarned, // Total earned
                'grand_total_ects' => $grandTotalECTS,
                'grand_total_grade_points' => number_format($grandTotalGradePoints, 2, '.', ''),
            ];
        }

        // ✅ FIXED: Determine remaining courses - MATCH BY COURSE CODE (more reliable)
        
        // Get course codes and their latest grades
        $courseCodeGrades = [];
        foreach ($transcripts as $transcript) {
            $courseCode = $transcript->course->code ?? null;
            $grade = strtoupper($transcript->grade);
            
            if ($courseCode) {
                // Keep the latest grade for each course code (handles retakes)
                $courseCodeGrades[$courseCode] = $grade;
            }
        }
        
        // Define passing grades
        $passingGrades = ['A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-'];
        $failingGrades = ['F', 'FF'];
        
        // Categorize course codes
        $passedCourseCodes = [];
        $failedCourseCodes = [];
        
        foreach ($courseCodeGrades as $courseCode => $grade) {
            if (in_array($grade, $passingGrades)) {
                $passedCourseCodes[] = $courseCode;
            } elseif (in_array($grade, $failingGrades)) {
                $failedCourseCodes[] = $courseCode;
            }
        }
        
        // Determine curriculum version
        $studentNumberPrefix = substr($studentNumber, 0, 2);
        $curriculumVersion = in_array($studentNumberPrefix, ['19', '20']) ? 'old' : 'new';
        
        \Log::info('=== REMAINING COURSES DEBUG ===');
        \Log::info('Student: ' . $studentNumber . ' | Version: ' . $curriculumVersion);
        \Log::info('Course codes attempted: ' . count($courseCodeGrades));
        \Log::info('Passed course codes: ' . json_encode($passedCourseCodes));
        \Log::info('Failed course codes: ' . json_encode($failedCourseCodes));
        
        // Get all curriculum courses
        $curriculumQuery = Course::where('department_id', $student->department_id);
        if (\Schema::hasColumn('courses', 'version')) {
            $curriculumQuery->where('version', $curriculumVersion);
        }
        $allCurriculumCourses = $curriculumQuery->get();
        
        \Log::info('Total curriculum courses found: ' . $allCurriculumCourses->count());
        
        // Build remaining courses list - MATCH BY COURSE CODE
        $remainingCourses = collect();
        
        foreach ($allCurriculumCourses as $course) {
            $courseCode = $course->code;
            
            // Skip if already passed this course code
            if (in_array($courseCode, $passedCourseCodes)) {
                \Log::debug('Skipping passed course: ' . $courseCode);
                continue;
            }
            
            // Determine status
            $status = 'Not Taken';
            $isRetake = false;
            
            if (array_key_exists($courseCode, $courseCodeGrades)) {
                $grade = $courseCodeGrades[$courseCode];
                if (in_array($grade, $failingGrades)) {
                    $status = 'Retake Required (Failed: ' . $grade . ')';
                    $isRetake = true;
                } else {
                    // Has some other grade (NG, W, etc.)
                    $status = 'Retake Required (' . $grade . ')';
                    $isRetake = true;
                }
            }
            
            $remainingCourses->push([
                'code' => $course->code,
                'title' => $course->title,
                'credits' => $course->credits,
                'ects_credits' => $course->ects_credits ?? $course->credits,
                'category' => $course->category,
                'semester' => $course->semester,
                'department_id' => $course->department_id,
                'version' => $course->version ?? $curriculumVersion,
                'status' => $status,
                'is_retake' => $isRetake,
            ]);
        }
        
        \Log::info('Final remaining courses: ' . $remainingCourses->count());
        \Log::info('Retakes: ' . $remainingCourses->where('is_retake', true)->count());
        \Log::info('Not taken: ' . $remainingCourses->where('is_retake', false)->count());

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

    private function gradeToPoint($grade)
    {
        return match (strtoupper($grade)) {
            // Standard letter grades with points (matching sample transcript)
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
            
            // Special grades that don't count toward GPA (return null)
            'NG' => null,    // No Grade - doesn't count in GPA
            'W' => null,     // Withdrawal
            'S' => null,     // Satisfactory (Pass/No Pass)
            'I' => null,     // Incomplete
            'U' => null,     // Unsatisfactory
            'P' => null,     // Pass
            'E' => null,     // Exempt
            'TS' => null,    // Transfer Student
            'T1' => null,    // Transfer 1
            'CS' => null,    // Credit by Special Exam
            'H' => null,     // Exempt
            'PS' => null,    // Pass
            'TU' => null,    // Transfer U
            'TR' => null,    // Transfer
            'T' => null,     // Transfer
            'P0' => null,    // Pass 0
            'TP' => null,    // Transfer Pass
            'TF' => null,    // Transfer Fail
            
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
            
            // Only count grades that contribute to GPA
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