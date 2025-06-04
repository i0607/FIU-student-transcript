<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $students = [
            [
                'id' => 1,
                'student_number' => '200306129',
                'name' => 'AYUB AHMED',
                'department_id' => '1', // Software Engineering
                'created_at' => '2025-04-19 21:22:29',
                'updated_at' => '2025-04-19 21:22:29',
                'date_of_birth' => '2002-10-16',
                'entry_date' => '2021-03-11',
                'graduation_date' => '2025-03-11'
            ],

            // Real Computer Engineering students from transcripts
            [
                'id' => 2,
                'student_number' => '2103010232',
                'name' => 'DON ANTONIO MUSHENGEZI BYEBI',
                'department_id' => '2', // Computer Engineering
                'created_at' => '2025-04-19 21:22:29',
                'updated_at' => '2025-04-19 21:22:29',
                'date_of_birth' => '2000-12-26',
                'entry_date' => '2022-03-02',
                'graduation_date' => '2025-04-02'
            ],
            [
                'id' => 3,
                'student_number' => '2103010238',
                'name' => 'ARUUKE TALANTBEKOVA',
                'department_id' => '2', // Computer Engineering
                'created_at' => '2025-04-19 21:22:29',
                'updated_at' => '2025-04-19 21:22:29',
                'date_of_birth' => '2002-10-25',
                'entry_date' => '2022-03-08',
                'graduation_date' => '2025-04-02'
            ],
            [
                'id' => 4,
                'student_number' => '2003010112',
                'name' => 'JERSON KALALA BADIBOLOWA',
                'department_id' => '2', // Computer Engineering
                'created_at' => '2025-04-19 21:22:29',
                'updated_at' => '2025-04-19 21:22:29',
                'date_of_birth' => '1999-06-07',
                'entry_date' => '2020-10-28',
                'graduation_date' => '2025-04-02'
            ]
        ];

        foreach ($students as $student) {
            DB::table('students')->insert($student);
        }
    }
}