<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TranscriptSeeder extends Seeder
{
    public function run()
    {
        $transcripts= [
            // Student 1: DON ANTONIO MUSHENGEZI BYEBI (2103010232)
            [
                'student_number' => '2103010232',
                'courses' => [
                    // 2021-2022 Spring
                    ['code' => 'ENGL121', 'grade' => 'A-', 'semester' => '2021-2022 Spring'],
                    ['code' => 'ENGR101', 'grade' => 'A', 'semester' => '2021-2022 Spring'],
                    ['code' => 'ENGR103', 'grade' => 'A-', 'semester' => '2021-2022 Spring'],
                    ['code' => 'MATH121', 'grade' => 'F', 'semester' => '2021-2022 Spring'],
                    ['code' => 'MATH123', 'grade' => 'B', 'semester' => '2021-2022 Spring'],
                    ['code' => 'PHYS121', 'grade' => 'D', 'semester' => '2021-2022 Spring'],
                    ['code' => 'TURK131', 'grade' => 'C+', 'semester' => '2021-2022 Spring'],
                    
                    // 2022-2023 Fall
                    ['code' => 'ENGL122', 'grade' => 'C', 'semester' => '2022-2023 Fall'],
                    ['code' => 'ENGR104', 'grade' => 'D', 'semester' => '2022-2023 Fall'],
                    ['code' => 'HIST111', 'grade' => 'B', 'semester' => '2022-2023 Fall'],
                    ['code' => 'MATH121', 'grade' => 'C-', 'semester' => '2022-2023 Fall'],
                    ['code' => 'MATH124', 'grade' => 'D', 'semester' => '2022-2023 Fall'],
                    ['code' => 'PHYS122', 'grade' => 'F', 'semester' => '2022-2023 Fall'],
                    ['code' => 'TURK132', 'grade' => 'B', 'semester' => '2022-2023 Fall'],
                    
                    // 2022-2023 Spring
                    ['code' => 'CMPE215', 'grade' => 'F', 'semester' => '2022-2023 Spring'],
                    ['code' => 'CMPE232', 'grade' => 'B-', 'semester' => '2022-2023 Spring'],
                    ['code' => 'GRAD282', 'grade' => 'B+', 'semester' => '2022-2023 Spring'],
                    ['code' => 'MATH122', 'grade' => 'NG', 'semester' => '2022-2023 Spring'],
                    ['code' => 'PHYS122', 'grade' => 'F', 'semester' => '2022-2023 Spring'],
                    ['code' => 'STAT226', 'grade' => 'D-', 'semester' => '2022-2023 Spring'],
                    
                    // 2023-2024 Fall
                    ['code' => 'CMPE215', 'grade' => 'D', 'semester' => '2023-2024 Fall'],
                    ['code' => 'ELEE211', 'grade' => 'B-', 'semester' => '2023-2024 Fall'],
                    ['code' => 'HIST112', 'grade' => 'C', 'semester' => '2023-2024 Fall'],
                    ['code' => 'MATH122', 'grade' => 'F', 'semester' => '2023-2024 Fall'],
                    ['code' => 'MATH225', 'grade' => 'F', 'semester' => '2023-2024 Fall'],
                    ['code' => 'PHYS122', 'grade' => 'C', 'semester' => '2023-2024 Fall'],
                    
                    // 2023-2024 Spring
                    ['code' => 'CMPE216', 'grade' => 'C', 'semester' => '2023-2024 Spring'],
                    ['code' => 'COMP432', 'grade' => 'B+', 'semester' => '2023-2024 Spring'],
                    ['code' => 'ENGR215', 'grade' => 'B+', 'semester' => '2023-2024 Spring'],
                    ['code' => 'MATH122', 'grade' => 'C', 'semester' => '2023-2024 Spring'],
                    ['code' => 'OHSA206', 'grade' => 'A', 'semester' => '2023-2024 Spring'],
                    ['code' => 'STAT226', 'grade' => 'C-', 'semester' => '2023-2024 Spring'],
                    
                    // 2024-2025 Fall
                    ['code' => 'AINE301', 'grade' => 'B-', 'semester' => '2024-2025 Fall'],
                    ['code' => 'CMPE321', 'grade' => 'F', 'semester' => '2024-2025 Fall'],
                    ['code' => 'CMPE341', 'grade' => 'B+', 'semester' => '2024-2025 Fall'],
                    ['code' => 'ELEE231', 'grade' => 'D+', 'semester' => '2024-2025 Fall'],
                    ['code' => 'MATH225', 'grade' => 'F', 'semester' => '2024-2025 Fall'],
                    ['code' => 'SFWE343', 'grade' => 'B-', 'semester' => '2024-2025 Fall'],
                ]
            ],
            
            // Student 2: ARUUKE TALANTBEKOVA (2103010238)
            [
                'student_number' => '2103010238',
                'courses' => [
                    // 2021-2022 Spring
                    ['code' => 'ENGR101', 'grade' => 'B-', 'semester' => '2021-2022 Spring'],
                    ['code' => 'ENGR104', 'grade' => 'B+', 'semester' => '2021-2022 Spring'],
                    ['code' => 'HESC109', 'grade' => 'A', 'semester' => '2021-2022 Spring'],
                    ['code' => 'HIST111', 'grade' => 'A', 'semester' => '2021-2022 Spring'],
                    ['code' => 'MATH124', 'grade' => 'A-', 'semester' => '2021-2022 Spring'],
                    ['code' => 'SOCI320', 'grade' => 'A', 'semester' => '2021-2022 Spring'],
                    
                    // 2022-2023 Fall
                    ['code' => 'BUSN101', 'grade' => 'C-', 'semester' => '2022-2023 Fall'],
                    ['code' => 'CMPE215', 'grade' => 'B-', 'semester' => '2022-2023 Fall'],
                    ['code' => 'ELEE211', 'grade' => 'B', 'semester' => '2022-2023 Fall'],
                    ['code' => 'ELEE231', 'grade' => 'D+', 'semester' => '2022-2023 Fall'],
                    ['code' => 'HIST112', 'grade' => 'B', 'semester' => '2022-2023 Fall'],
                    ['code' => 'MATH225', 'grade' => 'C', 'semester' => '2022-2023 Fall'],
                    
                    // 2022-2023 Spring
                    ['code' => 'CMPE232', 'grade' => 'B+', 'semester' => '2022-2023 Spring'],
                    ['code' => 'CMPE252', 'grade' => 'C', 'semester' => '2022-2023 Spring'],
                    ['code' => 'ENGR215', 'grade' => 'C-', 'semester' => '2022-2023 Spring'],
                    ['code' => 'GRAD282', 'grade' => 'B', 'semester' => '2022-2023 Spring'],
                    ['code' => 'OHSA206', 'grade' => 'A-', 'semester' => '2022-2023 Spring'],
                    ['code' => 'STAT226', 'grade' => 'B-', 'semester' => '2022-2023 Spring'],
                    
                    // 2023-2024 Fall
                    ['code' => 'CMPE321', 'grade' => 'A', 'semester' => '2023-2024 Fall'],
                    ['code' => 'CMPE341', 'grade' => 'A', 'semester' => '2023-2024 Fall'],
                    ['code' => 'COMP464', 'grade' => 'B-', 'semester' => '2023-2024 Fall'],
                    ['code' => 'ELEE331', 'grade' => 'B', 'semester' => '2023-2024 Fall'],
                    ['code' => 'ELEE341', 'grade' => 'D', 'semester' => '2023-2024 Fall'],
                    ['code' => 'ENGR401', 'grade' => 'B+', 'semester' => '2023-2024 Fall'],
                    
                    // 2023-2024 Spring
                    ['code' => 'CMPE216', 'grade' => 'A-', 'semester' => '2023-2024 Spring'],
                    ['code' => 'CMPE322', 'grade' => 'C+', 'semester' => '2023-2024 Spring'],
                    ['code' => 'CMPE324', 'grade' => 'C', 'semester' => '2023-2024 Spring'],
                    ['code' => 'MATH228', 'grade' => 'C+', 'semester' => '2023-2024 Spring'],
                    ['code' => 'MATH328', 'grade' => 'D', 'semester' => '2023-2024 Spring'],
                    ['code' => 'SFWE316', 'grade' => 'A', 'semester' => '2023-2024 Spring'],
                    
                    // 2024-2025 Fall
                    ['code' => 'CMPE403', 'grade' => 'S', 'semester' => '2024-2025 Fall'],
                    ['code' => 'CMPE421', 'grade' => 'A', 'semester' => '2024-2025 Fall'],
                    ['code' => 'CMPE463', 'grade' => 'D', 'semester' => '2024-2025 Fall'],
                    ['code' => 'SFWE343', 'grade' => 'B-', 'semester' => '2024-2025 Fall'],
                    ['code' => 'SFWE415', 'grade' => 'F', 'semester' => '2024-2025 Fall'],
                ]
            ],
            
            // Student 3: JERSON KALALA BADIBOLOWA (2003010112)
            [
                'student_number' => '2003010112',
                'courses' => [
                    // 2021-2022 Fall
                    ['code' => 'ENGL121', 'grade' => 'C', 'semester' => '2021-2022 Fall'],
                    ['code' => 'ENGR101', 'grade' => 'C+', 'semester' => '2021-2022 Fall'],
                    ['code' => 'ENGR103', 'grade' => 'C-', 'semester' => '2021-2022 Fall'],
                    ['code' => 'MATH121', 'grade' => 'B+', 'semester' => '2021-2022 Fall'],
                    ['code' => 'MATH123', 'grade' => 'C', 'semester' => '2021-2022 Fall'],
                    ['code' => 'PHYS121', 'grade' => 'C', 'semester' => '2021-2022 Fall'],
                    ['code' => 'TURK131', 'grade' => 'C-', 'semester' => '2021-2022 Fall'],
                    
                    // 2021-2022 Spring
                    ['code' => 'ENGL122', 'grade' => 'D+', 'semester' => '2021-2022 Spring'],
                    ['code' => 'ENGR104', 'grade' => 'B+', 'semester' => '2021-2022 Spring'],
                    ['code' => 'HIST111', 'grade' => 'B', 'semester' => '2021-2022 Spring'],
                    ['code' => 'MATH122', 'grade' => 'B', 'semester' => '2021-2022 Spring'],
                    ['code' => 'MATH124', 'grade' => 'A-', 'semester' => '2021-2022 Spring'],
                    ['code' => 'PHYS122', 'grade' => 'C+', 'semester' => '2021-2022 Spring'],
                    ['code' => 'TURK132', 'grade' => 'D', 'semester' => '2021-2022 Spring'],
                    
                    // 2022-2023 Fall
                    ['code' => 'BUSN101', 'grade' => 'B', 'semester' => '2022-2023 Fall'],
                    ['code' => 'CMPE215', 'grade' => 'B+', 'semester' => '2022-2023 Fall'],
                    ['code' => 'ELEE211', 'grade' => 'B', 'semester' => '2022-2023 Fall'],
                    ['code' => 'ELEE231', 'grade' => 'D', 'semester' => '2022-2023 Fall'],
                    ['code' => 'HIST112', 'grade' => 'B+', 'semester' => '2022-2023 Fall'],
                    ['code' => 'MATH225', 'grade' => 'B-', 'semester' => '2022-2023 Fall'],
                    
                    // 2022-2023 Spring
                    ['code' => 'CMPE216', 'grade' => 'B+', 'semester' => '2022-2023 Spring'],
                    ['code' => 'CMPE232', 'grade' => 'C+', 'semester' => '2022-2023 Spring'],
                    ['code' => 'CMPE252', 'grade' => 'B+', 'semester' => '2022-2023 Spring'],
                    ['code' => 'ENGR215', 'grade' => 'C-', 'semester' => '2022-2023 Spring'],
                    ['code' => 'OHSA206', 'grade' => 'B-', 'semester' => '2022-2023 Spring'],
                    ['code' => 'STAT226', 'grade' => 'B+', 'semester' => '2022-2023 Spring'],
                    
                    // 2023-2024 Fall
                    ['code' => 'ACCT201', 'grade' => 'C+', 'semester' => '2023-2024 Fall'],
                    ['code' => 'CMPE321', 'grade' => 'C+', 'semester' => '2023-2024 Fall'],
                    ['code' => 'CMPE341', 'grade' => 'A-', 'semester' => '2023-2024 Fall'],
                    ['code' => 'ELEE331', 'grade' => 'D', 'semester' => '2023-2024 Fall'],
                    ['code' => 'ELEE341', 'grade' => 'C', 'semester' => '2023-2024 Fall'],
                    ['code' => 'SFWE343', 'grade' => 'B', 'semester' => '2023-2024 Fall'],
                    
                    // 2023-2024 Spring
                    ['code' => 'CMPE322', 'grade' => 'C', 'semester' => '2023-2024 Spring'],
                    ['code' => 'CMPE324', 'grade' => 'B', 'semester' => '2023-2024 Spring'],
                    ['code' => 'ECON101', 'grade' => 'C', 'semester' => '2023-2024 Spring'],
                    ['code' => 'MATH228', 'grade' => 'B-', 'semester' => '2023-2024 Spring'],
                    ['code' => 'MATH328', 'grade' => 'D', 'semester' => '2023-2024 Spring'],
                    ['code' => 'SFWE316', 'grade' => 'B+', 'semester' => '2023-2024 Spring'],
                    
                    // 2024-2025 Fall
                    ['code' => 'BUSN102', 'grade' => 'B', 'semester' => '2024-2025 Fall'],
                    ['code' => 'CMPE403', 'grade' => 'S', 'semester' => '2024-2025 Fall'],
                    ['code' => 'CMPE421', 'grade' => 'C', 'semester' => '2024-2025 Fall'],
                    ['code' => 'CMPE463', 'grade' => 'C+', 'semester' => '2024-2025 Fall'],
                    ['code' => 'CMPE464', 'grade' => 'D', 'semester' => '2024-2025 Fall'],
                    ['code' => 'ENGR401', 'grade' => 'A-', 'semester' => '2024-2025 Fall'],
                ]
            ]
        ];

        // Insert data in batches of 20 records
        $chunks = array_chunk($transcripts, 20);
        foreach ($chunks as $chunk) {
            DB::table('transcripts')->insert($chunk);
        }
    }
}