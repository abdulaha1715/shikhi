<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // One to One Relationsip
    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    // One to many Relationsip
    public function tags() {
        return $this->hasMany(Tag::class, 'tag_id', 'id');
    }

    // One to One Relationsip
    public function teacher() {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }

    // One to many Relationsip
    public function lessons() {
        return $this->hasMany(Lesson::class, 'course_id', 'id');
    }

    // Many to Many Relations
    public function students() {
        return $this->belongsToMany(User::class, 'courses_users', 'course_id', 'student_id')->withPivot('status')->withTimestamps();
    }

    // Many to Many Relations
    public function wishlist() {
        return $this->belongsToMany(User::class, 'courses_users_wishlists', 'course_id', 'student_id');
    }

    // One to many Relationsip
    public function reviews() {
        return $this->hasMany(Review::class, 'course_id', 'id');
    }
}
