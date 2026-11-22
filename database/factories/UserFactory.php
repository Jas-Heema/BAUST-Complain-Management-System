<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/** @extends Factory<\App\Models\User> */
class UserFactory extends Factory
{
    protected static ?string $password = null;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'student_id' => fake()->unique()->numerify('##########'),
            'email' => fake()->unique()->safeEmail(),
            'department' => 'Computer Science and Engineering',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'student',
            'is_active' => true,
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => ['email_verified_at' => null]);
    }

    public function administrator(string $role = 'cse_admin'): static
    {
        return $this->state(fn (array $attributes) => [
            'student_id' => null,
            'role' => $role,
        ]);
    }
}
