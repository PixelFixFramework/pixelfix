<?php

return [

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

];
