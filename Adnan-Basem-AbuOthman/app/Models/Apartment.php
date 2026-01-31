<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\University;

class Apartment extends Model
{
    protected $fillable = [
        'owner_id',
        'name',
        'location',
        'latitude',
        'longitude',
        'area',
        'university_id',
        'allowed_gender',
        'description',
        'rent_type',
        'price',
        'status',          // Add this
        'number_of_rooms',


    ];



    // Inside Apartment class
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function university()
    {
        // This tells Laravel: "Look at my university_id and find the matching University"
        return $this->belongsTo(University::class);
    }


    public function images()
    {
        return $this->hasMany(ApartmentImage::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'apartment_features');
    }


    public function requests()
    {
        return $this->hasMany(Request::class);
    }


    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }


}
