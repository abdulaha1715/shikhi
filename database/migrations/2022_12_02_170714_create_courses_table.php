<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 125);
            $table->string('slug', 125);
            $table->longText('description');
            $table->string('thumbnail', 125);
            $table->longText('side_note');
            $table->enum('level', ['beginner', 'intermediate', 'expert'])->default('beginner');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('category_id');
            $table->foreignId('teacher_id');
            $table->timestamps();
        });

        // courses users
        Schema::create('courses_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id');
            $table->timestamps();
        });

        // courses users wishlists
        Schema::create('courses_users_wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id');
            $table->foreignId('course_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
        Schema::dropIfExists('courses_users');
        Schema::dropIfExists('courses_users_wishlists');
    }
};
