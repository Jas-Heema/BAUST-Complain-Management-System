<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
<<<<<<< HEAD
        // User::factory(10)->create();
=======
        $admins = [
            ['name' => 'CSE Department Head', 'email' => 'cse@baust.edu.bd', 'role' => 'cse_admin'],
            ['name' => 'Hall Provost', 'email' => 'hall@baust.edu.bd', 'role' => 'hall_admin'],
            ['name' => 'Chief Librarian', 'email' => 'library@baust.edu.bd', 'role' => 'library_admin'],
            ['name' => 'University Proctor', 'email' => 'proctor@baust.edu.bd', 'role' => 'proctor'],
            ['name' => 'System Administrator', 'email' => 'super@baust.edu.bd', 'role' => 'super_admin'],
        ];
>>>>>>> origin/main

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
