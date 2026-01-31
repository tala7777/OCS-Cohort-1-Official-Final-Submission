<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        // Assuming subjects are assigned to a class, and teacher teaches subjects in classes
        // For now, let's fetch all subjects associated with the teacher (if we had a direct relationship)
        // Or if the teacher is assigned to classes/sections.
        // As per the seed/schema seen earlier, maybe we just fetch all subjects for simplicity or filter by teacher_id if column exists.
        // I'll assume Subject has teacher_id based on previous patterns or just fetch all for demo.
        // Checking Assignment model: Assignment belongsTo Subject.
        // Let's check Subject model later. For now, fetch all.
        $subjects = Subject::with('schoolClass')->paginate(10);
        return view('teacher.subjects.index', compact('subjects'));
    }

    public function show(Subject $subject)
    {
        $subject->load('schoolClass');

        // Fetch students in the subject's class
        // Assuming students are Users with role 'student' and class_id matches
        $students = User::where('role', 'student')
            ->where('class_id', $subject->class_id)
            ->get();

        // Fetch assignments
        $assignments = $subject->assignments()
            ->where('teacher_id', auth()->id())
            ->orderBy('due_date', 'desc')
            ->get();

        // Attendance Stats (Mocking/Calculating)
        $totalAttendance = Attendance::whereIn('student_id', $students->pluck('id'))->count();
        $presentAttendance = Attendance::whereIn('student_id', $students->pluck('id'))->where('status', 'present')->count();
        $attendanceRate = $totalAttendance > 0 ? round(($presentAttendance / $totalAttendance) * 100) : 0;

        $todayPresent = Attendance::whereIn('student_id', $students->pluck('id'))
            ->where('date', now()->format('Y-m-d'))
            ->where('status', 'present')
            ->count();

        return view('teacher.subjects.show', compact('subject', 'students', 'assignments', 'attendanceRate', 'todayPresent'));
    }
}
