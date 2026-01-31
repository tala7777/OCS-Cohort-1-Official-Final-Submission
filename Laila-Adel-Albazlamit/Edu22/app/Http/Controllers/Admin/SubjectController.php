<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $subjects = Subject::with('schoolClass')->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('schoolClass', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        })->paginate(10)->withQueryString();

        return view('admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        return view('admin.subjects.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'class_id' => 'required|exists:classes,id'
        ]);
        Subject::create($request->all());
        return redirect()->route('admin.subjects.index')->with('success', 'Subject created successfully');
    }

    public function edit(Subject $subject)
    {
        $classes = SchoolClass::all();
        return view('admin.subjects.edit', compact('subject', 'classes'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required',
            'class_id' => 'required|exists:classes,id'
        ]);
        $subject->update($request->all());
        return redirect()->route('admin.subjects.index')->with('success', 'Subject updated successfully');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('admin.subjects.index')->with('success', 'Subject deleted successfully');
    }
}
