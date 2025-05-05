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
                'student_number' => 'CE123456',
                'name' => 'Jane Doe',
                'department_id' => '2',
                'created_at' => '2025-04-19 21:22:29',
                'updated_at' => '2025-04-19 21:22:29',
                'date_of_birth' => null,
                'entry_date' => null,
                'graduation_date' => null
            ],
            [
                'id' => 2,
                'student_number' => 'CE654321',
                'name' => 'John Smith',
                'department_id' => '2',
                'created_at' => '2025-04-19 21:22:29',
                'updated_at' => '2025-04-19 21:22:29',
                'date_of_birth' => null,
                'entry_date' => null,
                'graduation_date' => null
            ],
            [
                'id' => 3,
                'student_number' => 'CE123451',
                'name' => 'Student 1',
                'department_id' => '2',
                'created_at' => null,
                'updated_at' => null,
                'date_of_birth' => '2000-01-01',
                'entry_date' => '2019-09-01',
                'graduation_date' => '2023-06-30'
            ],
            [
                'id' => 4,
                'student_number' => 'CE123452',
                'name' => 'Student 2',
                'department_id' => '2',
                'created_at' => null,
                'updated_at' => null,
                'date_of_birth' => '2000-01-01',
                'entry_date' => '2019-09-01',
                'graduation_date' => '2023-06-30'
            ],
            [
                'id' => 5,
                'student_number' => 'CE123453',
                'name' => 'Student 3',
                'department_id' => '2',
                'created_at' => null,
                'updated_at' => null,
                'date_of_birth' => '2000-01-01',
                'entry_date' => '2019-09-01',
                'graduation_date' => '2023-06-30'
            ],
            [
                'id' => 6,
                'student_number' => 'CE123454',
                'name' => 'Student 4',
                'department_id' => '2',
                'created_at' => null,
                'updated_at' => null,
                'date_of_birth' => '2000-01-01',
                'entry_date' => '2019-09-01',
                'graduation_date' => '2023-06-30'
            ],
            [
                'id' => 7,
                'student_number' => 'CE123455',
                'name' => 'Student 5',
                'department_id' => '2',
                'created_at' => null,
                'updated_at' => null,
                'date_of_birth' => '2000-01-01',
                'entry_date' => '2019-09-01',
                'graduation_date' => '2023-06-30'
            ],
            [
                'id' => 8,
                'student_number' => 'CE241963',
                'name' => 'Nada',
                'department_id' => '2',
                'created_at' => null,
                'updated_at' => null,
                'date_of_birth' => '2003-07-10',
                'entry_date' => '2024-09-27',
                'graduation_date' => '2026-01-09'
            ]
        ];

        foreach ($students as $student) {
            DB::table('students')->insert($student);
        }
    }
}