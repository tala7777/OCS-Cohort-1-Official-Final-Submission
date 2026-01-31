<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'card_token',
        'profile_image',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    // Inside User class
    public function apartments()
    {
        return $this->hasMany(Apartment::class, 'owner_id');
    }

    public function studentRequests()
    {
        return $this->hasMany(Request::class, 'student_id');
    }

    public function ownedApartments()
    {
        return $this->hasMany(Apartment::class, 'owner_id');
    }


    public function subscription()
    {
        // Gets the latest active subscription
        return $this->hasOne(Subscription::class, 'owner_id')->latestOfMany();
    }





    public function canCreateApartment(): bool
    {
        $sub = $this->subscription;

        // 1. Check if they even have a subscription
        if (!$sub || $sub->status !== 'active') {
            return false;
        }

        // 2. Check if the subscription has expired
        if (now()->greaterThan($sub->end_date)) {
            return false;
        }

        // 3. Check apartment limit based on plan
        $maxAllowed = $sub->plan->max_apartments;
        $currentCount = $this->ownedApartments()->count();

        return $currentCount < $maxAllowed;
    }





}
