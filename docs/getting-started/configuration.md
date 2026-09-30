# Configuration

PixelFix loads environment variables and application configuration during bootstrap. The Task Manager reference application keeps its active configuration in `config/config.php` and loads it through the framework configuration bootstrapper.

## Environment

The application loads environment variables before configuration is loaded. Application values can therefore be defined in `.env` and consumed with `env()`:

```php
'name' => env('APP_NAME', 'PixelFix'),
```

## Configuration repository

Read configuration values with:

```php
config('app.name');
config('database.default');
config('auth.defaults.guard');
```

A default can be supplied:

```php
config('app.name', 'PixelFix');
```

## Main Task Manager configuration sections

The current reference application defines these top-level sections:

```text
app
auth
database
session
security
view
ui
logging
providers
```

The exact keys should be read from the application's current configuration file. They are intentionally environment-driven so development and deployment settings can change without modifying application classes.

## Authentication configuration

The reference application defines a `web` session guard and a `users` database provider backed by `App\Models\User`.

## Database configuration

The current configuration contains named connection definitions for MySQL, MariaDB, PostgreSQL, SQLite, SQL Server, DBLIB, and MongoDB, with the default connection selected through `DB_CONNECTION`.

## Views and application runtime

View behavior, UI selection, session behavior, logging, and provider registration are configured from the same configuration repository.

## Do not confuse empty starter files with active configuration

The reference application's `config/` directory also contains several empty files such as `config/app.php` and `config/database.php`. They are not the active source of the loaded values in the uploaded application; `config/config.php` contains the populated configuration that is consumed by the bootstrap process. Documentation therefore follows the effective runtime configuration rather than the presence of placeholder filenames.
