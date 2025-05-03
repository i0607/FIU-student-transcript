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
        $cumulativePoints = 0;
        $cumulativeCredits = 0;

        foreach ($grouped as $semester => $entries) {
            $semesterPoints = 0;
            $semesterCredits = 0;
            $courses = [];

            foreach ($entries as $entry) {
                $credit = $entry->course->credits ?? 0;
                $gradePoint = $this->gradeToPoint($entry->grade);
                $points = $credit * $gradePoint;

                $semesterPoints += $points;
                $semesterCredits += $credit;

                $courses[] = [
                    'code' => $entry->course->code,
                    'title' => $entry->course->title,
                    'grade' => $entry->grade,
                    'credits' => $credit,
                    'category' => $entry->course->category ?? 'Others',
                    'color' => $this->getCategoryColor($entry->course->category ?? 'Others'),
                ];
            }

            $gpa = $semesterCredits > 0 ? round($semesterPoints / $semesterCredits, 2) : null;
            $cumulativePoints += $semesterPoints;
            $cumulativeCredits += $semesterCredits;
            $cumulativeGpa = $cumulativeCredits > 0 ? round($cumulativePoints / $cumulativeCredits, 2) : null;

            $structuredTranscript[] = [
                'semester' => $semester,
                'gpa' => $gpa,
                'cumulative_gpa' => $cumulativeGpa,
                'courses' => $courses,
            ];
        }

        // Determine remaining courses from courses table by department_id
        $takenCourseIds = $transcripts->pluck('course_id')->unique()->toArray();
        $curriculumCourses = Course::where('department_id', $student->department_id)->get();

        $remainingCourses = $curriculumCourses->filter(function ($course) use ($takenCourseIds) {
            return !in_array($course->id, $takenCourseIds);
        })->values()->map(function ($c) {
            return [
                'code' => $c->code,
                'title' => $c->title,
                'credits' => $c->credits,
                'category' => $c->category,
                'semester' => $c->semester,
            ];
        });

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
            'total_credits' => $cumulativeCredits,
            'total_ects' => $cumulativeCredits, // assuming credits = ECTS
            'remaining_courses' => $remainingCourses,
        ]);
    }

    private function gradeToPoint($grade)
    {
        return match (strtoupper($grade)) {
            'A+', 'A' => 4.0,
            'B+' => 3.5,
            'B' => 3.0,
            'C+' => 2.5,
            'C' => 2.0,
            'D+' => 1.5,
            'D' => 1.0,
            'F', 'FF' => 0.0,
            default => 0.0,
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
        $totalCredits = 0;
        $totalGradePoints = 0;
        $gradePoints = [
            "A" => 4.0, "B+" => 3.5, "B" => 3.0, "C+" => 2.5,
            "C" => 2.0, "D+" => 1.5, "D" => 1.0, "FF" => 0.0
        ];
        $passing = ["A", "B+", "B", "C+", "C"];
    
        foreach ($records as $record) {
            $semester = $record->semester;
            $grade = $record->grade;
            $credits = $record->course->credits ?? 0;
            $points = $gradePoints[$grade] ?? 0;
    
            $grouped[$semester]['courses'][] = [
                'code' => $record->course->code,
                'title' => $record->course->title,
                'grade' => $grade,
                'credits' => $credits,
                'status' => in_array($grade, $passing) ? 'Passed' : 'Failed',
            ];
    
            $grouped[$semester]['grade_points'] = ($grouped[$semester]['grade_points'] ?? 0) + ($points * $credits);
            $grouped[$semester]['total_credits'] = ($grouped[$semester]['total_credits'] ?? 0) + $credits;
        }
    
        foreach ($grouped as $sem => &$data) {
            $data['gpa'] = round($data['grade_points'] / $data['total_credits'], 2);
            $totalCredits += $data['total_credits'];
            $totalGradePoints += $data['grade_points'];
        }
    
        $cumulativeGPA = $totalCredits ? round($totalGradePoints / $totalCredits, 2) : 0;
    
        $pdf = Pdf::loadView('transcripts.pdf', [
            'student' => $student,
            'transcripts' => $grouped,
            'cumulativeGPA' => $cumulativeGPA
        ]);
    
        return $pdf->download("transcript_{$studentNumber}.pdf");
    }
    
    

    public function exportExcel($studentNumber)
    {
        return Excel::download(new TranscriptExport($studentNumber), "transcript_{$studentNumber}.xlsx");
    }
}
