<?php

return [
    // Name of the default disk. Available disks are declared under "disks".
    'default' => env('FILESYSTEM_DISK', 'local'),

    'disks' => [
        // General application storage. Do not expose private files through a web URL.
        'local' => [
            'driver' => 'local',
            'root' => BASE_PATH . '/storage/app',
            'url' => null,
        ],

        // Public files intended to be served under /storage.
        // Create the configured symbolic link with `php pixel storage:link`.
        'public' => [
            'driver' => 'local',
            'root' => BASE_PATH . '/storage/app/public',
            'url' => '/storage',
        ],
    ],

    // Link path => target directory. The command creates target directories
    // and links when they do not exist; it will not replace an existing path.
    'links' => [
        BASE_PATH . '/public/storage' => BASE_PATH . '/storage/app/public',
    ],
];
