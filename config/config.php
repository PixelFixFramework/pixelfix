<?php

use App\Models\User;

return [

    // =====================================================
    // APPLICATION
    // =====================================================

    'app' => [

        'name' => env(
            'APP_NAME',
            'PixelFix'
        ),

        'env' => env(
            'APP_ENV',
            'production'
        ),

        'debug' => env(
            'APP_DEBUG',
            false
        ),

        'url' => env(
            'APP_URL',
            'http://localhost'
        ),

        'base_path' => env(
            'APP_BASE_PATH',
            '/'
        ),

        'timezone' => env(
            'TIMEZONE',
            'UTC'
        ),

    ],

    // =====================================================
    // AUTHENTICATION
    // =====================================================

    'auth' => [

        'defaults' => [

            'guard' => 'web',
        ],

        'guards' => [

            'web' => [

                'driver' => 'session',

                'provider' => 'users',
            ],
        ],

        'providers' => [

            'users' => [

                'driver' => 'database',

                'model' => User::class,

                'password_field' => 'password',
            ],
        ],

        'passwords' => [

            'default' => 'users',

            'users' => [

                'provider' => 'users',

                'table' => 'password_reset_tokens',

                'expire' => (int) env('PASSWORD_RESET_EXPIRE', 60),

                'throttle' => (int) env('PASSWORD_RESET_THROTTLE', 60),

                'email' => 'email',
            ],
        ],

        'password_timeout' => 10800,

        'redirects' => [

            'login' => '/login',

            'home' => '/',
        ],

        'remember' => [

            'cookie' => env(
                'AUTH_REMEMBER_COOKIE',
                'pixelfix_remember'
            ),

            'duration' => env(
                'AUTH_REMEMBER_DURATION',
                60 * 60 * 24 * 30
            ),
        ],

    ],

    // =====================================================
    // CACHE
    // =====================================================

    'cache' => [

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

    ],

    // =====================================================
    // RATE LIMITING
    // =====================================================

    'rate_limiting' => [

        'prefix' => env(
            'RATE_LIMIT_PREFIX',
            'rate_limit:'
        ),

        'login' => [

            'max_attempts' => (int) env(
                'AUTH_LOGIN_MAX_ATTEMPTS',
                5
            ),

            'decay_seconds' => (int) env(
                'AUTH_LOGIN_DECAY_SECONDS',
                60
            ),

        ],

    ],

    // =====================================================
    // DATABASE
    // =====================================================

    'database' => [

        'default' => env(
            'DB_CONNECTION',
            'mysql'
        ),

        'seeder' =>
            Database\Seeders\DatabaseSeeder::class,

        'connections' => [

            // =================================================
            // MYSQL
            // =================================================

            'mysql' => [

                'driver' => 'mysql',

                'host' => env(
                    'MYSQL_HOST',
                    '127.0.0.1'
                ),

                'port' => env(
                    'MYSQL_PORT',
                    3306
                ),

                'database' => env(
                    'MYSQL_DATABASE',
                    ''
                ),

                'user' => env(
                    'MYSQL_USER',
                    ''
                ),

                'password' => env(
                    'MYSQL_PASSWORD',
                    ''
                ),
            ],

            // =================================================
            // MARIADB
            // =================================================

            'mariadb' => [

                'driver' => 'mariadb',

                'host' => env(
                    'MARIADB_HOST',
                    '127.0.0.1'
                ),

                'port' => env(
                    'MARIADB_PORT',
                    3306
                ),

                'database' => env(
                    'MARIADB_DATABASE',
                    ''
                ),

                'user' => env(
                    'MARIADB_USER',
                    ''
                ),

                'password' => env(
                    'MARIADB_PASSWORD',
                    ''
                ),
            ],

            // =================================================
            // POSTGRESQL
            // =================================================

            'pgsql' => [

                'driver' => 'pgsql',

                'host' => env(
                    'PGSQL_HOST',
                    '127.0.0.1'
                ),

                'port' => env(
                    'PGSQL_PORT',
                    5432
                ),

                'database' => env(
                    'PGSQL_DATABASE',
                    ''
                ),

                'user' => env(
                    'PGSQL_USER',
                    'postgres'
                ),

                'password' => env(
                    'PGSQL_PASSWORD',
                    ''
                ),
            ],

            // =================================================
            // SQLITE
            // =================================================

            'sqlite' => [

                'driver' => 'sqlite',

                'database' => env(
                    'SQLITE_DATABASE',
                    ':memory:'
                ),
            ],

            // =================================================
            // SQL SERVER
            // =================================================

            'sqlsrv' => [

                'driver' => 'sqlsrv',

                'host' => env(
                    'SQLSRV_HOST',
                    '127.0.0.1'
                ),

                'port' => env(
                    'SQLSRV_PORT',
                    1433
                ),

                'database' => env(
                    'SQLSRV_DATABASE',
                    ''
                ),

                'user' => env(
                    'SQLSRV_USER',
                    ''
                ),

                'password' => env(
                    'SQLSRV_PASSWORD',
                    ''
                ),
            ],

            // =================================================
            // DBLIB
            // =================================================

            'dblib' => [

                'driver' => 'dblib',

                'host' => env(
                    'DBLIB_HOST',
                    '127.0.0.1'
                ),

                'port' => env(
                    'DBLIB_PORT',
                    1433
                ),

                'database' => env(
                    'DBLIB_DATABASE',
                    ''
                ),

                'user' => env(
                    'DBLIB_USER',
                    ''
                ),

                'password' => env(
                    'DBLIB_PASSWORD',
                    ''
                ),
            ],

            // =================================================
            // MONGODB
            // =================================================

            'mongodb' => [

                'driver' => 'mongodb',

                'uri' => env(
                    'MONGODB_URI',
                    'mongodb://127.0.0.1:27017'
                ),

                'database' => env(
                    'MONGODB_DATABASE',
                    ''
                ),

                'options' => [],

                'driver_options' => [],
            ],
        ],

    ],

    // =====================================================
    // SESSION
    // =====================================================

    'session' => [

        'driver' => env(
            'SESSION_DRIVER',
            'file'
        ),

        'lifetime' => (int) env(
            'SESSION_LIFETIME',
            120
        ),

        'expire_on_close' => filter_var(
            env(
                'SESSION_EXPIRE_ON_CLOSE',
                false
            ),
            FILTER_VALIDATE_BOOL
        ),

        'encrypt' => filter_var(
            env(
                'SESSION_ENCRYPT',
                false
            ),
            FILTER_VALIDATE_BOOL
        ),

        'path' => env(
            'SESSION_COOKIE_PATH',
            '/'
        ),

        'domain' => env(
            'SESSION_COOKIE_DOMAIN',
            null
        ),

        'secure' => filter_var(
            env(
                'SESSION_COOKIE_SECURE',
                false
            ),
            FILTER_VALIDATE_BOOL
        ),

        'http_only' => filter_var(
            env(
                'SESSION_COOKIE_HTTP_ONLY',
                true
            ),
            FILTER_VALIDATE_BOOL
        ),

        'same_site' => env(
            'SESSION_COOKIE_SAME_SITE',
            'Lax'
        ),

        'files' => BASE_PATH
            . '/storage/sessions',

        'cookie' => env(
            'SESSION_COOKIE',
            'pixelfix_session'
        ),

    ],

    // =====================================================
    // SECURITY
    // =====================================================

    'security' => [

        'csrf' => filter_var(
            env(
                'CSRF_ENABLED',
                true
            ),
            FILTER_VALIDATE_BOOL
        ),

    ],

    // =====================================================
    // VIEWS
    // =====================================================

    'view' => [

        'debug' => filter_var(
            env(
                'TWIG_DEBUG',
                false
            ),
            FILTER_VALIDATE_BOOL
        ),

    ],

    // =====================================================
    // UI
    // =====================================================

    'ui' => [

        'driver' => env(
            'UI_DRIVER',
            'toastr'
        ),

        'zebra_theme' => env(
            'UI_ZEBRA_THEME',
            'flat'
        ),

    ],

    // =====================================================
    // LOGGING
    // =====================================================

    'logging' => [

        'level' => env(
            'LOG_LEVEL',
            'debug'
        ),

    ],

    // =====================================================
    // MAIL
    // =====================================================

    'mail' => [

        'default' => env(
            'MAIL_MAILER',
            'smtp'
        ),

        'host' => env(
            'MAIL_HOST',
            ''
        ),

        'port' => (int) env(
            'MAIL_PORT',
            587
        ),

        'username' => env(
            'MAIL_USERNAME',
            ''
        ),

        'password' => env(
            'MAIL_PASSWORD',
            ''
        ),

        'encryption' => env(
            'MAIL_ENCRYPTION',
            'tls'
        ),

        'timeout' => (int) env(
            'MAIL_TIMEOUT',
            10
        ),

        'from' => [

            'address' => env(
                'MAIL_FROM_ADDRESS',
                ''
            ),

            'name' => env(
                'MAIL_FROM_NAME',
                env('APP_NAME', 'PIXELFIX')
            ),
        ],

    ],

    // =====================================================
    // SCHEDULING
    // =====================================================

    'scheduling' => [

        'timezone' => env(
            'SCHEDULER_TIMEZONE',
            env('TIMEZONE', 'UTC')
        ) ?: 'UTC',

    ],

    // =====================================================
    // NOTIFICATIONS
    // =====================================================

    'notifications' => [

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

    ],

    // =====================================================
    // BROADCASTING
    // =====================================================

    'broadcasting' => [

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

    ],

    // =====================================================
    // BROWSER BROADCASTING / WEBSOCKETS
    // =====================================================

    'websockets' => [

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

    ],

    // =====================================================
    // REDIS
    // =====================================================

    'redis' => [

        'default' => env(
            'REDIS_CONNECTION',
            'default'
        ) ?: 'default',

        'pubsub' => [

            'connection' => env(
                'REDIS_PUBSUB_CONNECTION',
                env('REDIS_CONNECTION', 'default')
            ) ?: 'default',

        ],

        'connections' => [

            'default' => [

                'host' => env(
                    'REDIS_HOST',
                    '127.0.0.1'
                ) ?: '127.0.0.1',

                'port' => (int) (
                    env('REDIS_PORT', 6379) ?: 6379
                ),

                'username' => env(
                    'REDIS_USERNAME',
                    null
                ),

                'password' => env(
                    'REDIS_PASSWORD',
                    null
                ),

                'database' => (int) (
                    env('REDIS_DB', 0) ?: 0
                ),

                'timeout' => (float) (
                    env('REDIS_TIMEOUT', 2.5) ?: 2.5
                ),

                'persistent' => filter_var(
                    env('REDIS_PERSISTENT', false),
                    FILTER_VALIDATE_BOOL
                ),

                'persistent_id' => env(
                    'REDIS_PERSISTENT_ID',
                    'pixelfix'
                ) ?: 'pixelfix',

                'read_timeout' => env(
                    'REDIS_READ_TIMEOUT',
                    null
                ),

            ],

        ],

    ],

    // =====================================================
    // EVENTS
    // =====================================================

    'events' => [

        'cache' => [

            'path' => BASE_PATH . '/storage/cache/events.php',

        ],

    ],

    // =====================================================
    // QUEUE
    // =====================================================

    'queue' => [

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

    ],

    // =====================================================
    // APPLICATION SCHEDULES
    // =====================================================

    // Named schedule settings are application configuration. The framework
    // Scheduler remains generic; each application registers callbacks and can
    // configure a named schedule independently of its domain.
    'schedules' => [

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

    ],

    // =====================================================
    // APPLICATION SERVICE PROVIDERS
    // =====================================================

    'providers' => [

    ],

];
