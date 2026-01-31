<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // مثال على بيانات كورسات تجريبية
        $courses = [
            [
                'name' => 'Full Stack Web Development',
                'category' => 'Web Development',
                'instructor' => 'Sarah Johnson',
                'price' => 149.99,
            ],
            [
                'name' => 'Python for Data Science',
                'category' => 'Data Science',
                'instructor' => 'Michael Chen',
                'price' => 199.99,
            ],
            [
                'name' => 'iOS App Development with Swift',
                'category' => 'Mobile Development',
                'instructor' => 'Alex Rodriguez',
                'price' => 179.99,
            ],
            [
                'name' => 'Machine Learning Fundamentals',
                'category' => 'AI & ML',
                'instructor' => 'Dr. Emily Watson',
                'price' => 249.99,
            ],
            [
                'name' => 'DevOps & Cloud Computing',
                'category' => 'DevOps',
                'instructor' => 'Robert Kim',
                'price' => 229.99,
            ],
        ];

        // إدخال البيانات في جدول courses
        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
