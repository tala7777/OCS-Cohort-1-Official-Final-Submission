<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('public.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Force user role
            'status' => 'active',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('index', absolute: false));
    }
    public function storeLawyer(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'license_number' => ['required', 'string', 'max:50'],
            'location' => ['required', 'string', 'max:100'],
            'specialization_id' => ['required', 'exists:categories,id'],
            'cv' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'], // Max 5MB
        ]);

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'lawyer',
            'status' => 'pending',
        ]);

        \App\Models\LawyerProfile::create([
            'user_id' => $user->id,
            'license_number' => $request->license_number,
            'location' => $request->location,
            'status' => 'pending',
            'bio' => 'Draft bio pending update...',
            'cv' => $cvPath,
        ]);

        if ($request->specialization_id) {
            $user->specializations()->attach($request->specialization_id);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('index'))->with('success', 'Registration successful! Your account is pending approval. You can browse the site while you wait.');
    }
}
