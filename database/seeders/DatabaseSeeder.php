<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tag;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Admin user
        User::create([
            'name'              => 'Abdulaha Islam',
            'email'             => 'abdulahaislam210917@gmail.com',
            'thumbnail'             => 'https://picsum.photos/300?random='.rand(1, 500),
            'password'          => bcrypt('01918786189'),
            'email_verified_at' => now(),
        ]);

        // User
        User::factory(10)->create();

        // Category
        Category::factory(10)->create();

        // Tag
        Tag::factory(10)->create();

        // Courses
        Course::factory(100)->create();

        // Lesson
        Lesson::factory(900)->create();
    }
}
