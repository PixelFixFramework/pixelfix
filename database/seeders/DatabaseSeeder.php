<?php

namespace Database\Seeders;

use PixelFix\Framework\Database\Seeders\Seeder;

class DatabaseSeeder extends Seeder
{
    protected bool $trackExecution = false;

    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);
    }
}