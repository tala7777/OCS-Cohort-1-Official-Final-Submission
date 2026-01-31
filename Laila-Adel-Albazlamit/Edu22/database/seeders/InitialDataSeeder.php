<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Admin
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@edu.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Create Classes
        $grade1 = \App\Models\SchoolClass::create(['name' => 'Grade 1']);
        $grade2 = \App\Models\SchoolClass::create(['name' => 'Grade 2']);

        // 3. Create Sections
        $sections = [];
        foreach ([$grade1, $grade2] as $class) {
            $sections[$class->id][] = \App\Models\Section::create(['name' => 'A', 'class_id' => $class->id]);
            $sections[$class->id][] = \App\Models\Section::create(['name' => 'B', 'class_id' => $class->id]);
        }

        // 4. Create Subjects
        foreach ([$grade1, $grade2] as $class) {
            \App\Models\Subject::create(['name' => 'Math', 'class_id' => $class->id]);
            \App\Models\Subject::create(['name' => 'Physics', 'class_id' => $class->id]);
        }

        // 5. Create Teacher
        \App\Models\User::create([
            'name' => 'Teacher One',
            'email' => 'teacher@edu.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'teacher',
        ]);

        // 6. Create Student
        \App\Models\User::create([
            'name' => 'Student One',
            'email' => 'student@edu.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'student',
            'class_id' => $grade1->id,
            'section_id' => $sections[$grade1->id][0]->id, // Section A of Grade 1
        ]);
    }
}
