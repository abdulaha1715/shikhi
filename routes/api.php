<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/courses', [CourseController::class, 'index']);
Route::get('/course/{slug}', [CourseController::class, 'singleCourse']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/course/{slug}/enroll', [CourseController::class, 'CourseEnroll']);
    Route::post('/course/{slug}/wishlist', [CourseController::class, 'Coursewishlist']);
    Route::post('/course/{slug}/review', [CourseController::class, 'CourseReview']);
    Route::get('/course/{slug}/lesson/{lesson}', [CourseController::class, 'CourseLesson']);
});
