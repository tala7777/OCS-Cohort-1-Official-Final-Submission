<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\University;
use Illuminate\Http\Request;

class UniversitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $universities = University::all();
        

        return view('admin.admin-universities', compact('universities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.admin-add-university');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([

            'name' => 'required|string|max:150',
            'location' => 'required|string|max:150',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',


        ]);

        // 2. Handle the file upload
        if ($request->hasFile('image')) {
            // This stores the file in 'storage/app/public/apartments' 
            // and returns the path: "apartments/filename.jpg"
            $path = $request->file('image')->store('universities', 'public');
        }


        University::create([
            'name' => $request->name,
            'location' => $request->location,
            'image' => $path,

        ]);



        return redirect()->route('universities.index')->with('success', 'University Created successfully!');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(University $university)
    {
        return view('admin.admin-edit-university', compact('university'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, University $university)
    {

        // 1. Validate - Image is 'nullable' so they can keep the old one
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Start with the existing image path
        $path = $university->image;

        // 3. If a NEW image is uploaded, handle it
        if ($request->hasFile('image')) {
            // Optional: Delete old file from physical storage to save space
            if ($university->image && Storage::disk('public')->exists($university->image)) {
                Storage::disk('public')->delete($university->image);

            }

            // Store new image
            $path = $request->file('image')->store('universities', 'public');
        }

        // 4. Update the record
        $university->update([
            'name' => $request->name,
            'location' => $request->location,
            'image' => $path, // This will be the NEW path or the OLD path
        ]);

        return redirect()->route('universities.index')->with('success', 'University Updated successfully!');


    }

    // The variable name must be $university to match the resource parameter
    public function destroy(University $university)
    {

        // 1. Check if there are any apartments linked
        if ($university->apartments()->count() > 0) {
            // 2. Return back with a warning message
            return back()->with('error', 'Cannot delete: This university is linked to ' . $university->apartments()->count() . ' apartments.');
        }


        // Optional: Delete the image file from storage before deleting the record
        if ($university->image && Storage::disk('public')->exists($university->image)) {
            Storage::disk('public')->delete($university->image);
        }

        $university->delete();

        return redirect()->route('universities.index')->with('success', 'Deleted successfully!');
    }
}
