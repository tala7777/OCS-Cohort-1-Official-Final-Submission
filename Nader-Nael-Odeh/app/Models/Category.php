<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use SoftDeletes;
        use HasFactory;

    //
    protected $fillable = ['name', 'status'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function lawyers()
    {
        return $this->belongsToMany(User::class, 'category_lawyer', 'category_id', 'lawyer_id')
            ->withTimestamps();
    }
}
