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
        Schema::create('teacher_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('username', 125)->unique()->nullable();
            $table->string('phone', 125)->unique()->nullable();
            $table->string('thumbnail', 125)->nullable();
            $table->string('country', 125)->nullable();
            $table->string('location', 125)->nullable();
            $table->longText('about')->nullable();
            $table->string('designation', 125)->nullable();
            $table->string('website', 125)->nullable();
            $table->string('s_youtube', 125)->nullable();
            $table->string('s_github', 125)->nullable();
            $table->string('s_dribbble', 125)->nullable();
            $table->string('s_instagram', 125)->nullable();
            $table->foreignId('user_id', 125)->constrained('users')->cascadeOnDelete();
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
        Schema::dropIfExists('teacher_profiles');
    }
};
