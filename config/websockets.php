<?php

return [

    'enabled' => filter_var(
        env('WEBSOCKETS_ENABLED', false),
        FILTER_VALIDATE_BOOL
    ),

    'host' => env(
        'WEBSOCKETS_HOST',
        '127.0.0.1'
    ) ?: '127.0.0.1',

    'port' => (int) (
        env('WEBSOCKETS_PORT', 8080) ?: 8080
    ),

    'allowed_origins' => array_values(
        array_filter(
            array_map(
                'trim',
                explode(',', (string) env('WEBSOCKETS_ALLOWED_ORIGINS', ''))
            )
        )
    ),

    'max_frame_size' => (int) (
        env('WEBSOCKETS_MAX_FRAME_SIZE', 1048576) ?: 1048576
    ),

    'max_handshake_size' => (int) (
        env('WEBSOCKETS_MAX_HANDSHAKE_SIZE', 16384) ?: 16384
    ),

    'relay' => [

        'port' => (int) (
            env('WEBSOCKETS_RELAY_PORT', 8091) ?: 8091
        ),

        'token_path' => BASE_PATH
            . '/storage/framework/pixelfix-websocket-relay.token',

        'max_message_bytes' => (int) (
            env('WEBSOCKETS_RELAY_MAX_BYTES', 1048576) ?: 1048576
        ),

    ],

];
