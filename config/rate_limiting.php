<?php

return [

    'prefix' => env(
        'RATE_LIMIT_PREFIX',
        'rate_limit:'
    ),

    'login' => [

        'max_attempts' => (int) env(
            'AUTH_LOGIN_MAX_ATTEMPTS',
            5
        ),

        'decay_seconds' => (int) env(
            'AUTH_LOGIN_DECAY_SECONDS',
            60
        ),

    ],

];
