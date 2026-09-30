# Environment and Configuration Reference

PixelFix applications load environment values during the bootstrap phase and expose configuration through the repository/config helper.

## Environment helper

Read an environment value with:

```php
env('APP_ENV', 'production');
```

The helper checks the loaded environment data and falls back to the supplied default.

Common textual values are normalized:

```text
true / (true)   → true
false / (false) → false
null / (null)   → null
empty / (empty) → ''
```

Other strings remain strings.

## Application environment

```php
environment();
```

returns the current application environment.

To test a specific environment:

```php
environment('local');
environment('production');
```

The comparison is case-insensitive.

## Configuration repository

The framework exposes configuration through:

```php
config('app.name');
```

and the underlying `PixelFix\\Framework\\Config\\Repository`.

Use dot notation to access nested configuration:

```php
config('database.default');
config('session.driver');
config('security.csrf');
```

A default can be supplied:

```php
config('mail.driver', null);
```

## Bootstrap order

The reference application bootstraps configuration before core services and application providers:

```text
LoadEnvironment
LoadConfiguration
CoreBootstraper
ProvidersBootstraper
BootConsole
Application::boot()
```

Application code should therefore consume configuration after bootstrap has completed.

## Reference Task Manager configuration

The uploaded Task Manager defines these top-level configuration groups in `config/config.php`:

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

Examples include:

```text
app.name
app.env
app.debug
auth.defaults.guard
database.default
session.driver
security.csrf
view.debug
ui.driver
logging.level
```

## Database environment variables

The Task Manager's database configuration reads environment values for its connection settings. The configured drivers include MySQL, MariaDB, PostgreSQL, SQLite, SQL Server, DBLIB, MongoDB, and additional PDO-compatible drivers supported by the framework connection layer.

The exact environment variable names are application configuration. Follow the project's `config/config.php` rather than assuming a different convention.

## Session environment variables

The reference configuration supports values for:

```text
SESSION_DRIVER
SESSION_LIFETIME
SESSION_EXPIRE_ON_CLOSE
SESSION_ENCRYPT
SESSION_COOKIE_PATH
SESSION_COOKIE_DOMAIN
SESSION_COOKIE_SECURE
SESSION_COOKIE_HTTP_ONLY
SESSION_COOKIE_SAME_SITE
SESSION_COOKIE
```

## Security environment variables

The Task Manager exposes:

```text
CSRF_ENABLED
```

as the switch controlling CSRF configuration.

## View and logging environment variables

The reference configuration also reads:

```text
TWIG_DEBUG
LOG_LEVEL
UI_DRIVER
```

These are application-facing configuration choices and can be changed without changing framework classes.
