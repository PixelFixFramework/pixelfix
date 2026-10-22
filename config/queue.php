<?php

return [

    'default' => env(
        'QUEUE_CONNECTION',
        'sync'
    ) ?: 'sync',

    'after_commit' => filter_var(
        env('QUEUE_AFTER_COMMIT', false),
        FILTER_VALIDATE_BOOL
    ),

    'database' => [

        'table' => env(
            'QUEUE_DATABASE_TABLE',
            'jobs'
        ) ?: 'jobs',

        'failed_table' => env(
            'QUEUE_FAILED_TABLE',
            'failed_jobs'
        ) ?: 'failed_jobs',

        'dead_letter_table' => env(
            'QUEUE_DEAD_LETTER_TABLE',
            'dead_letter_jobs'
        ) ?: 'dead_letter_jobs',

        'retry_after' => (int) env(
            'QUEUE_RETRY_AFTER',
            90
        ),

    ],

    'redis' => [

        'connection' => env(
            'QUEUE_REDIS_CONNECTION',
            env('REDIS_CONNECTION', 'default')
        ) ?: 'default',

        'prefix' => env(
            'QUEUE_REDIS_PREFIX',
            'queues:'
        ) ?: 'queues:',

        'retry_after' => (int) env(
            'QUEUE_RETRY_AFTER',
            90
        ),

    ],

];
