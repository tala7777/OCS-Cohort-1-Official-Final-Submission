<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $schoolClasses = SchoolClass::all();
        $sections = Section::all();
        $subjects = Subject::all();

        // Mock data for the view since Grade model doesn't exist
        $grades = [
            [
                'student_name' => 'John Doe',
                'hw1' => 9,
                'hw2' => 10,
                'assign_total' => 19,
                'mid_term' => 85,
                'quiz1' => 18,
                'final_grade' => 122
            ],
            [
                'student_name' => 'Jane Smith',
                'hw1' => 10,
                'hw2' => 10,
                'assign_total' => 20,
                'mid_term' => 92,
                'quiz1' => 19,
                'final_grade' => 131
            ],
            [
                'student_name' => 'Alice Johnson',
                'hw1' => 8,
                'hw2' => 9,
                'assign_total' => 17,
                'mid_term' => 78,
                'quiz1' => 15,
                'final_grade' => 110
            ],
        ];

        return view('teacher.grades.index', compact('schoolClasses', 'sections', 'subjects', 'grades'));
    }

    public function create()
    {
        $schoolClasses = SchoolClass::all();
        $sections = Section::all();
        $subjects = Subject::all();

        // Mock students for the UI demo
        // In a real app, this would be empty until class/section is selected via AJAX or page reload
        // But for the "Add Exam" page UI demo, we show some rows.
        $students = \App\Models\User::where('role', 'student')->take(5)->get();

        return view('teacher.grades.create', compact('schoolClasses', 'sections', 'subjects', 'students'));
    }

    public function store(Request $request)
    {
        // Mock storage
        return redirect()->route('teacher.grades.index')->with('success', 'Exam created and grades saved successfully!');
    }
}
