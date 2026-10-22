<?php

return [

    'default' => env(
        'BROADCAST_DRIVER',
        'redis'
    ) ?: 'redis',

    'redis' => [

        'prefix' => env(
            'BROADCAST_REDIS_PREFIX',
            'broadcast:'
        ) ?: 'broadcast:',

    ],

];
