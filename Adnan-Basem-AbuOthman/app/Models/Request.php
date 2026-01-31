<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = [
        'student_id',
        'apartment_id',
        'message',
        'status',
        'start_date',
        'end_date',


    ];
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];



    // Request.php
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }


}
