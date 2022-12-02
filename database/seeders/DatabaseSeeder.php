<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        // Admin user
        User::create([
            'name'              => 'Abdulaha Islam',
            'username'          => 'abdulaha1715',
            'email'             => 'abdulahaislam210917@gmail.com',
            'phone'             => '01715-246330',
            'password'          => bcrypt('01918786189'),
            'email_verified_at' => now(),
            'thumbnail'         => 'https://picsum.photos/300',
        ]);
    }
}
