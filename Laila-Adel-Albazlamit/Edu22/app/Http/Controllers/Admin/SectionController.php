<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $sections = Section::with('schoolClass')->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('schoolClass', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        })->paginate(10)->withQueryString();

        return view('admin.sections.index', compact('sections'));
    }

    public function create()
    {
        $schoolClasses = SchoolClass::orderBy('name')->get();
        return view('admin.sections.create', compact('schoolClasses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'class_id' => 'required|exists:classes,id'
        ]);
        Section::create($request->all());
        return redirect()->route('admin.sections.index')->with('success', 'Section created successfully');
    }

    public function edit(Section $section)
    {
        $schoolClasses = SchoolClass::orderBy('name')->get();
        return view('admin.sections.edit', compact('section', 'schoolClasses'));
    }

    public function update(Request $request, Section $section)
    {
        $request->validate([
            'name' => 'required',
            'class_id' => 'required|exists:classes,id'
        ]);
        $section->update($request->all());
        return redirect()->route('admin.sections.index')->with('success', 'Section updated successfully');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('admin.sections.index')->with('success', 'Section deleted successfully');
    }
}
