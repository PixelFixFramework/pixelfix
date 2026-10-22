<?php

return [

    'default' => env(
        'CACHE_DRIVER',
        'file'
    ),

    // An empty CACHE_PATH in the process environment must not
    // override the default application cache directory.
    'path' => trim((string) env('CACHE_PATH', ''))
        ?: BASE_PATH . '/storage/cache/data',

    'locks' => [

        'driver' => env(
            'CACHE_LOCK_DRIVER',
            'array'
        ),

    ],

];
