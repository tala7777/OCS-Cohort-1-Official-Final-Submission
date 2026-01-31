<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $users = User::where('role', '!=', 'admin')->latest()->get();

        return view('admin.admin-users', compact('users'));
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {


        if ($user->apartments()->count() > 0) {
            // 2. Return back with a warning message
            return back()->with('error', 'Cannot delete: This Owner Have ' . $user->apartments->count() .  ' Apartments Posted!');
        }


        $user->delete();


        return redirect()->route('users.index')->with('success', 'User Deleted successfully!');


    }
}
