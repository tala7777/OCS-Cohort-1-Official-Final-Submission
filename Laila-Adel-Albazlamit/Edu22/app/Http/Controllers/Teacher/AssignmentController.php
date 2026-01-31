<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $assignments = Assignment::where('teacher_id', auth()->id())
            ->with(['schoolClass', 'subject'])
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%");
            })->paginate(10)->withQueryString();

        return view('teacher.assignments.index', compact('assignments'));
    }

    public function create()
    {
        $schoolClasses = SchoolClass::all();
        $subjects = Subject::all(); // In a real app, might filter by teacher's specialty
        return view('teacher.assignments.create', compact('schoolClasses', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        Assignment::create([
            'teacher_id' => auth()->id(),
            'title' => $request->title,
            'subject_id' => $request->subject_id,
            'class_id' => $request->class_id,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('teacher.assignments.index')->with('success', 'Assignment created successfully');
    }

    public function edit(Assignment $assignment)
    {
        if ($assignment->teacher_id !== auth()->id())
            abort(403);
        $schoolClasses = SchoolClass::all();
        $subjects = Subject::all();
        return view('teacher.assignments.edit', compact('assignment', 'schoolClasses', 'subjects'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        if ($assignment->teacher_id !== auth()->id())
            abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        $assignment->update($request->all());

        return redirect()->route('teacher.assignments.index')->with('success', 'Assignment updated successfully');
    }

    public function destroy(Assignment $assignment)
    {
        if ($assignment->teacher_id !== auth()->id())
            abort(403);
        $assignment->delete();
        return redirect()->route('teacher.assignments.index')->with('success', 'Assignment deleted successfully');
    }

    // Student specific view
    public function studentIndex()
    {
        $user = auth()->user();
        $assignments = Assignment::where('class_id', $user->class_id)
            ->with(['teacher', 'subject'])
            ->paginate(10);
        return view('student.assignments.index', compact('assignments'));
    }
}
