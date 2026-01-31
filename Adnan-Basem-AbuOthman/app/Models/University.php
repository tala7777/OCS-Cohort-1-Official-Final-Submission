<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{


    protected $fillable = ['name', 'location', 'image'];




    public function apartments()
    {
        return $this->hasMany(Apartment::class);
    }


}
