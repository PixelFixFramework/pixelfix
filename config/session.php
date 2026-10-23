<?php

return [

    'driver' => env(
        'SESSION_DRIVER',
        'file'
    ),

    'lifetime' => (int) env(
        'SESSION_LIFETIME',
        120
    ),

    // When true, the browser receives a session cookie that expires on close.
    'expire_on_close' => filter_var(
        env(
            'SESSION_EXPIRE_ON_CLOSE',
            false
        ),
        FILTER_VALIDATE_BOOL
    ),

    'path' => env(
        'SESSION_COOKIE_PATH',
        '/'
    ),

    'domain' => env(
        'SESSION_COOKIE_DOMAIN',
        null
    ),

    'secure' => filter_var(
        env(
            'SESSION_COOKIE_SECURE',
            false
        ),
        FILTER_VALIDATE_BOOL
    ),

    'http_only' => filter_var(
        env(
            'SESSION_COOKIE_HTTP_ONLY',
            true
        ),
        FILTER_VALIDATE_BOOL
    ),

    'same_site' => env(
        'SESSION_COOKIE_SAME_SITE',
        'Lax'
    ),

    'files' => BASE_PATH
        . '/storage/sessions',

    'cookie' => env(
        'SESSION_COOKIE',
        'pixelfix_session'
    ),

];
