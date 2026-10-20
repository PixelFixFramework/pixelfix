# Configuration

Configuration lets you change application behavior without rewriting PHP classes. For example, the database host can change between a developer's computer and production while the model classes stay the same.

## Environment values and configuration are different

The `.env` file contains values that vary by environment, such as credentials and the application URL. The active configuration is assembled in `config/config.php` after environment values are loaded.

Example `.env` values:

```dotenv
APP_NAME="Task Manager"
APP_ENV=local
APP_DEBUG=true
DB_CONNECTION=sqlite
```

The exact variables used depend on the active `config/config.php`. Adding a line to `.env` has no effect unless the configuration reads it.

## Read values in application code

Use `env()` when a configuration file needs to read an environment variable. For example, a simplified configuration file can return:

```php
<?php

return [
    'app' => [
        'name' => env('APP_NAME', 'PixelFix'),
    ],
];
```

The configuration loader reads the environment variable while assembling the configuration. In an application service or controller, read the resolved value with `config()`:

```php
$appName = config('app.name', 'PixelFix');
$defaultConnection = config('database.default');
```

The second argument to `env()`/`config()` supplies a fallback when no value is configured. A fallback is not a substitute for requiring a production secret; validate mandatory deployment settings during setup.

## Current starter configuration

The reference application groups settings under areas including `app`, `auth`, `database`, `session`, `security`, `view`, `ui`, `logging`, and `providers`. Check `config/config.php` in your installed starter for the actual keys and defaults in use. Empty placeholder files do not necessarily contain the active values.

## Keep secrets out of source control

Do not commit `.env` values containing passwords, private keys, API tokens, or production credentials. Share a sanitized example file if teammates need to know which variable names to define.

## Troubleshooting

If a changed value is not taking effect, verify the spelling of the config key, confirm that the application reads the matching environment variable, and check whether a long-running process needs to be restarted. For database settings, confirm the active connection and PHP driver before troubleshooting migrations.
