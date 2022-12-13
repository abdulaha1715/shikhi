<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // One to One Relationsip
    public function profile() {
        return $this->hasOne(TeacherProfile::class, 'user_id');
    }

    // Many to Many Relations
    public function courses() {
        return $this->belongsToMany(Course::class, 'courses_users', 'student_id', 'course_id')->withTimestamps();
    }

    // Many to Many Relations
    public function wishlist() {
        return $this->belongsToMany(Course::class, 'courses_users_wishlists', 'student_id', 'course_id')->withTimestamps();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
