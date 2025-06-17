<?php
namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TranscriptExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $studentNumber;
    protected $studentInfo;
    protected $rows = [];

    public function __construct($studentNumber)
    {
        $this->studentNumber = $studentNumber;
    }

    public function array(): array
    {
        $student = Student::where('student_number', $this->studentNumber)->firstOrFail();
        $records = $student->transcripts()->with('course')->get();

        $this->studentInfo = [
            ['Name:', $student->name],
            ['Student Number:', $student->student_number],
            ['Department:', $student->department_id],
            ['Graduation Date:', $student->graduation_date ?? 'N/A'],
            ['Email:', $student->email ?? '-'],
            ['-----------------------------------------'],
        ];

        $gradePoints = [
            'A+' => 4.0, 'A' => 4.0, 'A-' => 3.7,
            'B+' => 3.3, 'B' => 3.0, 'B-' => 2.7,
            'C+' => 2.3, 'C' => 2.0, 'C-' => 1.7,
            'D+' => 1.3, 'D' => 1.0, 'D-' => 0.7,
            'F' => 0.0, 'FF' => 0.0
        ];
        $passing = ["A", "A-", "B+", "B", "B-", "C+", "C", "C-", "D+", "D", "D-"];

        $grouped = [];
        $totalCredits = 0;
        $totalGradePoints = 0;

        foreach ($records as $r) {
            $semester = $r->semester;
            $g = $r->grade;
            $c = $r->course->credits ?? 0;
            $gp = $gradePoints[$g] ?? 0;
            $nonGradedCourses = ['NG', 'I', 'W', 'U', 'S', 'P', 'M', 'T', 'E', 'PS', 'PU', 'TS', 'TU', 'TP', 'TI', 'TR', 'TF', 'CS', 'IP', '0'];
            
            if (in_array($g, $nonGradedCourses)) {
                $grouped[$semester][] = [
                    $r->course->code,
                    $r->course->title,
                    $g,
                    $c,
                    0, // No grade points for non-graded courses
                    'Not Graded'
                ];
                continue; // Don't include in GPA calculation
            }
            $grouped[$semester][] = [
                $r->course->code,
                $r->course->title,
                $g,
                $c,
                $gp,
                in_array($g, $passing) ? 'Passed' : 'Failed'
            ];

            $totalCredits += $c;
            $totalGradePoints += $gp * $c;
        }

        $this->rows = [];

        foreach ($grouped as $sem => $courses) {
            $this->rows[] = [$sem];
            $this->rows[] = ['Code', 'Title', 'Grade', 'Credits', 'Points', 'Status'];

            $semCredits = 0;
            $semPoints = 0;

            foreach ($courses as $row) {
                $this->rows[] = $row;
                $semCredits += $row[3];
                $semPoints += $row[3] * $row[4];
            }

            $gpa = $semCredits ? round($semPoints / $semCredits, 2) : 0;
            $this->rows[] = ['', '', '', 'GPA', $gpa, ''];
            $this->rows[] = [''];
        }

        $cgpa = $totalCredits ? round($totalGradePoints / $totalCredits, 2) : 0;
        $this->rows[] = ['', '', '', 'Cumulative GPA', $cgpa, ''];

        return array_merge($this->studentInfo, [['']], $this->rows);
    }

    public function headings(): array
    {
        return [];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]], // Name
            2 => ['font' => ['bold' => true]],
            3 => ['font' => ['bold' => true]],
        ];
    }
}
