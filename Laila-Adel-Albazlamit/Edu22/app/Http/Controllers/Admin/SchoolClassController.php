<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $classes = SchoolClass::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })->paginate(10)->withQueryString();

        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('admin.classes.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:classes,name']);
        SchoolClass::create($request->all());
        return redirect()->route('admin.classes.index')->with('success', 'Class created successfully');
    }

    public function edit(SchoolClass $class)
    {
        return view('admin.classes.edit', compact('class'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $request->validate(['name' => 'required|unique:classes,name,' . $class->id]);
        $class->update($request->all());
        return redirect()->route('admin.classes.index')->with('success', 'Class updated successfully');
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Class deleted successfully');
    }
}
