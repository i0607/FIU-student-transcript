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
                'id' => 12,
                'student_id' => 1,
                'course_id' => 10,
                'grade' => 'D',
                'semester' => '2019-2020 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 13,
                'student_id' => 1,
                'course_id' => 11,
                'grade' => 'B+',
                'semester' => '2019-2020 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 14,
                'student_id' => 1,
                'course_id' => 12,
                'grade' => 'FF',
                'semester' => '2019-2020 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 15,
                'student_id' => 1,
                'course_id' => 13,
                'grade' => 'B+',
                'semester' => '2019-2020 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 16,
                'student_id' => 1,
                'course_id' => 14,
                'grade' => 'FF',
                'semester' => '2019-2020 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 17,
                'student_id' => 1,
                'course_id' => 15,
                'grade' => 'B',
                'semester' => '2019-2020 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 18,
                'student_id' => 1,
                'course_id' => 16,
                'grade' => 'B',
                'semester' => '2019-2020 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 19,
                'student_id' => 1,
                'course_id' => 17,
                'grade' => 'C',
                'semester' => '2019-2020 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 20,
                'student_id' => 1,
                'course_id' => 18,
                'grade' => 'B+',
                'semester' => '2020-2021 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 21,
                'student_id' => 1,
                'course_id' => 19,
                'grade' => 'D+',
                'semester' => '2020-2021 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 22,
                'student_id' => 1,
                'course_id' => 20,
                'grade' => 'B+',
                'semester' => '2020-2021 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 23,
                'student_id' => 1,
                'course_id' => 21,
                'grade' => 'D+',
                'semester' => '2020-2021 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 24,
                'student_id' => 1,
                'course_id' => 22,
                'grade' => 'A',
                'semester' => '2020-2021 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 25,
                'student_id' => 1,
                'course_id' => 23,
                'grade' => 'D+',
                'semester' => '2020-2021 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 26,
                'student_id' => 1,
                'course_id' => 24,
                'grade' => 'B',
                'semester' => '2020-2021 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 27,
                'student_id' => 1,
                'course_id' => 25,
                'grade' => 'C',
                'semester' => '2020-2021 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 28,
                'student_id' => 1,
                'course_id' => 26,
                'grade' => 'FF',
                'semester' => '2021-2022 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 29,
                'student_id' => 1,
                'course_id' => 27,
                'grade' => 'FF',
                'semester' => '2021-2022 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 30,
                'student_id' => 1,
                'course_id' => 28,
                'grade' => 'A',
                'semester' => '2021-2022 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 31,
                'student_id' => 1,
                'course_id' => 29,
                'grade' => 'C+',
                'semester' => '2021-2022 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 32,
                'student_id' => 1,
                'course_id' => 30,
                'grade' => 'D',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 33,
                'student_id' => 1,
                'course_id' => 31,
                'grade' => 'B+',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 34,
                'student_id' => 1,
                'course_id' => 32,
                'grade' => 'D+',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 35,
                'student_id' => 1,
                'course_id' => 33,
                'grade' => 'D+',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 36,
                'student_id' => 1,
                'course_id' => 34,
                'grade' => 'C',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 37,
                'student_id' => 1,
                'course_id' => 35,
                'grade' => 'C+',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 38,
                'student_id' => 1,
                'course_id' => 36,
                'grade' => 'C',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 39,
                'student_id' => 1,
                'course_id' => 37,
                'grade' => 'D+',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 40,
                'student_id' => 1,
                'course_id' => 38,
                'grade' => 'B+',
                'semester' => '2022-2023 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 41,
                'student_id' => 1,
                'course_id' => 39,
                'grade' => 'D',
                'semester' => '2022-2023 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 44,
                'student_id' => 2,
                'course_id' => 10,
                'grade' => 'B+',
                'semester' => '2019-2020 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 45,
                'student_id' => 2,
                'course_id' => 11,
                'grade' => 'B+',
                'semester' => '2019-2020 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 46,
                'student_id' => 2,
                'course_id' => 12,
                'grade' => 'C+',
                'semester' => '2019-2020 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 47,
                'student_id' => 2,
                'course_id' => 13,
                'grade' => 'D+',
                'semester' => '2019-2020 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 48,
                'student_id' => 2,
                'course_id' => 14,
                'grade' => 'C',
                'semester' => '2019-2020 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 49,
                'student_id' => 2,
                'course_id' => 15,
                'grade' => 'A',
                'semester' => '2019-2020 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 50,
                'student_id' => 2,
                'course_id' => 16,
                'grade' => 'B+',
                'semester' => '2019-2020 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 51,
                'student_id' => 2,
                'course_id' => 17,
                'grade' => 'B',
                'semester' => '2019-2020 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 52,
                'student_id' => 2,
                'course_id' => 18,
                'grade' => 'C',
                'semester' => '2020-2021 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 53,
                'student_id' => 2,
                'course_id' => 19,
                'grade' => 'D',
                'semester' => '2020-2021 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 54,
                'student_id' => 2,
                'course_id' => 20,
                'grade' => 'D',
                'semester' => '2020-2021 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 55,
                'student_id' => 2,
                'course_id' => 21,
                'grade' => 'A',
                'semester' => '2020-2021 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 56,
                'student_id' => 2,
                'course_id' => 22,
                'grade' => 'FF',
                'semester' => '2020-2021 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 57,
                'student_id' => 2,
                'course_id' => 23,
                'grade' => 'C',
                'semester' => '2020-2021 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 58,
                'student_id' => 2,
                'course_id' => 24,
                'grade' => 'D',
                'semester' => '2020-2021 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 59,
                'student_id' => 2,
                'course_id' => 25,
                'grade' => 'C+',
                'semester' => '2020-2021 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 60,
                'student_id' => 2,
                'course_id' => 26,
                'grade' => 'D+',
                'semester' => '2021-2022 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 61,
                'student_id' => 2,
                'course_id' => 27,
                'grade' => 'B',
                'semester' => '2021-2022 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 62,
                'student_id' => 2,
                'course_id' => 28,
                'grade' => 'FF',
                'semester' => '2021-2022 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 63,
                'student_id' => 2,
                'course_id' => 29,
                'grade' => 'C+',
                'semester' => '2021-2022 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 64,
                'student_id' => 2,
                'course_id' => 30,
                'grade' => 'FF',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 65,
                'student_id' => 2,
                'course_id' => 31,
                'grade' => 'C+',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 66,
                'student_id' => 2,
                'course_id' => 32,
                'grade' => 'B',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 67,
                'student_id' => 2,
                'course_id' => 33,
                'grade' => 'D+',
                'semester' => '2021-2022 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 68,
                'student_id' => 2,
                'course_id' => 34,
                'grade' => 'B+',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 69,
                'student_id' => 2,
                'course_id' => 35,
                'grade' => 'C+',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 70,
                'student_id' => 2,
                'course_id' => 36,
                'grade' => 'C+',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 71,
                'student_id' => 2,
                'course_id' => 37,
                'grade' => 'FF',
                'semester' => '2022-2023 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 72,
                'student_id' => 2,
                'course_id' => 38,
                'grade' => 'FF',
                'semester' => '2022-2023 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 73,
                'student_id' => 2,
                'course_id' => 39,
                'grade' => 'D',
                'semester' => '2022-2023 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 74,
                'student_id' => 2,
                'course_id' => 40,
                'grade' => 'D',
                'semester' => '2022-2023 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 75,
                'student_id' => 2,
                'course_id' => 41,
                'grade' => 'FF',
                'semester' => '2022-2023 Spring',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 76,
                'student_id' => 3,
                'course_id' => 10,
                'grade' => 'B+',
                'semester' => '2019-2020 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 77,
                'student_id' => 3,
                'course_id' => 11,
                'grade' => 'B+',
                'semester' => '2019-2020 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 78,
                'student_id' => 3,
                'course_id' => 12,
                'grade' => 'C+',
                'semester' => '2019-2020 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 79,
                'student_id' => 3,
                'course_id' => 13,
                'grade' => 'D',
                'semester' => '2019-2020 Fall',
                'created_at' => '2025-04-29 16:44:00',
                'updated_at' => '2025-04-29 16:44:00'
            ],
            [
                'id' => 80,
                'student_id' => 3,
                'course_id' => 14,
                'grade' => 'D',
                'semester' => '2019-2020 Spring',
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