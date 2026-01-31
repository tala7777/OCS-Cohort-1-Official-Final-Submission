<?php

namespace App\Livewire\Lawyer;

use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LawyerProfile;
use App\Models\Article;
use App\Models\Question;

class EditProfile extends Component
{
    use WithFileUploads;

    public $full_name;
    public $specializations = [];
    public $bio;
    public $phone;
    public $whatsapp_number;
    public $linkedin_profile;
    public $email;
    public $location;
    
    public $profile_picture;
    public $existing_profile_picture;
    public $remove_profile_picture = false;

    public $categories;

    public function mount()
    {
        $user = Auth::user();
        $lawyerProfile = $user->lawyerProfile;

        $this->full_name = $user->name;
        $this->email = $user->email;
        $this->bio = $lawyerProfile->bio ?? '';
        $this->phone = $lawyerProfile->phone ?? '';
        $this->whatsapp_number = $lawyerProfile->whatsapp_number ?? '';
        $this->linkedin_profile = $lawyerProfile->linkedin_profile ?? '';
        $this->location = $lawyerProfile->location ?? '';
        
        // Handle specializations (Load all ID's)
        $this->specializations = $user->specializations->pluck('id')->toArray();
        
        $this->existing_profile_picture = $lawyerProfile->profile_photo_path;
        
        $this->categories = Category::all();
    }

    public function saveProfile()
    {
        $user = Auth::user();
        
        $this->validate([
            'full_name' => 'required|string|max:255',
            'specializations' => 'required|array|min:1',
            'specializations.*' => 'exists:categories,id',
            'bio' => 'required|string|max:500',
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:100',
            'whatsapp_number' => 'nullable|string|max:20',
            'linkedin_profile' => 'nullable|url|max:255',
            'profile_picture' => 'nullable|image|max:5120', // 5MB
        ]);

        // Update User
        $user->update([
            'name' => $this->full_name,
        ]);

        // Update Specialization (Sync)
        $user->specializations()->sync($this->specializations);

        // Handle Profile Picture
        $profilePath = $this->existing_profile_picture;
        
        if ($this->remove_profile_picture) {
            $profilePath = null;
        } elseif ($this->profile_picture) {
            $profilePath = $this->profile_picture->store('profile-photos', 'public');
        }

        // Update Lawyer Profile
        $user->lawyerProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'bio' => $this->bio,
                'phone' => $this->phone,
                'location' => $this->location,
                'whatsapp_number' => $this->whatsapp_number,
                'linkedin_profile' => $this->linkedin_profile,
                'profile_photo_path' => $profilePath,
            ]
        );

        session()->flash('success', 'Profile updated successfully!');
        
        // Refresh specific fields
        $this->existing_profile_picture = $profilePath;
        $this->profile_picture = null;
        $this->remove_profile_picture = false;
        
        $this->dispatch('profile-updated');
    }

    public function removePhoto()
    {
        $this->remove_profile_picture = true;
        $this->existing_profile_picture = null;
        $this->profile_picture = null;
    }

    public function render()
    {

        return view('livewire.lawyer.edit-profile');
    }

}
