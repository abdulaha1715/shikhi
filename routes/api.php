<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Auth api
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Courses and Single course
Route::get('/courses', [CourseController::class, 'index']);
Route::get('/course/{slug}', [CourseController::class, 'singleCourse']);

// Course lesson
Route::get('/course/{slug}/lesson/{lesson}', [CourseController::class, 'CourseLesson']);

// Auth Group
Route::middleware('auth:sanctum')->group(function () {
    // Enroll
    Route::post('/enroll', [CourseController::class, 'CourseEnroll']);
    // Wishlist
    Route::post('/wishlist', [CourseController::class, 'Coursewishlist']);
    // Review
    Route::post('/review', [CourseController::class, 'CourseReview']);
    // User Profile edit
    Route::post('/profile/update-profile', [UserController::class, 'updateUser']);
    // My Profile
    Route::get('/me', [UserController::class, 'myProfile']);
    // Course Mark as Complete
    Route::post('/markcourseascomplete', [CourseController::class, 'markCourseAsComplete']);
    // Lesson Mark as Complete
    Route::post('/marklessonascomplete', [CourseController::class, 'markLessonAsComplete']);
});
