<?php

namespace App\Models;

use PixelFix\Framework\Auth\Authenticatable;
use PixelFix\Framework\Auth\Contracts\Authenticatable as AuthenticatableContract;
use PixelFix\Framework\Database\Models\Model;
use PixelFix\Framework\Database\Traits\SoftDeletes;

class User extends Model implements AuthenticatableContract
{
    use SoftDeletes;
    use Authenticatable;

    // =====================================================
    // TABLE
    // =====================================================

    protected static string $table = 'users';

    // =====================================================
    // FILLABLE
    // =====================================================

    protected static array $fillable = [

        'name',

        'email',

        'password',

        'remember_token',
    ];

    // =====================================================
    // HIDDEN
    // =====================================================

    protected static array $hidden = [

        'password',

        'remember_token',
    ];

    // =====================================================
    // CASTS
    // =====================================================

    protected static array $casts = [

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',
    ];

}