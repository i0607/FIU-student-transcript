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
                
            ]
            ,
            [
                'id' => 5,
                'student_number' => '1903010042',
                'name' => 'KAKUMBA MULUMBA',
                'department_id' => '2', // Computer Engineering
                'created_at' => '2025-04-19 21:22:29',
                'updated_at' => '2025-04-19 21:22:29',
                'date_of_birth' => '2000-03-10',
                'entry_date' => '2019-10-11',
            ],
            [
                'id' => 6,
                'student_number' => '2003010108',
                'name' => 'MOHAMED KARIOUN',
                'department_id' => '2', // Computer Engineering
                'created_at' => '2025-04-19 21:22:29',
                'updated_at' => '2025-04-19 21:22:29',
                'date_of_birth' => '2003-03-22',
                'entry_date' => '2020-10-20',
            ],
            [
                'id' => 7,
                'student_number' => '2003010134',
                'name' => 'LAMOUBARIKI KARIOUN',
                'department_id' => '2', // Computer Engineering
                'created_at' => '2025-04-19 21:22:29',
                'updated_at' => '2025-04-19 21:22:29',
                'date_of_birth' => '2003-03-22',
                'entry_date' => '2020-10-20',
            ],
            [
                'id' => 8,
                'student_number' => '1903010033',
                'name' => 'JUMANAZAROV ORAZ',
                'department_id' => '2', // Computer Engineering
                'created_at' => '2025-04-19 21:22:29',
                'updated_at' => '2025-04-19 21:22:29',
                'date_of_birth' => '1996-02-16',
                'entry_date' => '2019-09-25',
            ],
            [
                'id' => 9,
                'student_number' => '1903010072',
                'name' => 'MAUWA ORNELLY WA MWAMBA',
                'department_id' => '2', // Computer Engineering
                'created_at' => '2025-04-19 21:22:29',
                'updated_at' => '2025-04-19 21:22:29',
                'date_of_birth' => '2003-11-24',
                'entry_date' => '2020-02-18',
            ] ,
            [
                'id' => 10,
                'student_number' => '2103060171',
                'name' => 'ISAIAH ASAKA PERPETUAL DUMEBI',
                'department_id' => '2', // Computer Engineering
                'created_at' => '2025-04-19 21:22:29',
                'updated_at' => '2025-04-19 21:22:29',
                'date_of_birth' => '2001-08-28',
                'entry_date' => '2022-02-25',
            ] ,
            [
                'id' => 11,
                'student_number' => '1903010034',
                'name' => 'NINTAI PRECIOUS WUTENYUI-BIH',
                'department_id' => '2', // Computer Engineering
                'created_at' => '2025-04-19 21:22:29',
                'updated_at' => '2025-04-19 21:22:29',
                'date_of_birth' => '2000-02-14',
                'entry_date' => '2019-09-27',
            ],
            [
                'id' => 12,
                'student_number' => '2103010205',
                'name' => 'DIAKITE ISMAEL ABBA',
                'department_id' => '2', // Computer Engineering
                'created_at' => '2025-04-19 21:22:29',
                'updated_at' => '2025-04-19 21:22:29',
                'date_of_birth' => '2003-04-04',
                'entry_date' => '2022-02-01',
            ],
            [
                'id' => 13,
                'student_number' => '2103060182',
                'name' => 'BOUKAR MISSIRA ABBA',
                'department_id' => '1', 
                'created_at' => '2025-04-19 21:22:29',
                'updated_at' => '2025-04-19 21:22:29',
                'date_of_birth' => '2002-01-28',
                'entry_date' => '2022-03-07',
            ],
            [
                'id' => 14,
                'student_number' => '2103060190',
                'name' => 'OSERADA ASHER OLAOLUWA AGHOGHO',
                'department_id' => '1', 
                'created_at' => '2025-04-19 21:22:29',
                'updated_at' => '2025-04-19 21:22:29',
                'date_of_birth' => '2003-05-05',
                'entry_date' => '2022-03-23',
            ],
            [
                'id' => 15,
                'student_number' => '2103060194',
                'name' => 'IBRAGIMOV TIMUR',
                'department_id' => '1', 
                'created_at' => '2025-04-19 21:22:29',
                'updated_at' => '2025-04-19 21:22:29',
                'date_of_birth' => '2003-02-12',
                'entry_date' => '2022-03-23',
            ]
        ];

        foreach ($students as $student) {
            DB::table('students')->insert($student);
        }
    }
}