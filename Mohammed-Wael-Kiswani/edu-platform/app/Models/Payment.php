<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'amount',
        'status',
    ];

    // علاقة المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة الكورس
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
