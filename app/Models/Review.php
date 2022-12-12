<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // One to One Relationsip
    public function course() {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    // One to One Relationsip
    public function student() {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }
}
