<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use PixelFix\Framework\Auth\Access\PolicyRegistry;
use PixelFix\Framework\Providers\ServiceProvider;

class PolicyServiceProvider extends ServiceProvider
{
    // =====================================================
    // REGISTER
    // =====================================================

    public function register(): void
    {

    }

    // =====================================================
    // BOOT
    // =====================================================

    public function boot(): void
    {
        $policies =
            $this->app()
                ->make(
                    PolicyRegistry::class
                );

        $policies->policy(
            User::class,
            UserPolicy::class
        );

    }
}
