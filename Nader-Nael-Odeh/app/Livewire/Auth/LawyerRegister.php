<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Validate; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Models\Category;
use App\Models\LawyerProfile;

class LawyerRegister extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $license_number = '';
    public $location = '';
    public $specialization_id = '';

    public function register()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
            'license_number' => ['required', 'string', 'max:50'],
            'location' => ['required', 'string', 'max:100'],
            'specialization_id' => ['required', 'exists:categories,id'],
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'lawyer',
            'status' => 'pending',
        ]);

        LawyerProfile::create([
            'user_id' => $user->id,
            'license_number' => $this->license_number,
            'location' => $this->location,
            'status' => 'pending',
            'bio' => 'Draft bio pending update...', // Default
        ]);

        if ($this->specialization_id) {
            $user->specializations()->attach($this->specialization_id);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('index')->with('success', 'Registration successful! Your account is pending approval. You can browse the site while you wait.');
    }

    public function render()
    {
        return view('livewire.auth.lawyer-register', [
            'categories' => Category::all()
        ]);
    }
}
