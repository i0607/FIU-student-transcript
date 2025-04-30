<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
{
    User::create([
        'email' => 'admin@fiu.edu',
        'password' => Hash::make('admin123'),
        'role' => 'admin'
    ]);

    User::create([
        'email' => 'staff@fiu.edu',
        'password' => Hash::make('staff123'),
        'role' => 'staff'
    ]);
}
}
