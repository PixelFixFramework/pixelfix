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

        'password_timeout' => 10800,

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
    // APPLICATION SERVICE PROVIDERS
    // =====================================================

    'providers' => [

    ],

];