<?php

namespace Database\Seeders;

use Database\Factories\UserFactory;

use PixelFix\Framework\Database\Seeders\Seeder;

class UserSeeder extends Seeder
{
    // =====================================================
    // TABLE
    // =====================================================

    protected ?string $table = 'users';

    // =====================================================
    // RUN
    // =====================================================

    public function run(): void
    {
        UserFactory::new()
            ->count(10)
            ->create();
    }
}