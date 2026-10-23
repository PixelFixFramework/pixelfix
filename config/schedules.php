<?php

return [

    // This optional setting applies only when the application registers a
    // schedule named "reminders". It is disabled unless opted into.
    'reminders' => [

        'enabled' => filter_var(
            env('SCHEDULE_REMINDERS_ENABLED', false),
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
