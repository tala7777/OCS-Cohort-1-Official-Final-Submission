<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
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
    public function lawyerProfile()
{
    return $this->hasOne(LawyerProfile::class);
}

public function questions()
{
    return $this->hasMany(Question::class, 'user_id');
}

public function replies()
{
    return $this->hasMany(QuestionReply::class, 'lawyer_id');
}

public function articles()
{
    return $this->hasMany(Article::class, 'author_id');
}

public function specializations()
{
    return $this->belongsToMany(Category::class, 'category_lawyer', 'lawyer_id', 'category_id')
        ->withTimestamps();
}
public function likedReplies()
{
    return $this->belongsToMany(QuestionReply::class, 'likes', 'user_id', 'reply_id')
        ->withTimestamps();
}

}
