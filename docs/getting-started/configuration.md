# Configuration

Configuration controls application behavior without requiring changes to framework classes. PixelFix loads environment values first, then loads the PHP files under `config/` into one configuration repository.

## Environment values and configuration are different

The `.env` file contains values that vary by environment, such as credentials and the application URL. The files under `config/` map those inputs to stable configuration keys used by application code.

Example `.env` values:

```dotenv
APP_NAME="My Application"
APP_ENV=local
APP_DEBUG=true
DB_CONNECTION=sqlite
```

Adding a line to `.env` has no effect unless a configuration file reads it. The current starter uses `config/app.php` for application settings and `config/database.php` for connection settings.

## Configuration files and keys

Each top-level file under `config/` maps to a configuration group with the same name. For example:

- `config/app.php` defines keys such as `app.name`, `app.env`, and `app.timezone`.
- `config/auth.php` defines authentication guards, providers, password settings, and redirects.
- `config/database.php` defines `database.default`, named `database.connections`, and the root seeder.
- `config/filesystems.php` defines the default storage disk, disk roots/URL prefixes, and public symbolic links.
- `config/exports.php` defines optional PDF and spreadsheet output defaults.
- `config/session.php` defines session driver, lifetime, cookie settings, and browser-close expiration.
- `config/providers.php` returns the list of application service providers.

Other starter files are `cache.php`, `rate_limiting.php`, `security.php`, `view.php`, `ui.php`, `logging.php`, `mail.php`, `scheduling.php`, `notifications.php`, `broadcasting.php`, `websockets.php`, `redis.php`, `events.php`, `queue.php`, and `schedules.php`.

A configuration file returns the contents of its own group, not a wrapper containing the group name. For example, `config/app.php` can contain:

```php
<?php

return [
    'name' => env('APP_NAME', 'PixelFix'),
    'env' => env('APP_ENV', 'production'),
    'debug' => env('APP_DEBUG', false),
    'timezone' => env('TIMEZONE', 'UTC'),
];
```

After bootstrap, read the resolved values with `config()`:

```php
$appName = config('app.name', 'PixelFix');
$defaultConnection = config('database.default', 'sqlite');
```

The filename supplies the first segment of the configuration key. Use `config/filesystems.php` to set the default storage disk and `config/exports.php` to tune the optional PDF/spreadsheet exporters; see [Filesystem](../application/filesystem.md) and [PDF and Spreadsheet Exports](../exports/overview.md). A custom `config/services.php` file returning `['payments' => ['enabled' => true]]` makes that value available as `config('services.payments.enabled')`.

## Environment variables belong in configuration files

Use `env()` inside configuration files to translate environment-specific input into typed settings. In controllers and services, prefer `config()` after bootstrap rather than calling `env()` throughout the application. The second argument to either helper supplies a fallback; it is not a substitute for validating required production secrets.

## Backward compatibility

New applications use separate files under `config/`. The framework also supports the older `config/config.php` format for existing applications during migration. When an individual group file and the legacy file both define the same group, the individual file takes precedence for that group.

## Keep secrets out of source control

Do not commit `.env` values containing passwords, private keys, API tokens, or production credentials. Keep `.env.example` sanitized so teammates know which variable names to define.

## Troubleshooting

If a changed value is not taking effect, verify the dot-notated key, the corresponding file (for example, `config/database.php` for database values), and the environment variable read by that file. A long-running process may need to be restarted after configuration changes. For database problems, confirm the selected connection and PHP driver before troubleshooting migrations.
