<?php

use App\Models\User;

return [

    'defaults' => [

        'guard' => 'web',
    ],

    'guards' => [

        'web' => [

            'driver' => 'session',

            'provider' => 'users',
        ],
    ],

    'providers' => [

        'users' => [

            'driver' => 'database',

            'model' => User::class,

            'password_field' => 'password',
        ],
    ],

    'passwords' => [

        'default' => 'users',

        'users' => [

            'provider' => 'users',

            'table' => 'password_reset_tokens',

            'expire' => (int) env('PASSWORD_RESET_EXPIRE', 60),

            'throttle' => (int) env('PASSWORD_RESET_THROTTLE', 60),

            'email' => 'email',
        ],
    ],

    'password_timeout' => 10800,

    'redirects' => [

        'login' => '/login',

        'home' => '/',
    ],

    'remember' => [

        'cookie' => env(
            'AUTH_REMEMBER_COOKIE',
            'pixelfix_remember'
        ),

        'duration' => env(
            'AUTH_REMEMBER_DURATION',
            60 * 60 * 24 * 30
        ),
    ],

];
