<?php

return [

    'default' => env(
        'REDIS_CONNECTION',
        'default'
    ) ?: 'default',

    'pubsub' => [

        'connection' => env(
            'REDIS_PUBSUB_CONNECTION',
            env('REDIS_CONNECTION', 'default')
        ) ?: 'default',

    ],

    'connections' => [

        'default' => [

            'host' => env(
                'REDIS_HOST',
                '127.0.0.1'
            ) ?: '127.0.0.1',

            'port' => (int) (
                env('REDIS_PORT', 6379) ?: 6379
            ),

            'username' => env(
                'REDIS_USERNAME',
                null
            ),

            'password' => env(
                'REDIS_PASSWORD',
                null
            ),

            'database' => (int) (
                env('REDIS_DB', 0) ?: 0
            ),

            'timeout' => (float) (
                env('REDIS_TIMEOUT', 2.5) ?: 2.5
            ),

            'persistent' => filter_var(
                env('REDIS_PERSISTENT', false),
                FILTER_VALIDATE_BOOL
            ),

            'persistent_id' => env(
                'REDIS_PERSISTENT_ID',
                'pixelfix'
            ) ?: 'pixelfix',

            'read_timeout' => env(
                'REDIS_READ_TIMEOUT',
                null
            ),

        ],

    ],

];
