<?php

// Queue names used by `php pixelfix dev` when it starts a persistent worker.
// WORKER_QUEUES accepts a comma-separated list for the local development worker.
$workerQueues = trim((string) env('WORKER_QUEUES', 'default')) ?: 'default';

return [

    'default' => env(
        'QUEUE_CONNECTION',
        'sync'
    ) ?: 'sync',

    // Queues started by the local development supervisor; the CLI --queues
    // option overrides this list.
    'worker_queues' => array_values(
        array_filter(
            array_map('trim', explode(',', $workerQueues)),
            static fn (string $queue): bool => $queue !== ''
        )
    ),

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
