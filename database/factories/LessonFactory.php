<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name   = fake()->name();
        $note   = fake()->paragraph();
        $status = ['public', 'private'];

        return [
            'name'      => $name,
            'slug'      => Str::slug($name),
            'content'   => $note,
            'status'    => $status[rand(0, 1)],
            'course_id' => Course::all()->random()->id,
        ];
    }
}
