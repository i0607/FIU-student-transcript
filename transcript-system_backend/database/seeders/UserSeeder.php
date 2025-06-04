<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;  // Add this import for Hash

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'email' => 'admin@fiu.edu',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'name' => 'System',
                'surname' => 'Administrator',
                'department' => 'IT Administration',
                'staffNumber' => 'ADMIN001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'staff@fiu.edu',
                'password' => Hash::make('staff123'),
                'role' => 'staff',
                'name' => 'John',
                'surname' => 'Staff',
                'department' => 'Academic Affairs',
                'staffNumber' => 'STAFF001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'registrar@fiu.edu',
                'password' => Hash::make('registrar123'),
                'role' => 'staff',
                'name' => 'Maria',
                'surname' => 'Rodriguez',
                'department' => 'Student Records',
                'staffNumber' => 'REG001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'dean@fiu.edu',
                'password' => Hash::make('dean123'),
                'role' => 'staff',
                'name' => 'Dr. Ahmed',
                'surname' => 'Hassan',
                'department' => 'Engineering Faculty',
                'staffNumber' => 'DEAN001',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}