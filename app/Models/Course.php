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

    // One to One Relationsip
    public function teacher() {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }

    // One to many Relationsip
    public function lessons() {
        return $this->hasMany(Lesson::class, 'course_id', 'id');
    }

    // One to many Relationsip
    public function reviews() {
        return $this->hasMany(Review::class, 'course_id', 'id');
    }
}
