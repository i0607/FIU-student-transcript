<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            [
                'id' => 1,
                'name' => 'Software Engineering',
                'faculty_id' =>'1',
                'created_at' => '2025-04-28 16:30:39',
                'updated_at' => '2025-05-01 17:10:23'
            ],
            [
                'id' => 2,
                'name' => 'Computer Engineering',
                'faculty_id' =>'1',
                'created_at' => '2025-04-28 16:30:39',
                'updated_at' => '2025-05-01 17:10:23'
            ],
            [
                'id' => 3,
                'name' => 'Business Administration',
                'faculty_id' =>'2',
                'created_at' => '2025-04-28 16:30:39',
                'updated_at' => '2025-05-01 17:10:23'
            ]
        
        ];

        DB::table('departments')->insert($departments);
    }
}