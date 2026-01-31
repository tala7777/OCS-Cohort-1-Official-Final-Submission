<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Attendance;
use Illuminate\Http\Request;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $teacherId = auth()->id();
        $stats = [
            'assignments' => Assignment::where('teacher_id', $teacherId)->count(),
            'attendances' => Attendance::where('teacher_id', $teacherId)->count(),
        ];
        return view('teacher.dashboard', compact('stats'));
    }
}
