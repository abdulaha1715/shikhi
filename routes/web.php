<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\backend\TagController;
use App\Http\Controllers\backend\CourseController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\TeacherProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Dashboard Group Routes
Route::prefix('dashboard')->middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Category
    Route::resource('category', CategoryController::class);

    // Tag
    Route::resource('tag', TagController::class);

    // Course
    Route::resource('course', CourseController::class);

    // View Profile
    Route::get('profile/{id}', [TeacherProfileController::class, 'show'])->name('profile.show');
});

Route::prefix('profile')->middleware('auth')->group(function () {
    Route::get('', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
