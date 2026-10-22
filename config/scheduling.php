<?php

return [

    'timezone' => env(
        'SCHEDULER_TIMEZONE',
        env('TIMEZONE', 'UTC')
    ) ?: 'UTC',

];
