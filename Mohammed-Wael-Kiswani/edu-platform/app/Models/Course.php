<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // الأعمدة اللي ممكن نعملها Mass Assignment
    protected $fillable = [
    'name',
    'description',
    'category',
    'instructor',
    'price',
    'image',
];


public function lessons()
{
    return $this->hasMany(Lesson::class);
}


}
