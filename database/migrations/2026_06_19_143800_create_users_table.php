<?php

use PixelFix\Framework\Database\Migrations\Migration;
use PixelFix\Framework\Database\Schema\Blueprint;
use PixelFix\Framework\Database\Schema\Schema;

return new class extends Migration
{
    // =====================================================
    // RUN MIGRATION
    // =====================================================

    public function up(): void
    {
        Schema::create(
            'users',
            function (Blueprint $table) {

                $table->id();

                $table->string(
                    'name'
                );

                $table->string(
                    'email'
                )->unique();

                $table->string(
                    'password'
                );

                $table->rememberToken();

                $table->softDeletes();

            }
        );
    }

    // =====================================================
    // ROLLBACK MIGRATION
    // =====================================================

    public function down(): void
    {
        Schema::dropIfExists(
            'users'
        );
    }
};