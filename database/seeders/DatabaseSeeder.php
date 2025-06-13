<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password'=> bcrypt('password'), // Use bcrypt for password hashing
        ]);

        $users = User::factory(5)->create();

        foreach ($users as $user) {
            Note::factory(10)->create(['user_id' => $user->id]);        
        }

    }
}
