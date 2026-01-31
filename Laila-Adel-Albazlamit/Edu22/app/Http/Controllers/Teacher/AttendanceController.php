<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $schoolClasses = SchoolClass::all();
        $sections = Section::all();

        $attendances = Attendance::where('teacher_id', auth()->id())
            ->with(['student', 'student.schoolClass', 'student.section'])
            ->orderBy('date', 'desc')
            ->paginate(10);
        $attendances->withQueryString();

        return view('teacher.attendance.index', compact('schoolClasses', 'sections', 'attendances'));
    }

    public function create(Request $request)
    {
        $schoolClasses = SchoolClass::all();
        $class_id = $request->get('class_id');
        $section_id = $request->get('section_id');
        $date = $request->get('date', now()->format('Y-m-d'));

        $students = [];
        if ($class_id && $section_id) {
            $students = User::where('role', 'student')
                ->where('class_id', $class_id)
                ->where('section_id', $section_id)
                ->get();

            // Check if attendance already exists for this date
            foreach ($students as $student) {
                $student->attendance_status = Attendance::where('student_id', $student->id)
                    ->where('date', $date)
                    ->first()?->status;
            }
        }

        $sections = Section::when($class_id, function ($q) use ($class_id) {
            return $q->where('class_id', $class_id);
        })->get();

        return view('teacher.attendance.create', compact('schoolClasses', 'sections', 'students', 'class_id', 'section_id', 'date'));
    }

    public function mark(Request $request)
    {
        $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent',
        ]);

        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                ['student_id' => $studentId, 'date' => $request->date],
                ['teacher_id' => auth()->id(), 'status' => $status]
            );
        }

        return redirect()->route('teacher.attendance.index')->with('success', 'Attendance marked successfully');
    }

    public function studentIndex()
    {
        $attendances = Attendance::where('student_id', auth()->id())
            ->with(['teacher', 'student.schoolClass', 'student.section'])
            ->orderBy('date', 'desc')
            ->paginate(10);
        return view('student.attendance.index', compact('attendances'));
    }

    public function submitReason(Request $request, Attendance $attendance)
    {
        $request->validate([
            'absence_reason' => 'required|string|max:1000',
        ]);

        if ($attendance->student_id !== auth()->id() || $attendance->status !== 'absent') {
            abort(403);
        }

        if ($attendance->absence_reason) {
            return back()->with('error', 'Reason already submitted.');
        }

        $attendance->update([
            'absence_reason' => $request->absence_reason,
            'reason_status' => 'pending',
        ]);

        return back()->with('success', 'Absence reason submitted successfully.');
    }

    public function approveReason(Attendance $attendance)
    {
        if (auth()->user()->role !== 'teacher' || $attendance->teacher_id !== auth()->id()) {
            abort(403);
        }

        $attendance->update([
            'reason_status' => 'approved',
        ]);

        return back()->with('success', 'Absence reason approved.');
    }
}
