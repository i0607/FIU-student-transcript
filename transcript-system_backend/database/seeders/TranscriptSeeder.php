<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TranscriptSeeder extends Seeder
{
    public function run()
    {
        $student1Id = DB::table('students')->where('student_number', '2103010232')->value('id');
        $student3Id = DB::table('students')->where('student_number', '200306129')->value('id');
        $student2Id = DB::table('students')->where('student_number', '2103010238')->value('id');

        if (!$student1Id || !$student2Id) {
            throw new \Exception('Students not found. Please run StudentSeeder first.');
        }
        $transcriptData= [
            // Student 1: DON ANTONIO MUSHENGEZI BYEBI (2103010232)
            
                 // 2021-2022 Spring
            ['student_id' => $student1Id, 'course_code' => 'ENGL121', 'grade' => 'A-', 'semester' => '2021-2022 Spring'],
            ['student_id' => $student1Id, 'course_code' => 'ENGR101', 'grade' => 'A', 'semester' => '2021-2022 Spring'],
            ['student_id' => $student1Id, 'course_code' => 'ENGR103', 'grade' => 'A-', 'semester' => '2021-2022 Spring'],
            ['student_id' => $student1Id, 'course_code' => 'MATH121', 'grade' => 'F', 'semester' => '2021-2022 Spring'],
            ['student_id' => $student1Id, 'course_code' => 'MATH123', 'grade' => 'B', 'semester' => '2021-2022 Spring'],
            ['student_id' => $student1Id, 'course_code' => 'PHYS121', 'grade' => 'D', 'semester' => '2021-2022 Spring'],
            ['student_id' => $student1Id, 'course_code' => 'TURK131', 'grade' => 'C+', 'semester' => '2021-2022 Spring'],

            // 2022-2023 Fall
            ['student_id' => $student1Id, 'course_code' => 'ENGL122', 'grade' => 'C', 'semester' => '2022-2023 Fall'],
            ['student_id' => $student1Id, 'course_code' => 'ENGR104', 'grade' => 'D', 'semester' => '2022-2023 Fall'],
            ['student_id' => $student1Id, 'course_code' => 'HIST111', 'grade' => 'B', 'semester' => '2022-2023 Fall'],
            ['student_id' => $student1Id, 'course_code' => 'MATH121', 'grade' => 'C-', 'semester' => '2022-2023 Fall'],
            ['student_id' => $student1Id, 'course_code' => 'MATH124', 'grade' => 'D', 'semester' => '2022-2023 Fall'],
            ['student_id' => $student1Id, 'course_code' => 'PHYS122', 'grade' => 'F', 'semester' => '2022-2023 Fall'],
            ['student_id' => $student1Id, 'course_code' => 'TURK132', 'grade' => 'B', 'semester' => '2022-2023 Fall'],

            // 2022-2023 Spring
            ['student_id' => $student1Id, 'course_code' => 'CMPE215', 'grade' => 'F', 'semester' => '2022-2023 Spring'],
            ['student_id' => $student1Id, 'course_code' => 'CMPE232', 'grade' => 'B-', 'semester' => '2022-2023 Spring'],
            ['student_id' => $student1Id, 'course_code' => 'GRAD282', 'grade' => 'B+', 'semester' => '2022-2023 Spring'],
            ['student_id' => $student1Id, 'course_code' => 'MATH122', 'grade' => 'NG', 'semester' => '2022-2023 Spring'],
            ['student_id' => $student1Id, 'course_code' => 'PHYS122', 'grade' => 'F', 'semester' => '2022-2023 Spring'],
            ['student_id' => $student1Id, 'course_code' => 'STAT226', 'grade' => 'D-', 'semester' => '2022-2023 Spring'],

            // 2023-2024 Fall
            ['student_id' => $student1Id, 'course_code' => 'CMPE215', 'grade' => 'D', 'semester' => '2023-2024 Fall'],
            ['student_id' => $student1Id, 'course_code' => 'ELEE211', 'grade' => 'B-', 'semester' => '2023-2024 Fall'],
            ['student_id' => $student1Id, 'course_code' => 'HIST112', 'grade' => 'C', 'semester' => '2023-2024 Fall'],
            ['student_id' => $student1Id, 'course_code' => 'MATH122', 'grade' => 'F', 'semester' => '2023-2024 Fall'],
            ['student_id' => $student1Id, 'course_code' => 'MATH225', 'grade' => 'F', 'semester' => '2023-2024 Fall'],
            ['student_id' => $student1Id, 'course_code' => 'PHYS122', 'grade' => 'C', 'semester' => '2023-2024 Fall'],

            // 2023-2024 Spring
            ['student_id' => $student1Id, 'course_code' => 'CMPE216', 'grade' => 'C', 'semester' => '2023-2024 Spring'],
            ['student_id' => $student1Id, 'course_code' => 'CMPE432', 'grade' => 'B+', 'semester' => '2023-2024 Spring'],
            ['student_id' => $student1Id, 'course_code' => 'ENGR215', 'grade' => 'B+', 'semester' => '2023-2024 Spring'],
            ['student_id' => $student1Id, 'course_code' => 'MATH122', 'grade' => 'C', 'semester' => '2023-2024 Spring'],
            ['student_id' => $student1Id, 'course_code' => 'OHSA206', 'grade' => 'A', 'semester' => '2023-2024 Spring'],
            ['student_id' => $student1Id, 'course_code' => 'STAT226', 'grade' => 'C-', 'semester' => '2023-2024 Spring'],

            // 2024-2025 Fall
            ['student_id' => $student1Id, 'course_code' => 'AINE301', 'grade' => 'B-', 'semester' => '2024-2025 Fall'],
            ['student_id' => $student1Id, 'course_code' => 'CMPE321', 'grade' => 'F', 'semester' => '2024-2025 Fall'],
            ['student_id' => $student1Id, 'course_code' => 'CMPE341', 'grade' => 'B+', 'semester' => '2024-2025 Fall'],
            ['student_id' => $student1Id, 'course_code' => 'ELEE231', 'grade' => 'D+', 'semester' => '2024-2025 Fall'],
            ['student_id' => $student1Id, 'course_code' => 'MATH225', 'grade' => 'F', 'semester' => '2024-2025 Fall'],
            ['student_id' => $student1Id, 'course_code' => 'SFWE343', 'grade' => 'B-', 'semester' => '2024-2025 Fall'],

            // 2024-2025 Spring (Current - in progress)
            ['student_id' => $student1Id, 'course_code' => 'CMPE252', 'grade' => 'IP', 'semester' => '2024-2025 Spring'],
            ['student_id' => $student1Id, 'course_code' => 'CMPE322', 'grade' => 'IP', 'semester' => '2024-2025 Spring'],
            ['student_id' => $student1Id, 'course_code' => 'CMPE324', 'grade' => 'IP', 'semester' => '2024-2025 Spring'],
            ['student_id' => $student1Id, 'course_code' => 'CMPE455', 'grade' => 'IP', 'semester' => '2024-2025 Spring'],
            ['student_id' => $student1Id, 'course_code' => 'ITAL101', 'grade' => 'IP', 'semester' => '2024-2025 Spring'],

            ['student_id' => $student2Id, 'course_code' => 'ENGR101', 'grade' => 'B-', 'semester' => '2021-2022 Spring'],
            ['student_id' => $student2Id, 'course_code' => 'ENGR104', 'grade' => 'B+', 'semester' => '2021-2022 Spring'],
            ['student_id' => $student2Id, 'course_code' => 'HESC109', 'grade' => 'A', 'semester' => '2021-2022 Spring'],
            ['student_id' => $student2Id, 'course_code' => 'HIST111', 'grade' => 'A', 'semester' => '2021-2022 Spring'],
            ['student_id' => $student2Id, 'course_code' => 'MATH124', 'grade' => 'A-', 'semester' => '2021-2022 Spring'],
            ['student_id' => $student2Id, 'course_code' => 'SOCI320', 'grade' => 'A', 'semester' => '2021-2022 Spring'],

            // 2022-2023 Fall
            ['student_id' => $student2Id, 'course_code' => 'BUSN101', 'grade' => 'C-', 'semester' => '2022-2023 Fall'],
            ['student_id' => $student2Id, 'course_code' => 'CMPE215', 'grade' => 'B-', 'semester' => '2022-2023 Fall'],
            ['student_id' => $student2Id, 'course_code' => 'ELEE211', 'grade' => 'B', 'semester' => '2022-2023 Fall'],
            ['student_id' => $student2Id, 'course_code' => 'ELEE231', 'grade' => 'D+', 'semester' => '2022-2023 Fall'],
            ['student_id' => $student2Id, 'course_code' => 'HIST112', 'grade' => 'B', 'semester' => '2022-2023 Fall'],
            ['student_id' => $student2Id, 'course_code' => 'MATH225', 'grade' => 'C', 'semester' => '2022-2023 Fall'],

            // 2022-2023 Spring
            ['student_id' => $student2Id, 'course_code' => 'CMPE232', 'grade' => 'B+', 'semester' => '2022-2023 Spring'],
            ['student_id' => $student2Id, 'course_code' => 'CMPE252', 'grade' => 'C', 'semester' => '2022-2023 Spring'],
            ['student_id' => $student2Id, 'course_code' => 'ENGR215', 'grade' => 'C-', 'semester' => '2022-2023 Spring'],
            ['student_id' => $student2Id, 'course_code' => 'GRAD282', 'grade' => 'B', 'semester' => '2022-2023 Spring'],
            ['student_id' => $student2Id, 'course_code' => 'OHSA206', 'grade' => 'A-', 'semester' => '2022-2023 Spring'],
            ['student_id' => $student2Id, 'course_code' => 'STAT226', 'grade' => 'B-', 'semester' => '2022-2023 Spring'],

            // 2023-2024 Fall
            ['student_id' => $student2Id, 'course_code' => 'CMPE321', 'grade' => 'A', 'semester' => '2023-2024 Fall'],
            ['student_id' => $student2Id, 'course_code' => 'CMPE341', 'grade' => 'A', 'semester' => '2023-2024 Fall'],
            ['student_id' => $student2Id, 'course_code' => 'COMP464', 'grade' => 'B-', 'semester' => '2023-2024 Fall'],
            ['student_id' => $student2Id, 'course_code' => 'ELEE331', 'grade' => 'B', 'semester' => '2023-2024 Fall'],
            ['student_id' => $student2Id, 'course_code' => 'ELEE341', 'grade' => 'D', 'semester' => '2023-2024 Fall'],
            ['student_id' => $student2Id, 'course_code' => 'ENGR401', 'grade' => 'B+', 'semester' => '2023-2024 Fall'],

            // 2023-2024 Spring
            ['student_id' => $student2Id, 'course_code' => 'CMPE216', 'grade' => 'A-', 'semester' => '2023-2024 Spring'],
            ['student_id' => $student2Id, 'course_code' => 'CMPE322', 'grade' => 'C+', 'semester' => '2023-2024 Spring'],
            ['student_id' => $student2Id, 'course_code' => 'CMPE324', 'grade' => 'C', 'semester' => '2023-2024 Spring'],
            ['student_id' => $student2Id, 'course_code' => 'MATH228', 'grade' => 'C+', 'semester' => '2023-2024 Spring'],
            ['student_id' => $student2Id, 'course_code' => 'MATH328', 'grade' => 'D', 'semester' => '2023-2024 Spring'],
            ['student_id' => $student2Id, 'course_code' => 'SFWE316', 'grade' => 'A', 'semester' => '2023-2024 Spring'],

            // 2024-2025 Fall
            ['student_id' => $student2Id, 'course_code' => 'CMPE403', 'grade' => 'S', 'semester' => '2024-2025 Fall'],
            ['student_id' => $student2Id, 'course_code' => 'CMPE421', 'grade' => 'A', 'semester' => '2024-2025 Fall'],
            ['student_id' => $student2Id, 'course_code' => 'CMPE463', 'grade' => 'D', 'semester' => '2024-2025 Fall'],
            ['student_id' => $student2Id, 'course_code' => 'SFWE343', 'grade' => 'B-', 'semester' => '2024-2025 Fall'],
            ['student_id' => $student2Id, 'course_code' => 'SFWE415', 'grade' => 'F', 'semester' => '2024-2025 Fall'],
                        // 2020-2021 (Bahar) - Spring Semester
            ['student_id' => $student3Id, 'course_code' => 'ENGL101', 'grade' => 'F', 'semester' => '2020-2021 Bahar', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'MATH101', 'grade' => 'B', 'semester' => '2020-2021 Bahar', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 12.00],
            ['student_id' => $student3Id, 'course_code' => 'MATH103', 'grade' => 'D', 'semester' => '2020-2021 Bahar', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 3.00],
            ['student_id' => $student3Id, 'course_code' => 'PHYS101', 'grade' => 'F', 'semester' => '2020-2021 Bahar', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT100', 'grade' => 'D-', 'semester' => '2020-2021 Bahar', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 2.10],
            ['student_id' => $student3Id, 'course_code' => 'SOFT103', 'grade' => 'D', 'semester' => '2020-2021 Bahar', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 2.00],

            // 2020-2021 (17-Bütünleme) - Supplementary Exam
            ['student_id' => $student3Id, 'course_code' => 'ENGL101', 'grade' => 'C', 'semester' => '2020-2021 17-Bütünleme', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 6.00],
            ['student_id' => $student3Id, 'course_code' => 'PHYS101', 'grade' => 'F', 'semester' => '2020-2021 17-Bütünleme', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT100', 'grade' => 'F', 'semester' => '2020-2021 17-Bütünleme', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 0.00],

            // 2021-2022 (Güz) - Fall Semester
            ['student_id' => $student3Id, 'course_code' => 'ENGL102', 'grade' => 'C+', 'semester' => '2021-2022 Güz', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student3Id, 'course_code' => 'MATH102', 'grade' => 'F', 'semester' => '2021-2022 Güz', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'MATH104', 'grade' => 'F', 'semester' => '2021-2022 Güz', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'PHYS101', 'grade' => 'D', 'semester' => '2021-2022 Güz', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT100', 'grade' => 'C', 'semester' => '2021-2022 Güz', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 6.00],
            ['student_id' => $student3Id, 'course_code' => 'TURK100', 'grade' => 'B-', 'semester' => '2021-2022 Güz', 'credits' => 2.00, 'points' => 2.00, 'earned_points' => 5.40],

            // 2021-2022 (13-Bütünleme) - Supplementary Exam
            ['student_id' => $student3Id, 'course_code' => 'MATH104', 'grade' => 'F', 'semester' => '2021-2022 13-Bütünleme', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 0.00],

            // 2021-2022 (Bahar) - Spring Semester
            ['student_id' => $student3Id, 'course_code' => 'BUSN101', 'grade' => 'D', 'semester' => '2021-2022 Bahar', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 3.00],
            ['student_id' => $student3Id, 'course_code' => 'MATH102', 'grade' => 'F', 'semester' => '2021-2022 Bahar', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'MATH104', 'grade' => 'B+', 'semester' => '2021-2022 Bahar', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 9.90],
            ['student_id' => $student3Id, 'course_code' => 'PHYS102', 'grade' => 'F', 'semester' => '2021-2022 Bahar', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT104', 'grade' => 'C-', 'semester' => '2021-2022 Bahar', 'credits' => 5.00, 'points' => 4.00, 'earned_points' => 6.80],

            // 2021-2022 (17-Bütünleme(Bahar)) - Supplementary Exam
            ['student_id' => $student3Id, 'course_code' => 'MATH102', 'grade' => 'D', 'semester' => '2021-2022 17-Bütünleme', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],

            // 2022-2023 (Güz) - Fall Semester
            ['student_id' => $student3Id, 'course_code' => 'ENGL201', 'grade' => 'B+', 'semester' => '2022-2023 Güz', 'credits' => 4.00, 'points' => 2.00, 'earned_points' => 6.60],
            ['student_id' => $student3Id, 'course_code' => 'MATH205', 'grade' => 'F', 'semester' => '2022-2023 Güz', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'PHYS102', 'grade' => 'F', 'semester' => '2022-2023 Güz', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT215', 'grade' => 'F', 'semester' => '2022-2023 Güz', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT235', 'grade' => 'W', 'semester' => '2022-2023 Güz', 'credits' => 4.00, 'points' => 4.00, 'earned_points' => 0.00],

            // 2022-2023 (Bahar) - Spring Semester
            ['student_id' => $student3Id, 'course_code' => 'ARCH281', 'grade' => 'B+', 'semester' => '2022-2023 Bahar', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 9.90],
            ['student_id' => $student3Id, 'course_code' => 'MATH206', 'grade' => 'D-', 'semester' => '2022-2023 Bahar', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 2.10],
            ['student_id' => $student3Id, 'course_code' => 'PHYS102', 'grade' => 'F', 'semester' => '2022-2023 Bahar', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT215', 'grade' => 'F', 'semester' => '2022-2023 Bahar', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT254', 'grade' => 'F', 'semester' => '2022-2023 Bahar', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 0.00],

            // 2023-2024 (Güz) - Fall Semester
            ['student_id' => $student3Id, 'course_code' => 'COMP225', 'grade' => 'D+', 'semester' => '2023-2024 Güz', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 5.20],
            ['student_id' => $student3Id, 'course_code' => 'FRNC101', 'grade' => 'B', 'semester' => '2023-2024 Güz', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student3Id, 'course_code' => 'MATH205', 'grade' => 'C-', 'semester' => '2023-2024 Güz', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 6.80],
            ['student_id' => $student3Id, 'course_code' => 'SOFT215', 'grade' => 'D', 'semester' => '2023-2024 Güz', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT235', 'grade' => 'F', 'semester' => '2023-2024 Güz', 'credits' => 4.00, 'points' => 4.00, 'earned_points' => 0.00],

            // 2023-2024 (Bahar) - Spring Semester
            ['student_id' => $student3Id, 'course_code' => 'PHYS102', 'grade' => 'C+', 'semester' => '2023-2024 Bahar', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 9.20],
            ['student_id' => $student3Id, 'course_code' => 'SOFT235', 'grade' => 'C', 'semester' => '2023-2024 Bahar', 'credits' => 4.00, 'points' => 4.00, 'earned_points' => 8.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT252', 'grade' => 'C+', 'semester' => '2023-2024 Bahar', 'credits' => 8.00, 'points' => 4.00, 'earned_points' => 9.20],
            ['student_id' => $student3Id, 'course_code' => 'SOFT254', 'grade' => 'F', 'semester' => '2023-2024 Bahar', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT404', 'grade' => 'A', 'semester' => '2023-2024 Bahar', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 8.00],

            // 2024-2025 (Güz) - Fall Semester
            ['student_id' => $student3Id, 'course_code' => 'COMP463', 'grade' => 'C+', 'semester' => '2024-2025 Güz', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student3Id, 'course_code' => 'COMP464', 'grade' => 'C+', 'semester' => '2024-2025 Güz', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student3Id, 'course_code' => 'MATH309', 'grade' => 'B', 'semester' => '2024-2025 Güz', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT321', 'grade' => 'D+', 'semester' => '2024-2025 Güz', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 5.20],
            ['student_id' => $student3Id, 'course_code' => 'SOFT341', 'grade' => 'A', 'semester' => '2024-2025 Güz', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 16.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT472', 'grade' => 'B+', 'semester' => '2024-2025 Güz', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 9.90],

            // 2024-2025 (Bahar) - Spring Semester (Current - No grades yet)
            ['student_id' => $student3Id, 'course_code' => 'COMP216', 'grade' => '0', 'semester' => '2024-2025 Bahar', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'COMP465', 'grade' => '0', 'semester' => '2024-2025 Bahar', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'MATH206', 'grade' => '0', 'semester' => '2024-2025 Bahar', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT254', 'grade' => '0', 'semester' => '2024-2025 Bahar', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT332', 'grade' => '0', 'semester' => '2024-2025 Bahar', 'credits' => 5.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT422', 'grade' => '0', 'semester' => '2024-2025 Bahar', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 0.00]

        ];
        $transcripts = [];
        foreach ($transcriptData as $record) {
            $courseId = DB::table('courses')->where('code', $record['course_code'])->value('id');
            
            if ($courseId) {
                $transcripts[] = [
                    'student_id' => $record['student_id'],
                    'course_id' => $courseId,
                    'grade' => $record['grade'],
                    'semester' => $record['semester'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            } else {
                // Log missing course
                echo "Warning: Course {$record['course_code']} not found in courses table\n";
            }
        }
        // Insert data in batches of 20 records
        $chunks = array_chunk($transcripts, 20);
        foreach ($chunks as $chunk) {
            DB::table('transcripts')->insert($chunk);
        }
    }
}