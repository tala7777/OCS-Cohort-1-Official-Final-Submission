<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Attendance;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $present = Attendance::where('student_id', $user->id)->where('status', 'present')->count();
        $absent = Attendance::where('student_id', $user->id)->where('status', 'absent')->count();
        $totalDays = $present + $absent;

        $attendancePercentage = $totalDays > 0 ? round(($present / $totalDays) * 100) : 0;

        $pendingHomeworkCount = Assignment::where('class_id', $user->class_id)
            ->where('due_date', '>=', now()->format('Y-m-d'))
            ->count();

        $upcomingAssignments = Assignment::with('subject')
            ->where('class_id', $user->class_id)
            ->where('due_date', '>=', now()->format('Y-m-d'))
            ->orderBy('due_date', 'asc')
            ->take(5)
            ->get();

        return view('student.dashboard', compact('attendancePercentage', 'pendingHomeworkCount', 'upcomingAssignments'));
    }

    public function subjects()
    {
        return view('student.subjects.index');
    }

    public function grades()
    {
        return view('student.grades.index');
    }
}
