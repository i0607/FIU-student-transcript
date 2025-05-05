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
                'id' => 2,
                'name' => 'Computer Engineering',
                'created_at' => '2025-04-28 16:30:39',
                'updated_at' => '2025-05-01 17:10:23'
            ]
        ];

        DB::table('departments')->insert($departments);
    }
}