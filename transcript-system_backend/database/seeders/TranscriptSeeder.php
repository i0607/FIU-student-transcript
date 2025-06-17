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
        $student4Id = DB::table('students')->where('student_number', '2003010112')->value('id');
        $student5Id = DB::table('students')->where('student_number', '1903010042')->value('id');
        $student6Id = DB::table('students')->where('student_number', '2003010108')->value('id');
        $student7Id = DB::table('students')->where('student_number', '2003010134')->value('id');
        $student8Id = DB::table('students')->where('student_number', '1903010033')->value('id');
        $student9Id = DB::table('students')->where('student_number', '1903010072')->value('id');
        $student10Id = DB::table('students')->where('student_number', '2103060171')->value('id');
        $student11Id = DB::table('students')->where('student_number', '1903010034')->value('id');
        $student12Id = DB::table('students')->where('student_number', '2103010205')->value('id');

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
            ['student_id' => $student1Id, 'course_code' => 'SFWE316', 'grade' => 'IP', 'semester' => '2024-2025 Spring'],

            ['student_id' => $student2Id, 'course_code' => 'ENGP070', 'grade' => 'E', 'semester' => ' 2021-2022 (ENGLISH PREPARATORY SCHOOL EXEMPTION TEST)'],

            ['student_id' => $student2Id, 'course_code' => 'ENGL121', 'grade' => 'E', 'semester' => 'Exempted Courses'],
            ['student_id' => $student2Id, 'course_code' => 'ENGL122', 'grade' => 'E', 'semester' => 'Exempted Courses'],
            ['student_id' => $student2Id, 'course_code' => 'ENGR103', 'grade' => 'E', 'semester' => 'Exempted Courses'],
            ['student_id' => $student2Id, 'course_code' => 'MATH121', 'grade' => 'E', 'semester' => 'Exempted Courses'],
            ['student_id' => $student2Id, 'course_code' => 'MATH122', 'grade' => 'E', 'semester' => 'Exempted Courses'],
            ['student_id' => $student2Id, 'course_code' => 'MATH123', 'grade' => 'E', 'semester' => 'Exempted Courses'],
            ['student_id' => $student2Id, 'course_code' => 'PHYS121', 'grade' => 'E', 'semester' => 'Exempted Courses'],
            ['student_id' => $student2Id, 'course_code' => 'PHYS122', 'grade' => 'E', 'semester' => 'Exempted Courses'],
            ['student_id' => $student2Id, 'course_code' => 'TURK131', 'grade' => 'E', 'semester' => 'Exempted Courses'],
            ['student_id' => $student2Id, 'course_code' => 'TURK132', 'grade' => 'E', 'semester' => 'Exempted Courses'],

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
                        // 2020-2021 (Spring) - Spring Semester
            ['student_id' => $student3Id, 'course_code' => 'ENGL101', 'grade' => 'F', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'MATH101', 'grade' => 'B', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 12.00],
            ['student_id' => $student3Id, 'course_code' => 'MATH103', 'grade' => 'D', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 3.00],
            ['student_id' => $student3Id, 'course_code' => 'PHYS101', 'grade' => 'F', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT100', 'grade' => 'D-', 'semester' => '2020-2021 Spring', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 2.10],
            ['student_id' => $student3Id, 'course_code' => 'SOFT103', 'grade' => 'D', 'semester' => '2020-2021 Spring', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 2.00],

            // 2020-2021 (17-make-up) - Supplementary Exam
            ['student_id' => $student3Id, 'course_code' => 'ENGL101', 'grade' => 'C', 'semester' => '2020-2021 17-make-up', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 6.00],
            ['student_id' => $student3Id, 'course_code' => 'PHYS101', 'grade' => 'F', 'semester' => '2020-2021 17-make-up', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT100', 'grade' => 'F', 'semester' => '2020-2021 17-make-up', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 0.00],

            // 2021-2022 (Fall) - Fall Semester
            ['student_id' => $student3Id, 'course_code' => 'ENGL102', 'grade' => 'C+', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student3Id, 'course_code' => 'MATH102', 'grade' => 'F', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'MATH104', 'grade' => 'F', 'semester' => '2021-2022 Fall', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'PHYS101', 'grade' => 'D', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT100', 'grade' => 'C', 'semester' => '2021-2022 Fall', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 6.00],
            ['student_id' => $student3Id, 'course_code' => 'TURK100', 'grade' => 'B-', 'semester' => '2021-2022 Fall', 'credits' => 2.00, 'points' => 2.00, 'earned_points' => 5.40],

            // 2021-2022 (13-make-up) - Supplementary Exam
            ['student_id' => $student3Id, 'course_code' => 'MATH104', 'grade' => 'F', 'semester' => '2021-2022 13-make-up', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 0.00],

            // 2021-2022 (Spring) - Spring Semester
            ['student_id' => $student3Id, 'course_code' => 'BUSN101', 'grade' => 'D', 'semester' => '2021-2022 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 3.00],
            ['student_id' => $student3Id, 'course_code' => 'MATH102', 'grade' => 'F', 'semester' => '2021-2022 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'MATH104', 'grade' => 'B+', 'semester' => '2021-2022 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 9.90],
            ['student_id' => $student3Id, 'course_code' => 'PHYS102', 'grade' => 'F', 'semester' => '2021-2022 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT104', 'grade' => 'C-', 'semester' => '2021-2022 Spring', 'credits' => 5.00, 'points' => 4.00, 'earned_points' => 6.80],

            // 2021-2022 (17-make-up(Spring)) - Supplementary Exam
            ['student_id' => $student3Id, 'course_code' => 'MATH102', 'grade' => 'D', 'semester' => '2021-2022 17-make-up', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],

            // 2022-2023 (Fall) - Fall Semester
            ['student_id' => $student3Id, 'course_code' => 'ENGL201', 'grade' => 'B+', 'semester' => '2022-2023 Fall', 'credits' => 4.00, 'points' => 2.00, 'earned_points' => 6.60],
            ['student_id' => $student3Id, 'course_code' => 'MATH205', 'grade' => 'F', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'PHYS102', 'grade' => 'F', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT215', 'grade' => 'F', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT235', 'grade' => 'W', 'semester' => '2022-2023 Fall', 'credits' => 4.00, 'points' => 4.00, 'earned_points' => 0.00],

            // 2022-2023 (Spring) - Spring Semester
            ['student_id' => $student3Id, 'course_code' => 'ARCH281', 'grade' => 'B+', 'semester' => '2022-2023 Spring', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 9.90],
            ['student_id' => $student3Id, 'course_code' => 'MATH206', 'grade' => 'D-', 'semester' => '2022-2023 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 2.10],
            ['student_id' => $student3Id, 'course_code' => 'PHYS102', 'grade' => 'F', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT215', 'grade' => 'F', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT254', 'grade' => 'F', 'semester' => '2022-2023 Spring', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 0.00],

            // 2023-2024 (Fall) - Fall Semester
            ['student_id' => $student3Id, 'course_code' => 'COMP225', 'grade' => 'D+', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 5.20],
            ['student_id' => $student3Id, 'course_code' => 'FRNC101', 'grade' => 'B', 'semester' => '2023-2024 Fall', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student3Id, 'course_code' => 'MATH205', 'grade' => 'C-', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 6.80],
            ['student_id' => $student3Id, 'course_code' => 'SOFT215', 'grade' => 'D', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT235', 'grade' => 'F', 'semester' => '2023-2024 Fall', 'credits' => 4.00, 'points' => 4.00, 'earned_points' => 0.00],

            // 2023-2024 (Spring) - Spring Semester
            ['student_id' => $student3Id, 'course_code' => 'PHYS102', 'grade' => 'C+', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 9.20],
            ['student_id' => $student3Id, 'course_code' => 'SOFT235', 'grade' => 'C', 'semester' => '2023-2024 Spring', 'credits' => 4.00, 'points' => 4.00, 'earned_points' => 8.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT252', 'grade' => 'C+', 'semester' => '2023-2024 Spring', 'credits' => 8.00, 'points' => 4.00, 'earned_points' => 9.20],
            ['student_id' => $student3Id, 'course_code' => 'SOFT254', 'grade' => 'F', 'semester' => '2023-2024 Spring', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT404', 'grade' => 'A', 'semester' => '2023-2024 Spring', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 8.00],

            // 2024-2025 (Fall) - Fall Semester
            ['student_id' => $student3Id, 'course_code' => 'COMP463', 'grade' => 'C+', 'semester' => '2024-2025 Fall', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student3Id, 'course_code' => 'COMP464', 'grade' => 'C+', 'semester' => '2024-2025 Fall', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student3Id, 'course_code' => 'MATH309', 'grade' => 'B', 'semester' => '2024-2025 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT321', 'grade' => 'D+', 'semester' => '2024-2025 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 5.20],
            ['student_id' => $student3Id, 'course_code' => 'SOFT341', 'grade' => 'A', 'semester' => '2024-2025 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 16.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT472', 'grade' => 'B+', 'semester' => '2024-2025 Fall', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 9.90],

            // 2024-2025 (Spring) - Spring Semester (Current - No grades yet)
            ['student_id' => $student3Id, 'course_code' => 'COMP216', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'COMP465', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'MATH206', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT254', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT332', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 5.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student3Id, 'course_code' => 'SOFT422', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 0.00],


            // 2020-2021 (Fall) - English Prep School
            ['student_id' => $student4Id, 'course_code' => 'PREP101', 'grade' => 'S', 'semester' => '2020-2021 Fall', 'credits' => 0.00, 'points' => 0.00, 'earned_points' => 0.00],

            // 2020-2021 (Spring) - English Prep School
            ['student_id' => $student4Id, 'course_code' => 'PREP102', 'grade' => 'S', 'semester' => '2020-2021 Spring', 'credits' => 0.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student4Id, 'course_code' => 'PREP106', 'grade' => 'S', 'semester' => '2020-2021 Spring', 'credits' => 0.00, 'points' => 0.00, 'earned_points' => 0.00],

            // 2021-2022 (Fall)
            ['student_id' => $student4Id, 'course_code' => 'ENGL121', 'grade' => 'C', 'semester' => '2021-2022 Fall', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 6.00],
            ['student_id' => $student4Id, 'course_code' => 'ENGR101', 'grade' => 'C+', 'semester' => '2021-2022 Fall', 'credits' => 2.00, 'points' => 2.00, 'earned_points' => 4.60],
            ['student_id' => $student4Id, 'course_code' => 'ENGR103', 'grade' => 'C-', 'semester' => '2021-2022 Fall', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 5.10],
            ['student_id' => $student4Id, 'course_code' => 'MATH121', 'grade' => 'B+', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 13.20],
            ['student_id' => $student4Id, 'course_code' => 'MATH123', 'grade' => 'C', 'semester' => '2021-2022 Fall', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 6.00],
            ['student_id' => $student4Id, 'course_code' => 'PHYS121', 'grade' => 'C', 'semester' => '2021-2022 Fall', 'credits' => 5.00, 'points' => 4.00, 'earned_points' => 8.00],
            ['student_id' => $student4Id, 'course_code' => 'TURK131', 'grade' => 'C-', 'semester' => '2021-2022 Fall', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 3.40],

            // 2021-2022 (Spring)
            ['student_id' => $student4Id, 'course_code' => 'ENGL122', 'grade' => 'D+', 'semester' => '2021-2022 Spring', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 3.90],
            ['student_id' => $student4Id, 'course_code' => 'ENGR104', 'grade' => 'B+', 'semester' => '2021-2022 Spring', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 9.90],
            ['student_id' => $student4Id, 'course_code' => 'HIST111', 'grade' => 'B', 'semester' => '2021-2022 Spring', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 6.00],
            ['student_id' => $student4Id, 'course_code' => 'MATH122', 'grade' => 'B', 'semester' => '2021-2022 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 12.00],
            ['student_id' => $student4Id, 'course_code' => 'MATH124', 'grade' => 'A-', 'semester' => '2021-2022 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 11.10],
            ['student_id' => $student4Id, 'course_code' => 'PHYS122', 'grade' => 'C+', 'semester' => '2021-2022 Spring', 'credits' => 5.00, 'points' => 4.00, 'earned_points' => 9.20],
            ['student_id' => $student4Id, 'course_code' => 'TURK132', 'grade' => 'D', 'semester' => '2021-2022 Spring', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 2.00],

            // 2022-2023 (Fall)
            ['student_id' => $student4Id, 'course_code' => 'BUSN101', 'grade' => 'B', 'semester' => '2022-2023 Fall', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student4Id, 'course_code' => 'CMPE215', 'grade' => 'B+', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 9.90],
            ['student_id' => $student4Id, 'course_code' => 'ELEE211', 'grade' => 'B', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 12.00],
            ['student_id' => $student4Id, 'course_code' => 'ELEE231', 'grade' => 'D', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            ['student_id' => $student4Id, 'course_code' => 'HIST112', 'grade' => 'B+', 'semester' => '2022-2023 Fall', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 6.60],
            ['student_id' => $student4Id, 'course_code' => 'MATH225', 'grade' => 'B-', 'semester' => '2022-2023 Fall', 'credits' => 5.00, 'points' => 4.00, 'earned_points' => 10.80],

            // 2022-2023 (Spring)
            ['student_id' => $student4Id, 'course_code' => 'CMPE216', 'grade' => 'B+', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 9.90],
            ['student_id' => $student4Id, 'course_code' => 'CMPE232', 'grade' => 'C+', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student4Id, 'course_code' => 'CMPE252', 'grade' => 'B+', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 13.20],
            ['student_id' => $student4Id, 'course_code' => 'ENGR215', 'grade' => 'C-', 'semester' => '2022-2023 Spring', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 3.40],
            ['student_id' => $student4Id, 'course_code' => 'OHSA206', 'grade' => 'B-', 'semester' => '2022-2023 Spring', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 8.10],
            ['student_id' => $student4Id, 'course_code' => 'STAT226', 'grade' => 'B+', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 9.90],

            // 2023-2024 (Fall)
            ['student_id' => $student4Id, 'course_code' => 'ACCT201', 'grade' => 'C+', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student4Id, 'course_code' => 'CMPE321', 'grade' => 'C+', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 9.20],
            ['student_id' => $student4Id, 'course_code' => 'CMPE341', 'grade' => 'A-', 'semester' => '2023-2024 Fall', 'credits' => 5.00, 'points' => 4.00, 'earned_points' => 14.80],
            ['student_id' => $student4Id, 'course_code' => 'ELEE331', 'grade' => 'D', 'semester' => '2023-2024 Fall', 'credits' => 5.00, 'points' => 4.00, 'earned_points' => 4.00],
            ['student_id' => $student4Id, 'course_code' => 'ELEE341', 'grade' => 'C', 'semester' => '2023-2024 Fall', 'credits' => 5.00, 'points' => 4.00, 'earned_points' => 8.00],
            ['student_id' => $student4Id, 'course_code' => 'SFWE343', 'grade' => 'B', 'semester' => '2023-2024 Fall', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 9.00],

            // 2023-2024 (Spring)
            ['student_id' => $student4Id, 'course_code' => 'CMPE322', 'grade' => 'C', 'semester' => '2023-2024 Spring', 'credits' => 5.00, 'points' => 4.00, 'earned_points' => 8.00],
            ['student_id' => $student4Id, 'course_code' => 'CMPE324', 'grade' => 'B', 'semester' => '2023-2024 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student4Id, 'course_code' => 'ECON101', 'grade' => 'C', 'semester' => '2023-2024 Spring', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 6.00],
            ['student_id' => $student4Id, 'course_code' => 'MATH228', 'grade' => 'B-', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 8.10],
            ['student_id' => $student4Id, 'course_code' => 'MATH328', 'grade' => 'D', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 3.00],
            ['student_id' => $student4Id, 'course_code' => 'SFWE316', 'grade' => 'B+', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 9.90],

            // 2024-2025 (Fall)
            ['student_id' => $student4Id, 'course_code' => 'BUSN102', 'grade' => 'B', 'semester' => '2024-2025 Fall', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student4Id, 'course_code' => 'CMPE403', 'grade' => 'S', 'semester' => '2024-2025 Fall', 'credits' => 2.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student4Id, 'course_code' => 'CMPE421', 'grade' => 'C', 'semester' => '2024-2025 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 6.00],
            ['student_id' => $student4Id, 'course_code' => 'CMPE463', 'grade' => 'C+', 'semester' => '2024-2025 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student4Id, 'course_code' => 'CMPE464', 'grade' => 'D', 'semester' => '2024-2025 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 3.00],
            ['student_id' => $student4Id, 'course_code' => 'ENGR401', 'grade' => 'A-', 'semester' => '2024-2025 Fall', 'credits' => 6.00, 'points' => 2.00, 'earned_points' => 7.40],

            // 2024-2025 (Spring) - Current Semester (No grades yet)
            ['student_id' => $student4Id, 'course_code' => 'AINE312', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student4Id, 'course_code' => 'CMPE431', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student4Id, 'course_code' => 'CMPE455', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student4Id, 'course_code' => 'ENGR402', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 10.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student4Id, 'course_code' => 'ENGR404', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 0.00],
            ['student_id' => $student4Id, 'course_code' => 'PREP101', 'grade' => 'S', 'semester' => '2020-2021 Fall', 'credits' => 0.00, 'points' => 0.00, 'earned_points' => 0.00],
    
            // 2020-2021 Spring - English Prep
            ['student_id' => $student4Id, 'course_code' => 'PREP102', 'grade' => 'S', 'semester' => '2020-2021 Spring', 'credits' => 0.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student4Id, 'course_code' => 'PREP106', 'grade' => 'S', 'semester' => '2020-2021 Spring', 'credits' => 0.00, 'points' => 0.00, 'earned_points' => 0.00],
            
            // 2021-2022 Fall
            ['student_id' => $student4Id, 'course_code' => 'ENGL121', 'grade' => 'C', 'semester' => '2021-2022 Fall', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 6.00],
            ['student_id' => $student4Id, 'course_code' => 'ENGR101', 'grade' => 'C+', 'semester' => '2021-2022 Fall', 'credits' => 2.00, 'points' => 2.00, 'earned_points' => 4.60],
            ['student_id' => $student4Id, 'course_code' => 'ENGR103', 'grade' => 'C-', 'semester' => '2021-2022 Fall', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 5.10],
            ['student_id' => $student4Id, 'course_code' => 'MATH121', 'grade' => 'B+', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 13.20],
            ['student_id' => $student4Id, 'course_code' => 'MATH123', 'grade' => 'C', 'semester' => '2021-2022 Fall', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 6.00],
            ['student_id' => $student4Id, 'course_code' => 'PHYS121', 'grade' => 'C', 'semester' => '2021-2022 Fall', 'credits' => 5.00, 'points' => 4.00, 'earned_points' => 8.00],
            ['student_id' => $student4Id, 'course_code' => 'TURK131', 'grade' => 'C-', 'semester' => '2021-2022 Fall', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 3.40],
            
            // 2021-2022 Spring
            ['student_id' => $student4Id, 'course_code' => 'ENGL122', 'grade' => 'D+', 'semester' => '2021-2022 Spring', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 3.90],
            ['student_id' => $student4Id, 'course_code' => 'ENGR104', 'grade' => 'B+', 'semester' => '2021-2022 Spring', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 9.90],
            ['student_id' => $student4Id, 'course_code' => 'HIST111', 'grade' => 'B', 'semester' => '2021-2022 Spring', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 6.00],
            ['student_id' => $student4Id, 'course_code' => 'MATH122', 'grade' => 'B', 'semester' => '2021-2022 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 12.00],
            ['student_id' => $student4Id, 'course_code' => 'MATH124', 'grade' => 'A-', 'semester' => '2021-2022 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 11.10],
            ['student_id' => $student4Id, 'course_code' => 'PHYS122', 'grade' => 'C+', 'semester' => '2021-2022 Spring', 'credits' => 5.00, 'points' => 4.00, 'earned_points' => 9.20],
            ['student_id' => $student4Id, 'course_code' => 'TURK132', 'grade' => 'D', 'semester' => '2021-2022 Spring', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 2.00],
            
            // 2022-2023 Fall
            ['student_id' => $student4Id, 'course_code' => 'BUSN101', 'grade' => 'B', 'semester' => '2022-2023 Fall', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student4Id, 'course_code' => 'CMPE215', 'grade' => 'B+', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 9.90],
            ['student_id' => $student4Id, 'course_code' => 'ELEE211', 'grade' => 'B', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 12.00],
            ['student_id' => $student4Id, 'course_code' => 'ELEE231', 'grade' => 'D', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            ['student_id' => $student4Id, 'course_code' => 'HIST112', 'grade' => 'B+', 'semester' => '2022-2023 Fall', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 6.60],
            ['student_id' => $student4Id, 'course_code' => 'MATH225', 'grade' => 'B-', 'semester' => '2022-2023 Fall', 'credits' => 5.00, 'points' => 4.00, 'earned_points' => 10.80],
            
            // 2022-2023 Spring
            ['student_id' => $student4Id, 'course_code' => 'CMPE216', 'grade' => 'B+', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 9.90],
            ['student_id' => $student4Id, 'course_code' => 'CMPE232', 'grade' => 'C+', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student4Id, 'course_code' => 'CMPE252', 'grade' => 'B+', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 13.20],
            ['student_id' => $student4Id, 'course_code' => 'ENGR215', 'grade' => 'C-', 'semester' => '2022-2023 Spring', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 3.40],
            ['student_id' => $student4Id, 'course_code' => 'OHSA206', 'grade' => 'B-', 'semester' => '2022-2023 Spring', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 8.10],
            ['student_id' => $student4Id, 'course_code' => 'STAT226', 'grade' => 'B+', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 9.90],
            
            // 2023-2024 Fall
            ['student_id' => $student4Id, 'course_code' => 'ACCT201', 'grade' => 'C+', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student4Id, 'course_code' => 'CMPE321', 'grade' => 'C+', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 9.20],
            ['student_id' => $student4Id, 'course_code' => 'CMPE341', 'grade' => 'A-', 'semester' => '2023-2024 Fall', 'credits' => 5.00, 'points' => 4.00, 'earned_points' => 14.80],
            ['student_id' => $student4Id, 'course_code' => 'ELEE331', 'grade' => 'D', 'semester' => '2023-2024 Fall', 'credits' => 5.00, 'points' => 4.00, 'earned_points' => 4.00],
            ['student_id' => $student4Id, 'course_code' => 'ELEE341', 'grade' => 'C', 'semester' => '2023-2024 Fall', 'credits' => 5.00, 'points' => 4.00, 'earned_points' => 8.00],
            ['student_id' => $student4Id, 'course_code' => 'SFWE343', 'grade' => 'B', 'semester' => '2023-2024 Fall', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 9.00],
            
            // 2023-2024 Spring
            ['student_id' => $student4Id, 'course_code' => 'CMPE322', 'grade' => 'C', 'semester' => '2023-2024 Spring', 'credits' => 5.00, 'points' => 4.00, 'earned_points' => 8.00],
            ['student_id' => $student4Id, 'course_code' => 'CMPE324', 'grade' => 'B', 'semester' => '2023-2024 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student4Id, 'course_code' => 'ECON101', 'grade' => 'C', 'semester' => '2023-2024 Spring', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 6.00],
            ['student_id' => $student4Id, 'course_code' => 'MATH228', 'grade' => 'B-', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 8.10],
            ['student_id' => $student4Id, 'course_code' => 'MATH328', 'grade' => 'D', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 3.00],
            ['student_id' => $student4Id, 'course_code' => 'SFWE316', 'grade' => 'B+', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 9.90],
            
            // 2024-2025 Fall
            ['student_id' => $student4Id, 'course_code' => 'BUSN102', 'grade' => 'B', 'semester' => '2024-2025 Fall', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student4Id, 'course_code' => 'CMPE403', 'grade' => 'S', 'semester' => '2024-2025 Fall', 'credits' => 2.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student4Id, 'course_code' => 'CMPE421', 'grade' => 'C', 'semester' => '2024-2025 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 6.00],
            ['student_id' => $student4Id, 'course_code' => 'CMPE463', 'grade' => 'C+', 'semester' => '2024-2025 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student4Id, 'course_code' => 'CMPE464', 'grade' => 'D', 'semester' => '2024-2025 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 3.00],
            ['student_id' => $student4Id, 'course_code' => 'ENGR401', 'grade' => 'A-', 'semester' => '2024-2025 Fall', 'credits' => 6.00, 'points' => 2.00, 'earned_points' => 7.40],
            
            // 2024-2025 Spring (Current - In Progress)
            ['student_id' => $student4Id, 'course_code' => 'AINE312', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student4Id, 'course_code' => 'CMPE431', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student4Id, 'course_code' => 'CMPE455', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student4Id, 'course_code' => 'ENGR402', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 10.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student4Id, 'course_code' => 'ENGR404', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 0.00],

            // ===== KAKUMBA MULUMBA (Student ID: 5, Number: 1903010042) =====
            
            // 2019-2020 Fall - English Prep
            ['student_id' => $student5Id, 'course_code' => 'PREP101', 'grade' => 'S', 'semester' => '2019-2020 Fall', 'credits' => 0.00, 'points' => 0.00, 'earned_points' => 0.00],
            
            // 2019-2020 Spring - English Prep
            ['student_id' => $student5Id, 'course_code' => 'PREP103', 'grade' => 'S', 'semester' => '2019-2020 Spring', 'credits' => 0.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student5Id, 'course_code' => 'PREP106', 'grade' => 'S', 'semester' => '2019-2020 Spring', 'credits' => 0.00, 'points' => 0.00, 'earned_points' => 0.00],
            
            // 2020-2021 Fall
            ['student_id' => $student5Id, 'course_code' => 'COMP100', 'grade' => 'C', 'semester' => '2020-2021 Fall', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 6.00],
            ['student_id' => $student5Id, 'course_code' => 'COMP103', 'grade' => 'B+', 'semester' => '2020-2021 Fall', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 6.60],
            ['student_id' => $student5Id, 'course_code' => 'ENGL101', 'grade' => 'B', 'semester' => '2020-2021 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student5Id, 'course_code' => 'MATH101', 'grade' => 'F', 'semester' => '2020-2021 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student5Id, 'course_code' => 'MATH103', 'grade' => 'D+', 'semester' => '2020-2021 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 3.90],
            ['student_id' => $student5Id, 'course_code' => 'PHYS101', 'grade' => 'C+', 'semester' => '2020-2021 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 9.20],
            
            // 2020-2021 Fall Retake
            ['student_id' => $student5Id, 'course_code' => 'MATH101', 'grade' => 'D', 'semester' => '2020-2021 Fall Retake', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            
            // 2020-2021 Spring
            ['student_id' => $student5Id, 'course_code' => 'COMP104', 'grade' => 'F', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student5Id, 'course_code' => 'ENGL102', 'grade' => 'D', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 3.00],
            ['student_id' => $student5Id, 'course_code' => 'MATH102', 'grade' => 'D', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            ['student_id' => $student5Id, 'course_code' => 'MATH104', 'grade' => 'B-', 'semester' => '2020-2021 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 8.10],
            ['student_id' => $student5Id, 'course_code' => 'PHYS102', 'grade' => 'C+', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 9.20],
            
            // 2021-2022 Fall
            ['student_id' => $student5Id, 'course_code' => 'COMP104', 'grade' => 'D', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            ['student_id' => $student5Id, 'course_code' => 'COMP225', 'grade' => 'D-', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 2.80],
            ['student_id' => $student5Id, 'course_code' => 'ELEC235', 'grade' => 'F', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student5Id, 'course_code' => 'ENGL201', 'grade' => 'F', 'semester' => '2021-2022 Fall', 'credits' => 4.00, 'points' => 2.00, 'earned_points' => 0.00],
            ['student_id' => $student5Id, 'course_code' => 'MATH205', 'grade' => 'C+', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 9.20],
            ['student_id' => $student5Id, 'course_code' => 'TURK100', 'grade' => 'D+', 'semester' => '2021-2022 Fall', 'credits' => 2.00, 'points' => 2.00, 'earned_points' => 2.60],
            
            // Continue with more detailed records for all students...
            // Due to length constraints, I'll provide the key structure for the remaining students

            // ===== MOHAMED KARIOUN (Student ID: 6, Number: 2003010108) =====
            // 2020-2021 Fall
            ['student_id' => $student6Id, 'course_code' => 'COMP100', 'grade' => 'A', 'semester' => '2020-2021 Fall', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 12.00],
            ['student_id' => $student6Id, 'course_code' => 'COMP103', 'grade' => 'A-', 'semester' => '2020-2021 Fall', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 7.40],
            ['student_id' => $student6Id, 'course_code' => 'ENGL101', 'grade' => 'C-', 'semester' => '2020-2021 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 5.10],
            ['student_id' => $student6Id, 'course_code' => 'MATH101', 'grade' => 'B', 'semester' => '2020-2021 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 12.00],
            ['student_id' => $student6Id, 'course_code' => 'MATH103', 'grade' => 'C+', 'semester' => '2020-2021 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student6Id, 'course_code' => 'PHYS101', 'grade' => 'C-', 'semester' => '2020-2021 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 6.80],
            
            // Continue with more courses...
            
            // ===== LAMOUBARIKI KARIOUN (Student ID: 7, Number: 2003010134) =====
            // 2020-2021 Spring
            ['student_id' => $student7Id, 'course_code' => 'COMP100', 'grade' => 'A', 'semester' => '2020-2021 Spring', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 12.00],
            ['student_id' => $student7Id, 'course_code' => 'COMP103', 'grade' => 'A', 'semester' => '2020-2021 Spring', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 8.00],
            ['student_id' => $student7Id, 'course_code' => 'ENGL101', 'grade' => 'B', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student7Id, 'course_code' => 'MATH101', 'grade' => 'A', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 16.00],
            ['student_id' => $student7Id, 'course_code' => 'MATH103', 'grade' => 'A-', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 11.10],
            ['student_id' => $student7Id, 'course_code' => 'PHYS101', 'grade' => 'A', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 16.00],
            
            // 2021-2022 Fall
            ['student_id' => $student7Id, 'course_code' => 'COMP104', 'grade' => 'B-', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 10.80],
            ['student_id' => $student7Id, 'course_code' => 'ENGL102', 'grade' => 'B', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student7Id, 'course_code' => 'MATH102', 'grade' => 'C-', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 6.80],
            ['student_id' => $student7Id, 'course_code' => 'MATH104', 'grade' => 'C', 'semester' => '2021-2022 Fall', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 6.00],
            ['student_id' => $student7Id, 'course_code' => 'PHYS102', 'grade' => 'F', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            
            // 2021-2022 Fall Retake
            ['student_id' => $student7Id, 'course_code' => 'PHYS102', 'grade' => 'D+', 'semester' => '2021-2022 Fall Retake', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 5.20],
            
            // 2021-2022 Spring
            ['student_id' => $student7Id, 'course_code' => 'COMP215', 'grade' => 'C+', 'semester' => '2021-2022 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 9.20],
            ['student_id' => $student7Id, 'course_code' => 'COMP216', 'grade' => 'B', 'semester' => '2021-2022 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 12.00],
            ['student_id' => $student7Id, 'course_code' => 'ECON101', 'grade' => 'B+', 'semester' => '2021-2022 Spring', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 9.90],
            ['student_id' => $student7Id, 'course_code' => 'ELEC235', 'grade' => 'F', 'semester' => '2021-2022 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student7Id, 'course_code' => 'MATH206', 'grade' => 'A', 'semester' => '2021-2022 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 12.00],
            
            // 2022-2023 Fall
            ['student_id' => $student7Id, 'course_code' => 'COMP225', 'grade' => 'A', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 16.00],
            ['student_id' => $student7Id, 'course_code' => 'ELEC235', 'grade' => 'C+', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 9.20],
            ['student_id' => $student7Id, 'course_code' => 'ENGL201', 'grade' => 'A-', 'semester' => '2022-2023 Fall', 'credits' => 4.00, 'points' => 2.00, 'earned_points' => 7.40],
            ['student_id' => $student7Id, 'course_code' => 'ITAL101', 'grade' => 'A-', 'semester' => '2022-2023 Fall', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 11.10],
            ['student_id' => $student7Id, 'course_code' => 'MATH205', 'grade' => 'B', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 12.00],
            ['student_id' => $student7Id, 'course_code' => 'TURK100', 'grade' => 'B+', 'semester' => '2022-2023 Fall', 'credits' => 2.00, 'points' => 2.00, 'earned_points' => 6.60],
            
            // 2022-2023 Spring
            ['student_id' => $student7Id, 'course_code' => 'COMP232', 'grade' => 'A', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 12.00],
            ['student_id' => $student7Id, 'course_code' => 'COMP324', 'grade' => 'B+', 'semester' => '2022-2023 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 9.90],
            ['student_id' => $student7Id, 'course_code' => 'COMP332', 'grade' => 'B-', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 10.80],
            ['student_id' => $student7Id, 'course_code' => 'COMP342', 'grade' => 'D+', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 5.20],
            ['student_id' => $student7Id, 'course_code' => 'ELEC240', 'grade' => 'B-', 'semester' => '2022-2023 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 8.10],
            
            // 2023-2024 Fall
            ['student_id' => $student7Id, 'course_code' => 'COMP321', 'grade' => 'A', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 16.00],
            ['student_id' => $student7Id, 'course_code' => 'COMP333', 'grade' => 'A-', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 11.10],
            ['student_id' => $student7Id, 'course_code' => 'COMP341', 'grade' => 'A', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 16.00],
            ['student_id' => $student7Id, 'course_code' => 'COMP351', 'grade' => 'A', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 16.00],
            ['student_id' => $student7Id, 'course_code' => 'MATH309', 'grade' => 'A', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 12.00],
            
            // 2023-2024 Spring
            ['student_id' => $student7Id, 'course_code' => 'COMP322', 'grade' => 'A-', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 11.10],
            ['student_id' => $student7Id, 'course_code' => 'COMP352', 'grade' => 'B', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student7Id, 'course_code' => 'COMP401', 'grade' => 'A-', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 11.10],
            ['student_id' => $student7Id, 'course_code' => 'COMP403', 'grade' => 'S', 'semester' => '2023-2024 Spring', 'credits' => 1.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student7Id, 'course_code' => 'COMP454', 'grade' => 'A-', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 11.10],
            ['student_id' => $student7Id, 'course_code' => 'COMP455', 'grade' => 'A', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 12.00],
            
            // 2024-2025 Fall
            ['student_id' => $student7Id, 'course_code' => 'COMP404', 'grade' => 'A-', 'semester' => '2024-2025 Fall', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 7.40],
            ['student_id' => $student7Id, 'course_code' => 'COMP463', 'grade' => 'D', 'semester' => '2024-2025 Fall', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 3.00],
            ['student_id' => $student7Id, 'course_code' => 'COMP464', 'grade' => 'C+', 'semester' => '2024-2025 Fall', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student7Id, 'course_code' => 'COMP471', 'grade' => 'C+', 'semester' => '2024-2025 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student7Id, 'course_code' => 'SPAN101', 'grade' => 'B+', 'semester' => '2024-2025 Fall', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 9.90],
            
            // 2024-2025 Spring (Current)
            ['student_id' => $student7Id, 'course_code' => 'COMP402', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 8.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student7Id, 'course_code' => 'COMP465', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 0.00],

            // ===== JUMANAZAROV ORAZ (Student ID: 8, Number: 1903010033) =====
            // 2019-2020 Fall - English Prep
            ['student_id' => $student8Id, 'course_code' => 'PREP101', 'grade' => 'S', 'semester' => '2019-2020 Fall', 'credits' => 0.00, 'points' => 0.00, 'earned_points' => 0.00],
            
            // 2019-2020 Spring - English Prep
            ['student_id' => $student8Id, 'course_code' => 'PREP103', 'grade' => 'S', 'semester' => '2019-2020 Spring', 'credits' => 0.00, 'points' => 0.00, 'earned_points' => 0.00],
            
            // 2020-2021 English Proficiency Test
            ['student_id' => $student8Id, 'course_code' => 'PREP106', 'grade' => 'S', 'semester' => '2020-2021 Proficiency', 'credits' => 0.00, 'points' => 0.00, 'earned_points' => 0.00],
            
            // 2020-2021 Fall
            ['student_id' => $student8Id, 'course_code' => 'COMP100', 'grade' => 'F', 'semester' => '2020-2021 Fall', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student8Id, 'course_code' => 'COMP103', 'grade' => 'C', 'semester' => '2020-2021 Fall', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 4.00],
            ['student_id' => $student8Id, 'course_code' => 'ENGL101', 'grade' => 'C+', 'semester' => '2020-2021 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student8Id, 'course_code' => 'MATH101', 'grade' => 'F', 'semester' => '2020-2021 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student8Id, 'course_code' => 'MATH103', 'grade' => 'F', 'semester' => '2020-2021 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student8Id, 'course_code' => 'PHYS101', 'grade' => 'D', 'semester' => '2020-2021 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            
            // 2020-2021 Fall Retake
            ['student_id' => $student8Id, 'course_code' => 'COMP100', 'grade' => 'C-', 'semester' => '2020-2021 Fall Retake', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 5.10],
            ['student_id' => $student8Id, 'course_code' => 'MATH101', 'grade' => 'D', 'semester' => '2020-2021 Fall Retake', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            ['student_id' => $student8Id, 'course_code' => 'MATH103', 'grade' => 'F', 'semester' => '2020-2021 Fall Retake', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 0.00],
            
            // 2020-2021 Spring
            ['student_id' => $student8Id, 'course_code' => 'COMP104', 'grade' => 'F', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student8Id, 'course_code' => 'ENGL102', 'grade' => 'D+', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 3.90],
            ['student_id' => $student8Id, 'course_code' => 'MATH102', 'grade' => 'D-', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 2.80],
            ['student_id' => $student8Id, 'course_code' => 'MATH103', 'grade' => 'D', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 3.00],
            ['student_id' => $student8Id, 'course_code' => 'PHYS102', 'grade' => 'C-', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 6.80],
            
            // 2021-2022 Fall
            ['student_id' => $student8Id, 'course_code' => 'COMP104', 'grade' => 'C+', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 9.20],
            ['student_id' => $student8Id, 'course_code' => 'ELEC235', 'grade' => 'F', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student8Id, 'course_code' => 'MATH102', 'grade' => 'F', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student8Id, 'course_code' => 'MATH104', 'grade' => 'F', 'semester' => '2021-2022 Fall', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student8Id, 'course_code' => 'PHYS101', 'grade' => 'F', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            
            // Continue with more semester records for Jumanazarov Oraz...
            // 2021-2022 Spring
            ['student_id' => $student8Id, 'course_code' => 'COMP100', 'grade' => 'A-', 'semester' => '2021-2022 Spring', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 11.10],
            ['student_id' => $student8Id, 'course_code' => 'ELEC235', 'grade' => 'F', 'semester' => '2021-2022 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student8Id, 'course_code' => 'MATH102', 'grade' => 'F', 'semester' => '2021-2022 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student8Id, 'course_code' => 'MATH104', 'grade' => 'C+', 'semester' => '2021-2022 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student8Id, 'course_code' => 'PHYS101', 'grade' => 'F', 'semester' => '2021-2022 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            
            // 2021-2022 Summer
            ['student_id' => $student8Id, 'course_code' => 'COMP215', 'grade' => 'A', 'semester' => '2021-2022 Summer', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 16.00],
            ['student_id' => $student8Id, 'course_code' => 'COMP232', 'grade' => 'C+', 'semester' => '2021-2022 Summer', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 6.90],
            
            // 2022-2023 Fall
            ['student_id' => $student8Id, 'course_code' => 'BUSN101', 'grade' => 'D', 'semester' => '2022-2023 Fall', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 3.00],
            ['student_id' => $student8Id, 'course_code' => 'COMP225', 'grade' => 'C', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 8.00],
            ['student_id' => $student8Id, 'course_code' => 'ELEC235', 'grade' => 'D', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            ['student_id' => $student8Id, 'course_code' => 'MATH205', 'grade' => 'F', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student8Id, 'course_code' => 'PHYS101', 'grade' => 'D', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            
            // 2022-2023 Spring
            ['student_id' => $student8Id, 'course_code' => 'COMP216', 'grade' => 'C+', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 9.20],
            ['student_id' => $student8Id, 'course_code' => 'COMP332', 'grade' => 'B-', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 10.80],
            ['student_id' => $student8Id, 'course_code' => 'ELEC240', 'grade' => 'B-', 'semester' => '2022-2023 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 8.10],
            ['student_id' => $student8Id, 'course_code' => 'MATH206', 'grade' => 'D', 'semester' => '2022-2023 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 3.00],
            ['student_id' => $student8Id, 'course_code' => 'TURK100', 'grade' => 'A', 'semester' => '2022-2023 Spring', 'credits' => 2.00, 'points' => 2.00, 'earned_points' => 8.00],
            
            // 2023-2024 Fall
            ['student_id' => $student8Id, 'course_code' => 'COMP321', 'grade' => 'A', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 16.00],
            ['student_id' => $student8Id, 'course_code' => 'COMP341', 'grade' => 'C', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 8.00],
            ['student_id' => $student8Id, 'course_code' => 'COMP351', 'grade' => 'C', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 8.00],
            ['student_id' => $student8Id, 'course_code' => 'ENGL201', 'grade' => 'B+', 'semester' => '2023-2024 Fall', 'credits' => 4.00, 'points' => 2.00, 'earned_points' => 6.60],
            ['student_id' => $student8Id, 'course_code' => 'MATH205', 'grade' => 'F', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            
            // 2023-2024 Spring
            ['student_id' => $student8Id, 'course_code' => 'COMP322', 'grade' => 'C-', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 5.10],
            ['student_id' => $student8Id, 'course_code' => 'COMP324', 'grade' => 'D', 'semester' => '2023-2024 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 3.00],
            ['student_id' => $student8Id, 'course_code' => 'COMP342', 'grade' => 'B-', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 10.80],
            ['student_id' => $student8Id, 'course_code' => 'COMP352', 'grade' => 'C+', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student8Id, 'course_code' => 'ECON101', 'grade' => 'B', 'semester' => '2023-2024 Spring', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 9.00],
            
            // 2024-2025 Fall
            ['student_id' => $student8Id, 'course_code' => 'COMP401', 'grade' => 'B+', 'semester' => '2024-2025 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 9.90],
            ['student_id' => $student8Id, 'course_code' => 'COMP403', 'grade' => 'S', 'semester' => '2024-2025 Fall', 'credits' => 1.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student8Id, 'course_code' => 'COMP463', 'grade' => 'C-', 'semester' => '2024-2025 Fall', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 5.10],
            ['student_id' => $student8Id, 'course_code' => 'COMP471', 'grade' => 'D', 'semester' => '2024-2025 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 3.00],
            ['student_id' => $student8Id, 'course_code' => 'MATH205', 'grade' => 'B-', 'semester' => '2024-2025 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 10.80],
            
            // 2024-2025 Spring (Current)
            ['student_id' => $student8Id, 'course_code' => 'COMP402', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 8.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student8Id, 'course_code' => 'COMP404', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 0.00],
            ['student_id' => $student8Id, 'course_code' => 'COMP454', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student8Id, 'course_code' => 'HESC109', 'grade' => 'C+', 'semester' => '2024-2025 Spring', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student8Id, 'course_code' => 'MATH309', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student8Id, 'course_code' => 'SOFT422', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 0.00],

            // ===== COMPLETING MOHAMED KARIOUN (Student ID: 6, Number: 2003010108) =====
            // 2020-2021 Spring
            ['student_id' => $student6Id, 'course_code' => 'COMP104', 'grade' => 'D-', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 2.80],
            ['student_id' => $student6Id, 'course_code' => 'ENGL102', 'grade' => 'B-', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 8.10],
            ['student_id' => $student6Id, 'course_code' => 'MATH102', 'grade' => 'C+', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 9.20],
            ['student_id' => $student6Id, 'course_code' => 'MATH104', 'grade' => 'A-', 'semester' => '2020-2021 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 11.10],
            ['student_id' => $student6Id, 'course_code' => 'PHYS102', 'grade' => 'B-', 'semester' => '2020-2021 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 10.80],
            
            // 2020-2021 Spring Retake
            ['student_id' => $student6Id, 'course_code' => 'COMP104', 'grade' => 'D', 'semester' => '2020-2021 Spring Retake', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            
            // 2021-2022 Fall
            ['student_id' => $student6Id, 'course_code' => 'COMP215', 'grade' => 'NG', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student6Id, 'course_code' => 'COMP225', 'grade' => 'NG', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student6Id, 'course_code' => 'ELEC235', 'grade' => 'NG', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student6Id, 'course_code' => 'ENGL201', 'grade' => 'F', 'semester' => '2021-2022 Fall', 'credits' => 4.00, 'points' => 2.00, 'earned_points' => 0.00],
            ['student_id' => $student6Id, 'course_code' => 'MATH205', 'grade' => 'NG', 'semester' => '2021-2022 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student6Id, 'course_code' => 'MGMT101', 'grade' => 'NG', 'semester' => '2021-2022 Fall', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 0.00],
            
            // 2021-2022 Spring
            ['student_id' => $student6Id, 'course_code' => 'COMP215', 'grade' => 'D', 'semester' => '2021-2022 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            ['student_id' => $student6Id, 'course_code' => 'COMP216', 'grade' => 'B+', 'semester' => '2021-2022 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 13.20],
            ['student_id' => $student6Id, 'course_code' => 'ECON101', 'grade' => 'C+', 'semester' => '2021-2022 Spring', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student6Id, 'course_code' => 'ELEC235', 'grade' => 'F', 'semester' => '2021-2022 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student6Id, 'course_code' => 'MATH206', 'grade' => 'D', 'semester' => '2021-2022 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 3.00],
            
            // 2022-2023 Fall
            ['student_id' => $student6Id, 'course_code' => 'COMP225', 'grade' => 'D+', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 5.20],
            ['student_id' => $student6Id, 'course_code' => 'ELEC235', 'grade' => 'D', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            ['student_id' => $student6Id, 'course_code' => 'ENGL201', 'grade' => 'B+', 'semester' => '2022-2023 Fall', 'credits' => 4.00, 'points' => 2.00, 'earned_points' => 6.60],
            ['student_id' => $student6Id, 'course_code' => 'ITAL101', 'grade' => 'B-', 'semester' => '2022-2023 Fall', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 8.10],
            ['student_id' => $student6Id, 'course_code' => 'MATH205', 'grade' => 'D', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            ['student_id' => $student6Id, 'course_code' => 'TURK100', 'grade' => 'C', 'semester' => '2022-2023 Fall', 'credits' => 2.00, 'points' => 2.00, 'earned_points' => 4.00],
            
            // 2022-2023 Spring
            ['student_id' => $student6Id, 'course_code' => 'COMP232', 'grade' => 'B-', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 8.10],
            ['student_id' => $student6Id, 'course_code' => 'COMP324', 'grade' => 'B-', 'semester' => '2022-2023 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 8.10],
            ['student_id' => $student6Id, 'course_code' => 'COMP332', 'grade' => 'C+', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 9.20],
            ['student_id' => $student6Id, 'course_code' => 'COMP342', 'grade' => 'F', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student6Id, 'course_code' => 'ELEC240', 'grade' => 'C', 'semester' => '2022-2023 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 6.00],
            
            // 2023-2024 Fall
            ['student_id' => $student6Id, 'course_code' => 'COMP321', 'grade' => 'A', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 16.00],
            ['student_id' => $student6Id, 'course_code' => 'COMP333', 'grade' => 'B', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student6Id, 'course_code' => 'COMP341', 'grade' => 'C+', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 9.20],
            ['student_id' => $student6Id, 'course_code' => 'COMP351', 'grade' => 'B+', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 13.20],
            ['student_id' => $student6Id, 'course_code' => 'MATH309', 'grade' => 'A', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 12.00],
            
            // 2023-2024 Spring
            ['student_id' => $student6Id, 'course_code' => 'COMP322', 'grade' => 'C-', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 5.10],
            ['student_id' => $student6Id, 'course_code' => 'COMP342', 'grade' => 'C', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 8.00],
            ['student_id' => $student6Id, 'course_code' => 'COMP352', 'grade' => 'C-', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 5.10],
            ['student_id' => $student6Id, 'course_code' => 'COMP401', 'grade' => 'A-', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 11.10],
            ['student_id' => $student6Id, 'course_code' => 'COMP403', 'grade' => 'S', 'semester' => '2023-2024 Spring', 'credits' => 1.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student6Id, 'course_code' => 'COMP404', 'grade' => 'B+', 'semester' => '2023-2024 Spring', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 6.60],
            
            // 2024-2025 Fall
            ['student_id' => $student6Id, 'course_code' => 'COMP421', 'grade' => 'C+', 'semester' => '2024-2025 Fall', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student6Id, 'course_code' => 'COMP463', 'grade' => 'C', 'semester' => '2024-2025 Fall', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 6.00],
            ['student_id' => $student6Id, 'course_code' => 'COMP464', 'grade' => 'A', 'semester' => '2024-2025 Fall', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 12.00],
            ['student_id' => $student6Id, 'course_code' => 'COMP471', 'grade' => 'C+', 'semester' => '2024-2025 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student6Id, 'course_code' => 'MGMT101', 'grade' => 'F', 'semester' => '2024-2025 Fall', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 0.00],
            
            // 2024-2025 Spring (Current)
            ['student_id' => $student6Id, 'course_code' => 'COMP402', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 8.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student6Id, 'course_code' => 'COMP454', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student6Id, 'course_code' => 'COMP465', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student6Id, 'course_code' => 'SPAN101', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 0.00],

            // ===== COMPLETING KAKUMBA MULUMBA (Student ID: 5, Number: 1903010042) - Additional Semesters =====
            // 2021-2022 Fall Retake
            ['student_id' => $student5Id, 'course_code' => 'COMP225', 'grade' => 'D', 'semester' => '2021-2022 Fall Retake', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            ['student_id' => $student5Id, 'course_code' => 'ELEC235', 'grade' => 'F', 'semester' => '2021-2022 Fall Retake', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student5Id, 'course_code' => 'ENGL201', 'grade' => 'D', 'semester' => '2021-2022 Fall Retake', 'credits' => 4.00, 'points' => 2.00, 'earned_points' => 2.00],
            
            // 2021-2022 Spring
            ['student_id' => $student5Id, 'course_code' => 'COMP215', 'grade' => 'F', 'semester' => '2021-2022 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student5Id, 'course_code' => 'COMP216', 'grade' => 'F', 'semester' => '2021-2022 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student5Id, 'course_code' => 'COMP232', 'grade' => 'F', 'semester' => '2021-2022 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student5Id, 'course_code' => 'ELEC235', 'grade' => 'F', 'semester' => '2021-2022 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student5Id, 'course_code' => 'MATH206', 'grade' => 'F', 'semester' => '2021-2022 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 0.00],
            
            // Continue with remaining semesters for Kakumba Mulumba...
            // 2022-2023 Fall
            ['student_id' => $student5Id, 'course_code' => 'COMP321', 'grade' => 'B+', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 13.20],
            ['student_id' => $student5Id, 'course_code' => 'COMP351', 'grade' => 'C+', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 9.20],
            ['student_id' => $student5Id, 'course_code' => 'ELEC235', 'grade' => 'F', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student5Id, 'course_code' => 'ENGL102', 'grade' => 'B', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student5Id, 'course_code' => 'MATH101', 'grade' => 'F', 'semester' => '2022-2023 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 0.00],
            
            // 2022-2023 Spring
            ['student_id' => $student5Id, 'course_code' => 'COMP216', 'grade' => 'D', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            ['student_id' => $student5Id, 'course_code' => 'COMP232', 'grade' => 'D', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 3.00],
            ['student_id' => $student5Id, 'course_code' => 'ELEC235', 'grade' => 'D+', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 5.20],
            ['student_id' => $student5Id, 'course_code' => 'MATH101', 'grade' => 'B-', 'semester' => '2022-2023 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 10.80],
            ['student_id' => $student5Id, 'course_code' => 'MATH206', 'grade' => 'D', 'semester' => '2022-2023 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 3.00],
            
            // 2023-2024 Fall
            ['student_id' => $student5Id, 'course_code' => 'COMP333', 'grade' => 'C+', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student5Id, 'course_code' => 'COMP341', 'grade' => 'C+', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 9.20],
            ['student_id' => $student5Id, 'course_code' => 'ELEC240', 'grade' => 'D', 'semester' => '2023-2024 Fall', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 3.00],
            ['student_id' => $student5Id, 'course_code' => 'MATH309', 'grade' => 'C+', 'semester' => '2023-2024 Fall', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student5Id, 'course_code' => 'SOCI320', 'grade' => 'A', 'semester' => '2023-2024 Fall', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 12.00],
            ['student_id' => $student5Id, 'course_code' => 'SOFT431', 'grade' => 'C', 'semester' => '2023-2024 Fall', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 6.00],
            
            // 2023-2024 Spring
            ['student_id' => $student5Id, 'course_code' => 'COMP322', 'grade' => 'C-', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 5.10],
            ['student_id' => $student5Id, 'course_code' => 'COMP324', 'grade' => 'B', 'semester' => '2023-2024 Spring', 'credits' => 5.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student5Id, 'course_code' => 'COMP332', 'grade' => 'D', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            ['student_id' => $student5Id, 'course_code' => 'COMP342', 'grade' => 'D', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 4.00, 'earned_points' => 4.00],
            ['student_id' => $student5Id, 'course_code' => 'COMP401', 'grade' => 'A', 'semester' => '2023-2024 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 12.00],
            
            // 2024-2025 Fall - Not Registered
            // No records for this semester
            
            // 2024-2025 Spring (Current)
            ['student_id' => $student5Id, 'course_code' => 'AINE332', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student5Id, 'course_code' => 'COMP402', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 8.00, 'points' => 4.00, 'earned_points' => 0.00],
            ['student_id' => $student5Id, 'course_code' => 'COMP431', 'grade' => 'C', 'semester' => '2024-2025 Spring', 'credits' => 7.00, 'points' => 3.00, 'earned_points' => 6.00],
            ['student_id' => $student5Id, 'course_code' => 'COMP454', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 6.00, 'points' => 3.00, 'earned_points' => 0.00],
            ['student_id' => $student5Id, 'course_code' => 'ITAL101', 'grade' => 'C+', 'semester' => '2024-2025 Spring', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 6.90],
            ['student_id' => $student9Id, 'course_code' => 'PREP101', 'grade' => 'S', 'semester' => '2019-2020 Spring', 'credits' => 0.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student9Id, 'course_code' => 'PREP106', 'grade' => 'S', 'semester' => '2020-2021 English Preparatory School Exemption Test', 'credits' => 0.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP100', 'grade' => 'C', 'semester' => '2020-2021 Fall', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 6.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP103', 'grade' => 'B+', 'semester' => '2020-2021 Fall', 'credits' => 2.00, 'points' => 3.30, 'earned_points' => 6.60],
            ['student_id' => $student9Id, 'course_code' => 'ENGL101', 'grade' => 'D+', 'semester' => '2020-2021 Fall', 'credits' => 3.00, 'points' => 1.30, 'earned_points' => 3.90],
            ['student_id' => $student9Id, 'course_code' => 'MATH101', 'grade' => 'F', 'semester' => '2020-2021 Fall', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student9Id, 'course_code' => 'MATH103', 'grade' => 'C', 'semester' => '2020-2021 Fall', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 6.00],
            ['student_id' => $student9Id, 'course_code' => 'PHYS101', 'grade' => 'D', 'semester' => '2020-2021 Fall', 'credits' => 4.00, 'points' => 1.00, 'earned_points' => 4.00],
            ['student_id' => $student9Id, 'course_code' => 'MATH101', 'grade' => 'F', 'semester' => '2020-2021 13-Bütünleme(Güz)', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP104', 'grade' => 'F', 'semester' => '2020-2021 Spring', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student9Id, 'course_code' => 'ENGL102', 'grade' => 'C+', 'semester' => '2020-2021 Spring', 'credits' => 3.00, 'points' => 2.30, 'earned_points' => 6.90],
            ['student_id' => $student9Id, 'course_code' => 'MATH101', 'grade' => 'D-', 'semester' => '2020-2021 Spring', 'credits' => 4.00, 'points' => 0.70, 'earned_points' => 2.80],
            ['student_id' => $student9Id, 'course_code' => 'MATH104', 'grade' => 'C+', 'semester' => '2020-2021 Spring', 'credits' => 3.00, 'points' => 2.30, 'earned_points' => 6.90],
            ['student_id' => $student9Id, 'course_code' => 'PHYS102', 'grade' => 'F', 'semester' => '2020-2021 Spring', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP104', 'grade' => 'F', 'semester' => '2020-2021 17-Bütünleme(Bahar)', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student9Id, 'course_code' => 'MATH101', 'grade' => 'D', 'semester' => '2020-2021 17-Bütünleme(Bahar)', 'credits' => 4.00, 'points' => 1.00, 'earned_points' => 4.00],
            ['student_id' => $student9Id, 'course_code' => 'PHYS102', 'grade' => 'F', 'semester' => '2020-2021 17-Bütünleme(Bahar)', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP104', 'grade' => 'B+', 'semester' => '2021-2022 Fall', 'credits' => 4.00, 'points' => 3.30, 'earned_points' => 13.20],
            ['student_id' => $student9Id, 'course_code' => 'ELEC235', 'grade' => 'F', 'semester' => '2021-2022 Fall', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student9Id, 'course_code' => 'ENGL101', 'grade' => 'B', 'semester' => '2021-2022 Fall', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student9Id, 'course_code' => 'MATH102', 'grade' => 'D-', 'semester' => '2021-2022 Fall', 'credits' => 4.00, 'points' => 0.70, 'earned_points' => 2.80],
            ['student_id' => $student9Id, 'course_code' => 'PHYS102', 'grade' => 'C+', 'semester' => '2021-2022 Fall', 'credits' => 4.00, 'points' => 2.30, 'earned_points' => 9.20],
            ['student_id' => $student9Id, 'course_code' => 'ELEC235', 'grade' => 'D', 'semester' => '2021-2022 13-Bütünleme(Güz)', 'credits' => 4.00, 'points' => 1.00, 'earned_points' => 4.00],
            ['student_id' => $student9Id, 'course_code' => 'MATH102', 'grade' => 'D', 'semester' => '2021-2022 13-Bütünleme(Güz)', 'credits' => 4.00, 'points' => 1.00, 'earned_points' => 4.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP215', 'grade' => 'C+', 'semester' => '2021-2022 Spring', 'credits' => 4.00, 'points' => 2.30, 'earned_points' => 9.20],
            ['student_id' => $student9Id, 'course_code' => 'COMP216', 'grade' => 'C', 'semester' => '2021-2022 Spring', 'credits' => 4.00, 'points' => 2.00, 'earned_points' => 8.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP232', 'grade' => 'F', 'semester' => '2021-2022 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student9Id, 'course_code' => 'ELEC240', 'grade' => 'B-', 'semester' => '2021-2022 Spring', 'credits' => 3.00, 'points' => 2.70, 'earned_points' => 8.10],
            ['student_id' => $student9Id, 'course_code' => 'MATH206', 'grade' => 'D+', 'semester' => '2021-2022 Spring', 'credits' => 3.00, 'points' => 1.30, 'earned_points' => 3.90],
            ['student_id' => $student9Id, 'course_code' => 'MGMT101', 'grade' => 'B', 'semester' => '2021-2022 Spring', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP232', 'grade' => 'F', 'semester' => '2021-2022 17-Bütünleme(Bahar)', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student9Id, 'course_code' => 'BUSN104', 'grade' => 'B', 'semester' => '2022-2023 Fall', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP225', 'grade' => 'B+', 'semester' => '2022-2023 Fall', 'credits' => 4.00, 'points' => 3.30, 'earned_points' => 13.20],
            ['student_id' => $student9Id, 'course_code' => 'COMP341', 'grade' => 'F', 'semester' => '2022-2023 Fall', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student9Id, 'course_code' => 'ENGL201', 'grade' => 'A', 'semester' => '2022-2023 Fall', 'credits' => 2.00, 'points' => 4.00, 'earned_points' => 8.00],
            ['student_id' => $student9Id, 'course_code' => 'MATH205', 'grade' => 'F', 'semester' => '2022-2023 Fall', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP232', 'grade' => 'A', 'semester' => '2022-2023 Spring', 'credits' => 3.00, 'points' => 4.00, 'earned_points' => 12.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP324', 'grade' => 'A', 'semester' => '2022-2023 Spring', 'credits' => 3.00, 'points' => 4.00, 'earned_points' => 12.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP332', 'grade' => 'A', 'semester' => '2022-2023 Spring', 'credits' => 4.00, 'points' => 4.00, 'earned_points' => 16.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP352', 'grade' => 'B', 'semester' => '2022-2023 Spring', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student9Id, 'course_code' => 'ECON101', 'grade' => 'A', 'semester' => '2022-2023 Spring', 'credits' => 3.00, 'points' => 4.00, 'earned_points' => 12.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP321', 'grade' => 'A', 'semester' => '2023-2024 Fall', 'credits' => 4.00, 'points' => 4.00, 'earned_points' => 16.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP341', 'grade' => 'A', 'semester' => '2023-2024 Fall', 'credits' => 4.00, 'points' => 4.00, 'earned_points' => 16.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP351', 'grade' => 'A-', 'semester' => '2023-2024 Fall', 'credits' => 4.00, 'points' => 3.70, 'earned_points' => 14.80],
            ['student_id' => $student9Id, 'course_code' => 'MATH205', 'grade' => 'D', 'semester' => '2023-2024 Fall', 'credits' => 4.00, 'points' => 1.00, 'earned_points' => 4.00],
            ['student_id' => $student9Id, 'course_code' => 'TURK100', 'grade' => 'C+', 'semester' => '2023-2024 Fall', 'credits' => 2.00, 'points' => 2.30, 'earned_points' => 4.60],
            ['student_id' => $student9Id, 'course_code' => 'COMP322', 'grade' => 'B', 'semester' => '2023-2024 Spring', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP401', 'grade' => 'A-', 'semester' => '2023-2024 Spring', 'credits' => 3.00, 'points' => 3.70, 'earned_points' => 11.10],
            ['student_id' => $student9Id, 'course_code' => 'COMP432', 'grade' => 'A', 'semester' => '2023-2024 Spring', 'credits' => 3.00, 'points' => 4.00, 'earned_points' => 12.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP454', 'grade' => 'D', 'semester' => '2023-2024 Spring', 'credits' => 3.00, 'points' => 1.00, 'earned_points' => 3.00],
            ['student_id' => $student9Id, 'course_code' => 'ELEC421', 'grade' => 'A', 'semester' => '2023-2024 Spring', 'credits' => 3.00, 'points' => 4.00, 'earned_points' => 12.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP333', 'grade' => 'B-', 'semester' => '2024-2025 Fall', 'credits' => 3.00, 'points' => 2.70, 'earned_points' => 8.10],
            ['student_id' => $student9Id, 'course_code' => 'COMP403', 'grade' => 'S', 'semester' => '2024-2025 Fall', 'credits' => 0.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP404', 'grade' => 'A', 'semester' => '2024-2025 Fall', 'credits' => 2.00, 'points' => 4.00, 'earned_points' => 8.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP464', 'grade' => 'D-', 'semester' => '2024-2025 Fall', 'credits' => 3.00, 'points' => 0.70, 'earned_points' => 2.10],
            ['student_id' => $student9Id, 'course_code' => 'COMP471', 'grade' => 'D', 'semester' => '2024-2025 Fall', 'credits' => 3.00, 'points' => 1.00, 'earned_points' => 3.00],
            ['student_id' => $student9Id, 'course_code' => 'MATH309', 'grade' => 'C-', 'semester' => '2024-2025 Fall', 'credits' => 3.00, 'points' => 1.70, 'earned_points' => 5.10],
            ['student_id' => $student9Id, 'course_code' => 'COMP342', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student9Id, 'course_code' => 'COMP402', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student9Id, 'course_code' => 'SOFT422', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student9Id, 'course_code' => 'SOFT475', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            
            // Student 10: Perpetual Dumebi Isaiah Asaka (2103060171)
            ['student_id' => $student10Id, 'course_code' => 'ENGL101', 'grade' => 'E', 'semester' => 'Exempted Courses', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student10Id, 'course_code' => 'ENGL102', 'grade' => 'E', 'semester' => 'Exempted Courses', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student10Id, 'course_code' => 'MATH102', 'grade' => 'E', 'semester' => 'Exempted Courses', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student10Id, 'course_code' => 'MATH103', 'grade' => 'E', 'semester' => 'Exempted Courses', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student10Id, 'course_code' => 'MATH206', 'grade' => 'E', 'semester' => 'Exempted Courses', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student10Id, 'course_code' => 'MATH309', 'grade' => 'E', 'semester' => 'Exempted Courses', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student10Id, 'course_code' => 'PHYS101', 'grade' => 'E', 'semester' => 'Exempted Courses', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student10Id, 'course_code' => 'SOFT100', 'grade' => 'E', 'semester' => 'Exempted Courses', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student10Id, 'course_code' => 'SOFT103', 'grade' => 'E', 'semester' => 'Exempted Courses', 'credits' => 2.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student10Id, 'course_code' => 'BUSN101', 'grade' => 'A-', 'semester' => '2021-2022 Spring', 'credits' => 3.00, 'points' => 3.70, 'earned_points' => 11.10],
            ['student_id' => $student10Id, 'course_code' => 'MATH101', 'grade' => 'C-', 'semester' => '2021-2022 Spring', 'credits' => 4.00, 'points' => 1.70, 'earned_points' => 6.80],
            ['student_id' => $student10Id, 'course_code' => 'MATH104', 'grade' => 'A', 'semester' => '2021-2022 Spring', 'credits' => 3.00, 'points' => 4.00, 'earned_points' => 12.00],
            ['student_id' => $student10Id, 'course_code' => 'PHYS102', 'grade' => 'D', 'semester' => '2021-2022 Spring', 'credits' => 4.00, 'points' => 1.00, 'earned_points' => 4.00],
            ['student_id' => $student10Id, 'course_code' => 'SOFT104', 'grade' => 'A', 'semester' => '2021-2022 Spring', 'credits' => 4.00, 'points' => 4.00, 'earned_points' => 16.00],
            ['student_id' => $student10Id, 'course_code' => 'TURK100', 'grade' => 'C+', 'semester' => '2021-2022 Spring', 'credits' => 2.00, 'points' => 2.30, 'earned_points' => 4.60],
            ['student_id' => $student10Id, 'course_code' => 'COMP225', 'grade' => 'A-', 'semester' => '2022-2023 Fall', 'credits' => 4.00, 'points' => 3.70, 'earned_points' => 14.80],
            ['student_id' => $student10Id, 'course_code' => 'ENGL201', 'grade' => 'A-', 'semester' => '2022-2023 Fall', 'credits' => 2.00, 'points' => 3.70, 'earned_points' => 7.40],
            ['student_id' => $student10Id, 'course_code' => 'HIST100', 'grade' => 'B', 'semester' => '2022-2023 Fall', 'credits' => 2.00, 'points' => 3.00, 'earned_points' => 6.00],
            ['student_id' => $student10Id, 'course_code' => 'MATH205', 'grade' => 'C+', 'semester' => '2022-2023 Fall', 'credits' => 4.00, 'points' => 2.30, 'earned_points' => 9.20],
            ['student_id' => $student10Id, 'course_code' => 'SOFT215', 'grade' => 'B-', 'semester' => '2022-2023 Fall', 'credits' => 4.00, 'points' => 2.70, 'earned_points' => 10.80],
            ['student_id' => $student10Id, 'course_code' => 'SOFT235', 'grade' => 'F', 'semester' => '2022-2023 Fall', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student10Id, 'course_code' => 'COMP455', 'grade' => 'C-', 'semester' => '2022-2023 Spring', 'credits' => 3.00, 'points' => 1.70, 'earned_points' => 5.10],
            ['student_id' => $student10Id, 'course_code' => 'GRAD282', 'grade' => 'A-', 'semester' => '2022-2023 Spring', 'credits' => 3.00, 'points' => 3.70, 'earned_points' => 11.10],
            ['student_id' => $student10Id, 'course_code' => 'SOFT235', 'grade' => 'D', 'semester' => '2022-2023 Spring', 'credits' => 4.00, 'points' => 1.00, 'earned_points' => 4.00],
            ['student_id' => $student10Id, 'course_code' => 'SOFT252', 'grade' => 'B-', 'semester' => '2022-2023 Spring', 'credits' => 4.00, 'points' => 2.70, 'earned_points' => 10.80],
            ['student_id' => $student10Id, 'course_code' => 'SOFT254', 'grade' => 'C-', 'semester' => '2022-2023 Spring', 'credits' => 3.00, 'points' => 1.70, 'earned_points' => 5.10],
            ['student_id' => $student10Id, 'course_code' => 'FRNC101', 'grade' => 'A', 'semester' => '2023-2024 Fall', 'credits' => 3.00, 'points' => 4.00, 'earned_points' => 12.00],
            ['student_id' => $student10Id, 'course_code' => 'SOCI320', 'grade' => 'A', 'semester' => '2023-2024 Fall', 'credits' => 3.00, 'points' => 4.00, 'earned_points' => 12.00],
            ['student_id' => $student10Id, 'course_code' => 'SOFT321', 'grade' => 'A-', 'semester' => '2023-2024 Fall', 'credits' => 4.00, 'points' => 3.70, 'earned_points' => 14.80],
            ['student_id' => $student10Id, 'course_code' => 'SOFT341', 'grade' => 'A', 'semester' => '2023-2024 Fall', 'credits' => 4.00, 'points' => 4.00, 'earned_points' => 16.00],
            ['student_id' => $student10Id, 'course_code' => 'SOFT431', 'grade' => 'A-', 'semester' => '2023-2024 Fall', 'credits' => 3.00, 'points' => 3.70, 'earned_points' => 11.10],
            ['student_id' => $student10Id, 'course_code' => 'SOFT464', 'grade' => 'B', 'semester' => '2023-2024 Fall', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student10Id, 'course_code' => 'CMPE232', 'grade' => 'A', 'semester' => '2023-2024 Spring', 'credits' => 3.00, 'points' => 4.00, 'earned_points' => 12.00],
            ['student_id' => $student10Id, 'course_code' => 'COMP216', 'grade' => 'A', 'semester' => '2023-2024 Spring', 'credits' => 4.00, 'points' => 4.00, 'earned_points' => 16.00],
            ['student_id' => $student10Id, 'course_code' => 'COMP332', 'grade' => 'A', 'semester' => '2023-2024 Spring', 'credits' => 4.00, 'points' => 4.00, 'earned_points' => 16.00],
            ['student_id' => $student10Id, 'course_code' => 'SOFT404', 'grade' => 'A', 'semester' => '2023-2024 Spring', 'credits' => 2.00, 'points' => 4.00, 'earned_points' => 8.00],
            ['student_id' => $student10Id, 'course_code' => 'COMP352', 'grade' => 'B+', 'semester' => '2024-2025 Fall', 'credits' => 3.00, 'points' => 3.30, 'earned_points' => 9.90],
            ['student_id' => $student10Id, 'course_code' => 'SOFT299', 'grade' => 'S', 'semester' => '2024-2025 Fall', 'credits' => 0.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student10Id, 'course_code' => 'SOFT315', 'grade' => 'B+', 'semester' => '2024-2025 Fall', 'credits' => 4.00, 'points' => 3.30, 'earned_points' => 13.20],
            ['student_id' => $student10Id, 'course_code' => 'SOFT343', 'grade' => 'B-', 'semester' => '2024-2025 Fall', 'credits' => 4.00, 'points' => 2.70, 'earned_points' => 10.80],
            ['student_id' => $student10Id, 'course_code' => 'SOFT472', 'grade' => 'A-', 'semester' => '2024-2025 Fall', 'credits' => 3.00, 'points' => 3.70, 'earned_points' => 11.10],
            ['student_id' => $student10Id, 'course_code' => 'SOFT316', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student10Id, 'course_code' => 'SOFT342', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student10Id, 'course_code' => 'SOFT401', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student10Id, 'course_code' => 'SOFT411', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student10Id, 'course_code' => 'SOFT412', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            
            // Student 11: Precious Wutenyui-Bih Nintai (1903010034)
            ['student_id' => $student11Id, 'course_code' => 'PREP106', 'grade' => 'E', 'semester' => '2019-2020 English Preparatory School Exemption Test', 'credits' => 0.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student11Id, 'course_code' => 'COMP100', 'grade' => 'A', 'semester' => '2019-2020 Fall', 'credits' => 3.00, 'points' => 4.00, 'earned_points' => 12.00],
            ['student_id' => $student11Id, 'course_code' => 'COMP103', 'grade' => 'A', 'semester' => '2019-2020 Fall', 'credits' => 2.00, 'points' => 4.00, 'earned_points' => 8.00],
            ['student_id' => $student11Id, 'course_code' => 'ENGL101', 'grade' => 'A', 'semester' => '2019-2020 Fall', 'credits' => 3.00, 'points' => 4.00, 'earned_points' => 12.00],
            ['student_id' => $student11Id, 'course_code' => 'MATH101', 'grade' => 'C', 'semester' => '2019-2020 Fall', 'credits' => 4.00, 'points' => 2.00, 'earned_points' => 8.00],
            ['student_id' => $student11Id, 'course_code' => 'MATH103', 'grade' => 'B', 'semester' => '2019-2020 Fall', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student11Id, 'course_code' => 'PHYS101', 'grade' => 'D+', 'semester' => '2019-2020 Fall', 'credits' => 4.00, 'points' => 1.30, 'earned_points' => 5.20],
            ['student_id' => $student11Id, 'course_code' => 'COMP104', 'grade' => 'B+', 'semester' => '2019-2020 Spring', 'credits' => 4.00, 'points' => 3.30, 'earned_points' => 13.20],
            ['student_id' => $student11Id, 'course_code' => 'ENGL102', 'grade' => 'B-', 'semester' => '2019-2020 Spring', 'credits' => 3.00, 'points' => 2.70, 'earned_points' => 8.10],
            ['student_id' => $student11Id, 'course_code' => 'MATH102', 'grade' => 'F', 'semester' => '2019-2020 Spring', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student11Id, 'course_code' => 'MATH104', 'grade' => 'B-', 'semester' => '2019-2020 Spring', 'credits' => 3.00, 'points' => 2.70, 'earned_points' => 8.10],
            ['student_id' => $student11Id, 'course_code' => 'PHYS102', 'grade' => 'C', 'semester' => '2019-2020 Spring', 'credits' => 4.00, 'points' => 2.00, 'earned_points' => 8.00],
            ['student_id' => $student11Id, 'course_code' => 'MATH102', 'grade' => 'F', 'semester' => '2019-2020 17-Bütünleme(Bahar)', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student11Id, 'course_code' => 'COMP215', 'grade' => 'C', 'semester' => '2020-2021 Fall', 'credits' => 4.00, 'points' => 2.00, 'earned_points' => 8.00],
            ['student_id' => $student11Id, 'course_code' => 'COMP225', 'grade' => 'C+', 'semester' => '2020-2021 Fall', 'credits' => 4.00, 'points' => 2.30, 'earned_points' => 9.20],
            ['student_id' => $student11Id, 'course_code' => 'ENGL201', 'grade' => 'B-', 'semester' => '2020-2021 Fall', 'credits' => 2.00, 'points' => 2.70, 'earned_points' => 5.40],
            ['student_id' => $student11Id, 'course_code' => 'MATH102', 'grade' => 'D', 'semester' => '2020-2021 Fall', 'credits' => 4.00, 'points' => 1.00, 'earned_points' => 4.00],
            ['student_id' => $student11Id, 'course_code' => 'MATH205', 'grade' => 'C+', 'semester' => '2020-2021 Fall', 'credits' => 4.00, 'points' => 2.30, 'earned_points' => 9.20],
            ['student_id' => $student11Id, 'course_code' => 'TURK100', 'grade' => 'B+', 'semester' => '2020-2021 Fall', 'credits' => 2.00, 'points' => 3.30, 'earned_points' => 6.60],
            ['student_id' => $student11Id, 'course_code' => 'COMP216', 'grade' => 'B', 'semester' => '2020-2021 Spring', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 12.00],
            ['student_id' => $student11Id, 'course_code' => 'COMP232', 'grade' => 'C+', 'semester' => '2020-2021 Spring', 'credits' => 3.00, 'points' => 2.30, 'earned_points' => 6.90],
            ['student_id' => $student11Id, 'course_code' => 'ELEC235', 'grade' => 'D', 'semester' => '2020-2021 Spring', 'credits' => 4.00, 'points' => 1.00, 'earned_points' => 4.00],
            ['student_id' => $student11Id, 'course_code' => 'MATH206', 'grade' => 'C+', 'semester' => '2020-2021 Spring', 'credits' => 3.00, 'points' => 2.30, 'earned_points' => 6.90],
            ['student_id' => $student11Id, 'course_code' => 'MGMT101', 'grade' => 'B+', 'semester' => '2020-2021 Spring', 'credits' => 3.00, 'points' => 3.30, 'earned_points' => 9.90],
            ['student_id' => $student11Id, 'course_code' => 'COMP321', 'grade' => 'B', 'semester' => '2021-2022 Fall', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 12.00],
            ['student_id' => $student11Id, 'course_code' => 'COMP333', 'grade' => 'D+', 'semester' => '2021-2022 Fall', 'credits' => 3.00, 'points' => 1.30, 'earned_points' => 3.90],
            ['student_id' => $student11Id, 'course_code' => 'COMP341', 'grade' => 'D+', 'semester' => '2021-2022 Fall', 'credits' => 4.00, 'points' => 1.30, 'earned_points' => 5.20],
            ['student_id' => $student11Id, 'course_code' => 'COMP351', 'grade' => 'F', 'semester' => '2021-2022 Fall', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student11Id, 'course_code' => 'MATH309', 'grade' => 'C-', 'semester' => '2021-2022 Fall', 'credits' => 3.00, 'points' => 1.70, 'earned_points' => 5.10],
            ['student_id' => $student11Id, 'course_code' => 'COMP324', 'grade' => 'C+', 'semester' => '2021-2022 Spring', 'credits' => 3.00, 'points' => 2.30, 'earned_points' => 6.90],
            ['student_id' => $student11Id, 'course_code' => 'COMP332', 'grade' => 'B-', 'semester' => '2021-2022 Spring', 'credits' => 4.00, 'points' => 2.70, 'earned_points' => 10.80],
            ['student_id' => $student11Id, 'course_code' => 'COMP351', 'grade' => 'C', 'semester' => '2021-2022 Spring', 'credits' => 4.00, 'points' => 2.00, 'earned_points' => 8.00],
            ['student_id' => $student11Id, 'course_code' => 'COMP352', 'grade' => 'D', 'semester' => '2021-2022 Spring', 'credits' => 3.00, 'points' => 1.00, 'earned_points' => 3.00],
            ['student_id' => $student11Id, 'course_code' => 'ELEC240', 'grade' => 'F', 'semester' => '2021-2022 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student11Id, 'course_code' => 'ELEC240', 'grade' => 'F', 'semester' => '2021-2022 17-Bütünleme(Bahar)', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student11Id, 'course_code' => 'COMP401', 'grade' => 'B-', 'semester' => '2022-2023 Fall', 'credits' => 3.00, 'points' => 2.70, 'earned_points' => 8.10],
            ['student_id' => $student11Id, 'course_code' => 'COMP403', 'grade' => 'S', 'semester' => '2022-2023 Fall', 'credits' => 0.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student11Id, 'course_code' => 'COMP404', 'grade' => 'A-', 'semester' => '2022-2023 Fall', 'credits' => 2.00, 'points' => 3.70, 'earned_points' => 7.40],
            ['student_id' => $student11Id, 'course_code' => 'COMP434', 'grade' => 'D+', 'semester' => '2022-2023 Fall', 'credits' => 3.00, 'points' => 1.30, 'earned_points' => 3.90],
            ['student_id' => $student11Id, 'course_code' => 'COMP471', 'grade' => 'D', 'semester' => '2022-2023 Fall', 'credits' => 3.00, 'points' => 1.00, 'earned_points' => 3.00],
            ['student_id' => $student11Id, 'course_code' => 'COMP473', 'grade' => 'D', 'semester' => '2022-2023 Fall', 'credits' => 3.00, 'points' => 1.00, 'earned_points' => 3.00],
            ['student_id' => $student11Id, 'course_code' => 'COMP342', 'grade' => 'NG', 'semester' => '2022-2023 Spring', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student11Id, 'course_code' => 'COMP402', 'grade' => 'D-', 'semester' => '2022-2023 Spring', 'credits' => 4.00, 'points' => 0.70, 'earned_points' => 2.80],
            ['student_id' => $student11Id, 'course_code' => 'COMP454', 'grade' => 'NG', 'semester' => '2022-2023 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student11Id, 'course_code' => 'ELEC240', 'grade' => 'F', 'semester' => '2022-2023 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student11Id, 'course_code' => 'ACCT201', 'grade' => 'NG', 'semester' => '2023-2024 Fall', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student11Id, 'course_code' => 'BUSN104', 'grade' => 'NG', 'semester' => '2023-2024 Fall', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student11Id, 'course_code' => 'COMP402', 'grade' => 'F', 'semester' => '2023-2024 Fall', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student11Id, 'course_code' => 'ELEC240', 'grade' => 'F', 'semester' => '2023-2024 Fall', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student11Id, 'course_code' => 'SOFT431', 'grade' => 'F', 'semester' => '2023-2024 Fall', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student11Id, 'course_code' => 'BUSN101', 'grade' => 'C', 'semester' => '2024-2025 Fall', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 6.00],
            ['student_id' => $student11Id, 'course_code' => 'COMP342', 'grade' => 'B-', 'semester' => '2024-2025 Fall', 'credits' => 4.00, 'points' => 2.70, 'earned_points' => 10.80],
            ['student_id' => $student11Id, 'course_code' => 'COMP402', 'grade' => 'NG', 'semester' => '2024-2025 Fall', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student11Id, 'course_code' => 'COMP454', 'grade' => 'C', 'semester' => '2024-2025 Fall', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 6.00],
            ['student_id' => $student11Id, 'course_code' => 'AINE332', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student11Id, 'course_code' => 'COMP402', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student11Id, 'course_code' => 'ELEC240', 'grade' => 'NG', 'semester' => '2024-2025 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student11Id, 'course_code' => 'HESC109', 'grade' => 'NG', 'semester' => '2024-2025 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student11Id, 'course_code' => 'SFWE422', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            
            // Student 12: Ismael Abba Diakite (2103010205)
            ['student_id' => $student12Id, 'course_code' => 'ENGP070', 'grade' => 'S', 'semester' => '2021-2022 English Preparatory School Exemption Test', 'credits' => 0.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student12Id, 'course_code' => 'ENGL121', 'grade' => 'C', 'semester' => '2021-2022 Spring', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 6.00],
            ['student_id' => $student12Id, 'course_code' => 'ENGR101', 'grade' => 'B+', 'semester' => '2021-2022 Spring', 'credits' => 2.00, 'points' => 3.30, 'earned_points' => 6.60],
            ['student_id' => $student12Id, 'course_code' => 'ENGR103', 'grade' => 'B', 'semester' => '2021-2022 Spring', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student12Id, 'course_code' => 'MATH121', 'grade' => 'B', 'semester' => '2021-2022 Spring', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 12.00],
            ['student_id' => $student12Id, 'course_code' => 'MATH123', 'grade' => 'C', 'semester' => '2021-2022 Spring', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 6.00],
            ['student_id' => $student12Id, 'course_code' => 'PHYS121', 'grade' => 'C', 'semester' => '2021-2022 Spring', 'credits' => 4.00, 'points' => 2.00, 'earned_points' => 8.00],
            ['student_id' => $student12Id, 'course_code' => 'TURK131', 'grade' => 'D-', 'semester' => '2021-2022 Spring', 'credits' => 2.00, 'points' => 0.70, 'earned_points' => 1.40],
            ['student_id' => $student12Id, 'course_code' => 'TURK131', 'grade' => 'C', 'semester' => '2021-2022 17-Bütünleme(Bahar)', 'credits' => 2.00, 'points' => 2.00, 'earned_points' => 4.00],
            ['student_id' => $student12Id, 'course_code' => 'ENGL122', 'grade' => 'C', 'semester' => '2022-2023 Fall', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 6.00],
            ['student_id' => $student12Id, 'course_code' => 'ENGR104', 'grade' => 'D+', 'semester' => '2022-2023 Fall', 'credits' => 3.00, 'points' => 1.30, 'earned_points' => 3.90],
            ['student_id' => $student12Id, 'course_code' => 'HIST111', 'grade' => 'D', 'semester' => '2022-2023 Fall', 'credits' => 2.00, 'points' => 1.00, 'earned_points' => 2.00],
            ['student_id' => $student12Id, 'course_code' => 'MATH122', 'grade' => 'B', 'semester' => '2022-2023 Fall', 'credits' => 4.00, 'points' => 3.00, 'earned_points' => 12.00],
            ['student_id' => $student12Id, 'course_code' => 'MATH124', 'grade' => 'B+', 'semester' => '2022-2023 Fall', 'credits' => 3.00, 'points' => 3.30, 'earned_points' => 9.90],
            ['student_id' => $student12Id, 'course_code' => 'PHYS122', 'grade' => 'B-', 'semester' => '2022-2023 Fall', 'credits' => 4.00, 'points' => 2.70, 'earned_points' => 10.80],
            ['student_id' => $student12Id, 'course_code' => 'TURK132', 'grade' => 'D', 'semester' => '2022-2023 Fall', 'credits' => 2.00, 'points' => 1.00, 'earned_points' => 2.00],
            ['student_id' => $student12Id, 'course_code' => 'BUSN101', 'grade' => 'C', 'semester' => '2022-2023 Spring', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 6.00],
            ['student_id' => $student12Id, 'course_code' => 'CMPE215', 'grade' => 'C', 'semester' => '2022-2023 Spring', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 6.00],
            ['student_id' => $student12Id, 'course_code' => 'CMPE232', 'grade' => 'C+', 'semester' => '2022-2023 Spring', 'credits' => 3.00, 'points' => 2.30, 'earned_points' => 6.90],
            ['student_id' => $student12Id, 'course_code' => 'ENGR215', 'grade' => 'B-', 'semester' => '2022-2023 Spring', 'credits' => 2.00, 'points' => 2.70, 'earned_points' => 5.40],
            ['student_id' => $student12Id, 'course_code' => 'OHSA206', 'grade' => 'F', 'semester' => '2022-2023 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student12Id, 'course_code' => 'STAT226', 'grade' => 'B+', 'semester' => '2022-2023 Spring', 'credits' => 3.00, 'points' => 3.30, 'earned_points' => 9.90],
            ['student_id' => $student12Id, 'course_code' => 'CMPE341', 'grade' => 'B+', 'semester' => '2023-2024 Fall', 'credits' => 4.00, 'points' => 3.30, 'earned_points' => 13.20],
            ['student_id' => $student12Id, 'course_code' => 'ELEE211', 'grade' => 'C+', 'semester' => '2023-2024 Fall', 'credits' => 4.00, 'points' => 2.30, 'earned_points' => 9.20],
            ['student_id' => $student12Id, 'course_code' => 'ELEE231', 'grade' => 'C+', 'semester' => '2023-2024 Fall', 'credits' => 4.00, 'points' => 2.30, 'earned_points' => 9.20],
            ['student_id' => $student12Id, 'course_code' => 'HIST112', 'grade' => 'B-', 'semester' => '2023-2024 Fall', 'credits' => 2.00, 'points' => 2.70, 'earned_points' => 5.40],
            ['student_id' => $student12Id, 'course_code' => 'MATH225', 'grade' => 'C+', 'semester' => '2023-2024 Fall', 'credits' => 4.00, 'points' => 2.30, 'earned_points' => 9.20],
            ['student_id' => $student12Id, 'course_code' => 'SOCI320', 'grade' => 'B', 'semester' => '2023-2024 Fall', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student12Id, 'course_code' => 'CMPE216', 'grade' => 'C', 'semester' => '2023-2024 Spring', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 6.00],
            ['student_id' => $student12Id, 'course_code' => 'CMPE252', 'grade' => 'C', 'semester' => '2023-2024 Spring', 'credits' => 4.00, 'points' => 2.00, 'earned_points' => 8.00],
            ['student_id' => $student12Id, 'course_code' => 'CMPE322', 'grade' => 'C+', 'semester' => '2023-2024 Spring', 'credits' => 4.00, 'points' => 2.30, 'earned_points' => 9.20],
            ['student_id' => $student12Id, 'course_code' => 'CMPE324', 'grade' => 'C', 'semester' => '2023-2024 Spring', 'credits' => 3.00, 'points' => 2.00, 'earned_points' => 6.00],
            ['student_id' => $student12Id, 'course_code' => 'ENGR404', 'grade' => 'B-', 'semester' => '2023-2024 Spring', 'credits' => 2.00, 'points' => 2.70, 'earned_points' => 5.40],
            ['student_id' => $student12Id, 'course_code' => 'MATH228', 'grade' => 'D', 'semester' => '2023-2024 Spring', 'credits' => 3.00, 'points' => 1.00, 'earned_points' => 3.00],
            ['student_id' => $student12Id, 'course_code' => 'CMPE321', 'grade' => 'B-', 'semester' => '2024-2025 Fall', 'credits' => 4.00, 'points' => 2.70, 'earned_points' => 10.80],
            ['student_id' => $student12Id, 'course_code' => 'CMPE421', 'grade' => 'A-', 'semester' => '2024-2025 Fall', 'credits' => 3.00, 'points' => 3.70, 'earned_points' => 11.10],
            ['student_id' => $student12Id, 'course_code' => 'ELEE341', 'grade' => 'F', 'semester' => '2024-2025 Fall', 'credits' => 4.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student12Id, 'course_code' => 'ENGR401', 'grade' => 'A-', 'semester' => '2024-2025 Fall', 'credits' => 2.00, 'points' => 3.70, 'earned_points' => 7.40],
            ['student_id' => $student12Id, 'course_code' => 'SFWE315', 'grade' => 'B', 'semester' => '2024-2025 Fall', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student12Id, 'course_code' => 'SFWE343', 'grade' => 'B+', 'semester' => '2024-2025 Fall', 'credits' => 3.00, 'points' => 3.30, 'earned_points' => 9.90],
            ['student_id' => $student12Id, 'course_code' => 'AINE312', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student12Id, 'course_code' => 'ENGR402', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student12Id, 'course_code' => 'ITAL101', 'grade' => 'B', 'semester' => '2024-2025 Spring', 'credits' => 3.00, 'points' => 3.00, 'earned_points' => 9.00],
            ['student_id' => $student12Id, 'course_code' => 'MATH328', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student12Id, 'course_code' => 'SFWE316', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00],
            ['student_id' => $student12Id, 'course_code' => 'SFWE422', 'grade' => '0', 'semester' => '2024-2025 Spring', 'credits' => 3.00, 'points' => 0.00, 'earned_points' => 0.00]

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