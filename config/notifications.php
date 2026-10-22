<?php

return [

    // Default delivery channels for application notifications. Notification
    // classes may still override this list when their delivery needs differ.
    'channels' => array_values(
        array_filter(
            array_map(
                static fn (string $channel): string => strtolower(trim($channel)),
                explode(
                    ',',
                    (string) env('NOTIFICATIONS_CHANNELS', 'database')
                )
            ),
            static fn (string $channel): bool => $channel !== ''
        )
    ),

    'database' => [

        'table' => env(
            'NOTIFICATIONS_TABLE',
            'notifications'
        ) ?: 'notifications',

    ],

];
