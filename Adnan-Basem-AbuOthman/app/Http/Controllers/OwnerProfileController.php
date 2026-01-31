<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

use Illuminate\Http\Request;

class OwnerProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit()
    {
        $owner = auth()->user(); // Get currently logged in owner
        return view('owner.owner-profile', compact('owner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $owner = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required',
            'string',
            'lowercase',
            'email',
            'max:255',
            'unique:' . User::class,

            'phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8',
        ]);

        // Update Basic Info
        $owner->name = $request->name;
        $owner->email = $request->email;
        $owner->phone = $request->phone;

        // Handle Image Upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($owner->image) {
                Storage::delete('public/' . $owner->profile_image);
            }
            $owner->profile_image = $request->file('image')->store('profile_images', 'public');
        }

        // Handle Password Change
        if ($request->new_password) {
            if (!Hash::check($request->current_password, $owner->password)) {
                return back()->with('error', 'Current password does not match.');
            }
            $owner->password = Hash::make($request->new_password);
        }


        $owner->save();
        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
