<?php

return [

    'reminders' => [

        'enabled' => filter_var(
            env('SCHEDULE_REMINDERS_ENABLED', true),
            FILTER_VALIDATE_BOOL
        ),

        // Supported modes: daily or hourly within the configured hour range.
        'frequency' => strtolower(
            trim(
                (string) env('SCHEDULE_REMINDERS_FREQUENCY', 'daily')
            )
        ),

        'start_hour' => (int) env(
            'SCHEDULE_REMINDERS_START_HOUR',
            8
        ),

        'end_hour' => (int) env(
            'SCHEDULE_REMINDERS_END_HOUR',
            23
        ),

    ],

];
