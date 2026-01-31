<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use App\Models\Request as Req; // Alias your Model


use App\Models\User;

class StudentProfileController extends Controller
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
        $user = auth()->user();

        $my_requests = Req::whereHas('apartment', function ($query) {

            $query->where('student_id', auth()->id()); // Corrected ID call

        })->get();


        return view('profile', compact('user', 'my_requests'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Force find the user from the DB to ensure we have the right instance
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update fields
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->hasFile('image')) {
            if ($user->profile_image != 'profile_images/simple.jpg') {
                \Storage::disk('public')->delete($user->profile_image);
            }
            $path = $request->file('image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        if ($request->filled('new_password')) {
            if (!\Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Current password does not match.');
            }
            $user->password = \Hash::make($request->new_password);
        }
        $user->save(); // This MUST return true if successful

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Req $profile)
    {


        $profile->delete();

        return redirect()->route('profile.edit', Auth::id())->with('req', 'Request deleted');

    }
}
