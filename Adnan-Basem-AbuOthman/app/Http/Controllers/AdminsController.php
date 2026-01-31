<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;



class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $admins = User::where('role', 'admin')->latest()->get();

        return view('admin.admin-admins', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.admin-add-admin');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([

            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],

            'phone' => ['required', 'min:10'],
            'password' => ['required', Rules\Password::defaults()],


        ]);


        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
            'role' => 'admin',

        ]);


        return redirect()->route('admins.index')->with('success', 'Admin Created Successfully!');



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
    public function destroy(User $admin)
    {


        $admin->delete();



        return redirect()->route('admins.index')->with('success', 'Admin Deleted Successfully!');

    }
}
