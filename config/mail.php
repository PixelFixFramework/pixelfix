<?php

return [

    'default' => env(
        'MAIL_MAILER',
        'smtp'
    ),

    'host' => env(
        'MAIL_HOST',
        ''
    ),

    'port' => (int) env(
        'MAIL_PORT',
        587
    ),

    'username' => env(
        'MAIL_USERNAME',
        ''
    ),

    'password' => env(
        'MAIL_PASSWORD',
        ''
    ),

    'encryption' => env(
        'MAIL_ENCRYPTION',
        'tls'
    ),

    'timeout' => (int) env(
        'MAIL_TIMEOUT',
        10
    ),

    'from' => [

        'address' => env(
            'MAIL_FROM_ADDRESS',
            ''
        ),

        'name' => env(
            'MAIL_FROM_NAME',
            env('APP_NAME', 'PIXELFIX')
        ),
    ],

];
