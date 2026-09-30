<?php

namespace App\Policies;

use App\Models\User;
use PixelFix\Framework\Auth\Access\AuthorizationResponse;
use PixelFix\Framework\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    // =====================================================
    // BEFORE
    // =====================================================

    public function before(
        User $user,
        string $ability
    ): AuthorizationResponse|bool|null {

        return null;
    }

    // =====================================================
    // VIEW ANY
    // =====================================================

    public function viewAny(
        User $user
    ): bool {

        return true;
    }

    // =====================================================
    // VIEW
    // =====================================================

    public function view(
        User $user,
        User $userModel
    ): bool {

        return true;
    }

    // =====================================================
    // CREATE
    // =====================================================

    public function create(
        User $user
    ): bool {

        return true;
    }

    // =====================================================
    // UPDATE
    // =====================================================

    public function update(
        User $user,
        User $userModel
    ): bool {

        return true;
    }

    // =====================================================
    // DELETE
    // =====================================================

    public function delete(
        User $user,
        User $userModel
    ): bool {

        return true;
    }

    // =====================================================
    // RESTORE
    // =====================================================

    public function restore(
        User $user,
        User $userModel
    ): bool {

        return true;
    }

    // =====================================================
    // FORCE DELETE
    // =====================================================

    public function forceDelete(
        User $user,
        User $userModel
    ): bool {

        return true;
    }
}