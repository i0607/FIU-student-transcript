<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            // Replace UserSeeder with your existing seeders
           UserSeeder::class,           // 1. Users first
            CoursesSeeder::class,        // 3. Courses BEFORE transcripts
           FacultiesSeeder::class,
          DepartmentSeeder::class,     // 2. Departments 
          StudentSeeder::class,        // 4. Students
           CurriculumSeeder::class,
TranscriptSeeder::class,     // 5. Transcripts LAST
        ]);
    }
}