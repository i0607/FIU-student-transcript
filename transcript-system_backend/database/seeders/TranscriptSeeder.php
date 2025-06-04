<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TranscriptSeeder extends Seeder
{
    public function run()
    {
        $transcripts = [
           [
                'id' => 100,
                'student_id' => 2,
                'course_id' => 100, // ENGL121
                'grade' => 'A-',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 101,
                'student_id' => 2,
                'course_id' => 102, // ENGR101
                'grade' => 'A',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 102,
                'student_id' => 2,
                'course_id' => 103, // ENGR103
                'grade' => 'A-',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 103,
                'student_id' => 2,
                'course_id' => 105, // MATH121
                'grade' => 'F',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 104,
                'student_id' => 2,
                'course_id' => 107, // MATH123
                'grade' => 'B',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 105,
                'student_id' => 2,
                'course_id' => 112, // PHYS121
                'grade' => 'D',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 106,
                'student_id' => 2,
                'course_id' => 600, // TURK131
                'grade' => 'C+',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],

            // 2022-2023 Fall
            [
                'id' => 107,
                'student_id' => 2,
                'course_id' => 101, // ENGL122
                'grade' => 'C',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 108,
                'student_id' => 2,
                'course_id' => 104, // ENGR104
                'grade' => 'D',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 109,
                'student_id' => 2,
                'course_id' => 602, // HIST111
                'grade' => 'B',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 110,
                'student_id' => 2,
                'course_id' => 105, // MATH121 (retake)
                'grade' => 'C-',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 111,
                'student_id' => 2,
                'course_id' => 108, // MATH124
                'grade' => 'D',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 112,
                'student_id' => 2,
                'course_id' => 113, // PHYS122
                'grade' => 'F',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 113,
                'student_id' => 2,
                'course_id' => 601, // TURK132
                'grade' => 'B',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],

            // 2022-2023 Spring
            [
                'id' => 114,
                'student_id' => 2,
                'course_id' => 200, // CMPE215
                'grade' => 'F',
                'semester' => '2022-2023 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 115,
                'student_id' => 2,
                'course_id' => 202, // CMPE232
                'grade' => 'B-',
                'semester' => '2022-2023 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 116,
                'student_id' => 2,
                'course_id' => 700, // GRAD282
                'grade' => 'B+',
                'semester' => '2022-2023 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 117,
                'student_id' => 2,
                'course_id' => 106, // MATH122
                'grade' => 'NG',
                'semester' => '2022-2023 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 118,
                'student_id' => 2,
                'course_id' => 113, // PHYS122 (retake)
                'grade' => 'F',
                'semester' => '2022-2023 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 119,
                'student_id' => 2,
                'course_id' => 604, // STAT226
                'grade' => 'D-',
                'semester' => '2022-2023 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],

            // ARUUKE TALANTBEKOVA (student_id = 3, student_number = 2103010238)
            
            // 2021-2022 Spring
            [
                'id' => 200,
                'student_id' => 3,
                'course_id' => 102, // ENGR101
                'grade' => 'B-',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 201,
                'student_id' => 3,
                'course_id' => 104, // ENGR104
                'grade' => 'B+',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 202,
                'student_id' => 3,
                'course_id' => 705, // HESC109
                'grade' => 'A',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 203,
                'student_id' => 3,
                'course_id' => 602, // HIST111
                'grade' => 'A',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 204,
                'student_id' => 3,
                'course_id' => 108, // MATH124
                'grade' => 'A-',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 205,
                'student_id' => 3,
                'course_id' => 706, // SOCI320
                'grade' => 'A',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],

            // 2022-2023 Fall
            [
                'id' => 206,
                'student_id' => 3,
                'course_id' => 800, // BUSN101
                'grade' => 'C-',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 207,
                'student_id' => 3,
                'course_id' => 200, // CMPE215
                'grade' => 'B-',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 208,
                'student_id' => 3,
                'course_id' => 300, // ELEE211
                'grade' => 'B',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 209,
                'student_id' => 3,
                'course_id' => 301, // ELEE231
                'grade' => 'D+',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 210,
                'student_id' => 3,
                'course_id' => 603, // HIST112
                'grade' => 'B',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 211,
                'student_id' => 3,
                'course_id' => 109, // MATH225
                'grade' => 'C',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],

            // JERSON KALALA BADIBOLOWA (student_id = 4, student_number = 2003010112)
            
            // 2021-2022 Fall
            [
                'id' => 300,
                'student_id' => 4,
                'course_id' => 100, // ENGL121
                'grade' => 'C',
                'semester' => '2021-2022 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 301,
                'student_id' => 4,
                'course_id' => 102, // ENGR101
                'grade' => 'C+',
                'semester' => '2021-2022 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 302,
                'student_id' => 4,
                'course_id' => 103, // ENGR103
                'grade' => 'C-',
                'semester' => '2021-2022 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 303,
                'student_id' => 4,
                'course_id' => 105, // MATH121
                'grade' => 'B+',
                'semester' => '2021-2022 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 304,
                'student_id' => 4,
                'course_id' => 107, // MATH123
                'grade' => 'C',
                'semester' => '2021-2022 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 305,
                'student_id' => 4,
                'course_id' => 112, // PHYS121
                'grade' => 'C',
                'semester' => '2021-2022 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 306,
                'student_id' => 4,
                'course_id' => 600, // TURK131
                'grade' => 'C-',
                'semester' => '2021-2022 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],

            // 2021-2022 Spring
            [
                'id' => 307,
                'student_id' => 4,
                'course_id' => 101, // ENGL122
                'grade' => 'D+',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 308,
                'student_id' => 4,
                'course_id' => 104, // ENGR104
                'grade' => 'B+',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 309,
                'student_id' => 4,
                'course_id' => 602, // HIST111
                'grade' => 'B',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 310,
                'student_id' => 4,
                'course_id' => 106, // MATH122
                'grade' => 'B',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 311,
                'student_id' => 4,
                'course_id' => 108, // MATH124
                'grade' => 'A-',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 312,
                'student_id' => 4,
                'course_id' => 113, // PHYS122
                'grade' => 'C+',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 313,
                'student_id' => 4,
                'course_id' => 601, // TURK132
                'grade' => 'D',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],

            // More recent semesters for all students...
            // 2022-2023 Fall for JERSON
            [
                'id' => 314,
                'student_id' => 4,
                'course_id' => 800, // BUSN101
                'grade' => 'B',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 315,
                'student_id' => 4,
                'course_id' => 200, // CMPE215
                'grade' => 'B+',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 316,
                'student_id' => 4,
                'course_id' => 300, // ELEE211
                'grade' => 'B',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 317,
                'student_id' => 4,
                'course_id' => 301, // ELEE231
                'grade' => 'D',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 318,
                'student_id' => 4,
                'course_id' => 603, // HIST112
                'grade' => 'B+',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 319,
                'student_id' => 4,
                'course_id' => 109, // MATH225
                'grade' => 'B-',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],

            // Add some recent semester data for other students
            // 2023-2024 Fall for ARUUKE
            [
                'id' => 400,
                'student_id' => 3,
                'course_id' => 204, // CMPE321
                'grade' => 'A',
                'semester' => '2023-2024 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 401,
                'student_id' => 3,
                'course_id' => 207, // CMPE341
                'grade' => 'A',
                'semester' => '2023-2024 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 402,
                'student_id' => 3,
                'course_id' => 213, // COMP464
                'grade' => 'B-',
                'semester' => '2023-2024 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 403,
                'student_id' => 3,
                'course_id' => 302, // ELEE331
                'grade' => 'B',
                'semester' => '2023-2024 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 404,
                'student_id' => 3,
                'course_id' => 303, // ELEE341
                'grade' => 'D',
                'semester' => '2023-2024 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 405,
                'student_id' => 3,
                'course_id' => 501, // ENGR401
                'grade' => 'B+',
                'semester' => '2023-2024 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],

            // 2024-2025 Fall for DON ANTONIO
            [
                'id' => 500,
                'student_id' => 2,
                'course_id' => 702, // AINE301
                'grade' => 'B-',
                'semester' => '2024-2025 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 501,
                'student_id' => 2,
                'course_id' => 204, // CMPE321
                'grade' => 'F',
                'semester' => '2024-2025 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 502,
                'student_id' => 2,
                'course_id' => 207, // CMPE341
                'grade' => 'B+',
                'semester' => '2024-2025 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 503,
                'student_id' => 2,
                'course_id' => 301, // ELEE231
                'grade' => 'D+',
                'semester' => '2024-2025 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 504,
                'student_id' => 2,
                'course_id' => 109, // MATH225
                'grade' => 'F',
                'semester' => '2024-2025 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 505,
                'student_id' => 2,
                'course_id' => 401, // SFWE343
                'grade' => 'B-',
                'semester' => '2024-2025 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],

            // Original Software Engineering student transcripts (AYUB AHMED)
            [
                'id' => 1,
                'student_id' => 1,
                'course_id' => 6, // ENGL101 (from old seeder)
                'grade' => 'C',
                'semester' => '2020-2021 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 2,
                'student_id' => 1,
                'course_id' => 1, // MATH101 (from old seeder)
                'grade' => 'B',
                'semester' => '2020-2021 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],

            // Test data for other students
            [
                'id' => 600,
                'student_id' => 5,
                'course_id' => 1, // Software Engineering courses
                'grade' => 'A',
                'semester' => '2020-2021 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 601,
                'student_id' => 6,
                'course_id' => 100, // Computer Engineering courses
                'grade' => 'B+',
                'semester' => '2019-2020 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 602,
                'student_id' => 7,
                'course_id' => 1000, // Business courses
                'grade' => 'A-',
                'semester' => '2020-2021 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ]
        ];

        // Insert data in batches of 20 records
        $chunks = array_chunk($transcripts, 20);
        foreach ($chunks as $chunk) {
            DB::table('transcripts')->insert($chunk);
        }
    }
}