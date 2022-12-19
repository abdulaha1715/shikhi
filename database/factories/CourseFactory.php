<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->name();
        $note = fake()->paragraph();
        $level = ['beginner', 'intermediate', 'expert'];
        $status = ['active', 'inactive'];
        return [
            'name'        => $name,
            'slug'        => Str::slug($name),
            'description' => $note,
            'thumbnail'   => 'https://picsum.photos/1000?random='.rand(1, 500),
            'side_note'   => $note ,
            'level'       => $level[rand(0, 2)],
            'status'      => $status[rand(0, 1)],
            'category_id' => Category::all()->random()->id,
            'teacher_id'  => User::all()->random()->id,
        ];
    }
}
