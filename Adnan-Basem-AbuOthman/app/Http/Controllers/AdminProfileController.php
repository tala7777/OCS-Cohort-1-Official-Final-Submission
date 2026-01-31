<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $admin = Auth::user();

        //or
        //$admin = User::findOrFail(Auth::id());


        return view('admin.admin-profile', compact('admin'));

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
    public function edit(User $admin_profile)
    {



        return view('admin.admin-edit-profile', compact('admin_profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $admin_profile)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Ignore the current user's ID during the unique check
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $admin_profile->id],
            'phone' => ['required', 'min:10'],
            // Remove 'required' so they can leave it blank
            'password' => ['nullable', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        // 1. Update basic info
        $admin_profile->name = $request->name;
        $admin_profile->email = $request->email;
        $admin_profile->phone = $request->phone;

        // 2. Only update password if a new one was provided
        if ($request->filled('password')) {
            $admin_profile->password = Hash::make($request->password);
        }

        $admin_profile->save();

        return redirect()->route('admin_profile.index')->with('success', 'Profile Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
