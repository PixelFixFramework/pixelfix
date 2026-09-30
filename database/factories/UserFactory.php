<?php

namespace Database\Factories;

use App\Models\User;
use PixelFix\Framework\Database\Factories\Factory;

class UserFactory extends Factory
{
    // =====================================================
    // MODEL
    // =====================================================

    protected function model(): string
    {
        return User::class;
    }

    // =====================================================
    // DEFINITION
    // =====================================================

    protected function definition(): array
    {
        return [

            'name' =>
                $this->faker->name(),

            'email' =>
                $this->faker
                    ->unique()
                    ->safeEmail(),

            'password' =>
                password_hash(
                    'password',
                    PASSWORD_DEFAULT
                ),

            'remember_token' =>
                bin2hex(
                    random_bytes(50)
                ),
        ];
    }
}