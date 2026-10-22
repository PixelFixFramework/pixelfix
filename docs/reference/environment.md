# Environment and Configuration Reference

The starter application loads `.env` values during bootstrap and maps them into namespaced values through the individual PHP files under `config/`. For example, `config/app.php` reads application environment values and `config/database.php` reads database connection values. Each application owns its own `.env` file; the same key name in two applications does not share the value. Application code should normally read `config()` after bootstrap rather than reading environment variables directly throughout the request lifecycle.

## Helpers and normalization

```php
env('APP_ENV', 'production');
environment();
environment('local');
config('app.name');
```

`env()` returns a loaded value or the fallback. Common textual booleans/null/empty values are normalized by the environment parser. `environment()` returns the active environment; pass a name to test it (comparison is case-insensitive). `config()` reads a nested configuration value using dot notation and accepts an optional default.

## Configuration groups

The current starter defines `app`, `auth`, `cache`, `rate_limiting`, `database`, `session`, `security`, `view`, `ui`, `logging`, `mail`, `scheduling`, `notifications`, `broadcasting`, `websockets`, `redis`, `events`, `queue`, `schedules`, and `providers`. Each group lives in the correspondingly named file, such as `config/auth.php` or `config/queue.php`. Consult [Configuration Reference](configuration.md) for each group’s purpose. The files in the installed application are authoritative for its actual mappings and defaults. Legacy applications may still use `config/config.php`.

## Environment key groups in the current starter

The `.env.example` groups variables by subsystem. The important keys are:

| Area | Environment keys |
|---|---|
| Application | `APP_NAME`, `APP_ENV`, `APP_DEBUG`, `APP_URL`, `APP_BASE_PATH`, `TIMEZONE` |
| View/UI | `TWIG_DEBUG`, `UI_DRIVER`, `UI_ZEBRA_THEME` |
| Database selector | `DB_CONNECTION` |
| MySQL/MariaDB/PostgreSQL | `MYSQL_HOST`, `MYSQL_PORT`, `MYSQL_DATABASE`, `MYSQL_USER`, `MYSQL_PASSWORD`; corresponding `MARIADB_*` and `PGSQL_*` keys |
| SQLite | `SQLITE_DATABASE` |
| SQL Server / DBLIB | `SQLSRV_*`, `DBLIB_*` host/port/database/user/password settings |
| MongoDB | `MONGODB_URI`, `MONGODB_DATABASE` |
| Session | `SESSION_DRIVER`, `SESSION_NAME`, `SESSION_COOKIE`, `SESSION_LIFETIME`, `SESSION_COOKIE_PATH`, `SESSION_COOKIE_DOMAIN`, `SESSION_COOKIE_SECURE`, `SESSION_COOKIE_HTTP_ONLY`, `SESSION_COOKIE_SAME_SITE`, `SESSION_EXPIRE_ON_CLOSE`, `SESSION_ENCRYPT` |
| Authentication | `AUTH_REMEMBER_COOKIE`, `AUTH_REMEMBER_DURATION`, `AUTH_LOGIN_MAX_ATTEMPTS`, `AUTH_LOGIN_DECAY_SECONDS` |
| Security | `CSRF_ENABLED`, `PASSWORD_RESET_EXPIRE`, `PASSWORD_RESET_THROTTLE` |
| Logging | `LOG_LEVEL` |
| Mail | `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_ENCRYPTION`, `MAIL_TIMEOUT`, `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME` |
| Cache | `CACHE_DRIVER`, `CACHE_PATH`, `CACHE_LOCK_DRIVER` |
| Rate limiting | `RATE_LIMIT_PREFIX` (authentication limits also use the `AUTH_LOGIN_*` keys above) |
| Scheduling | `SCHEDULER_TIMEZONE`; `SCHEDULE_REMINDERS_*` configure only the reminder schedule registered by the starter example |
| Queue | `QUEUE_CONNECTION`, `QUEUE_AFTER_COMMIT`, `QUEUE_RETRY_AFTER`, `QUEUE_DATABASE_TABLE`, `QUEUE_FAILED_TABLE`, `QUEUE_DEAD_LETTER_TABLE`, `QUEUE_REDIS_CONNECTION`, `QUEUE_REDIS_PREFIX` |
| Notifications | `NOTIFICATIONS_CHANNELS`, `NOTIFICATIONS_TABLE` |
| Broadcasting | `BROADCAST_DRIVER`, `BROADCAST_REDIS_PREFIX` |
| Redis | `REDIS_CONNECTION`, `REDIS_PUBSUB_CONNECTION`, `REDIS_HOST`, `REDIS_PORT`, `REDIS_USERNAME`, `REDIS_PASSWORD`, `REDIS_DB`, `REDIS_TIMEOUT`, `REDIS_PERSISTENT`, `REDIS_PERSISTENT_ID`, `REDIS_READ_TIMEOUT` |
| WebSockets/relay | `WEBSOCKETS_ENABLED`, `WEBSOCKETS_HOST`, `WEBSOCKETS_PORT`, `WEBSOCKETS_ALLOWED_ORIGINS`, `WEBSOCKETS_MAX_FRAME_SIZE`, `WEBSOCKETS_MAX_HANDSHAKE_SIZE`, `WEBSOCKETS_RELAY_PORT`, `WEBSOCKETS_RELAY_MAX_BYTES` |

Database-specific variables are consumed only by the selected connection configuration. The supported configuration names in this starter include MySQL, MariaDB, PostgreSQL, SQLite, SQL Server, DBLIB and MongoDB; using a driver still requires its applicable PHP extension and service.

## Subsystem-specific details

- The general cache supports `array` and `file` drivers in this version; see [Cache](../cache/overview.md).
- The queue selector supports `sync`, `database`, and `redis`; see [Queues](../queue/overview.md). Redis-backed features require the PHP Redis extension.
- `MAIL_MAILER=smtp` uses the SMTP transport. Fill in real credentials and sender details before expecting mail delivery; see [Mail](../mail/overview.md).
- `SCHEDULER_TIMEZONE` is an IANA timezone. `SCHEDULE_REMINDERS_*` is the starter application's reminder schedule configuration, not a required setting for all PixelFix applications; see [Scheduling](../scheduling/overview.md).
- WebSockets are controlled by `WEBSOCKETS_ENABLED` and need their server and Redis relay processes; see [WebSockets](../websockets/overview.md).
- `UI_ZEBRA_THEME` accepts `classic`, `flat`, or `materialize` in the starter configuration.

Never commit real passwords, API tokens, SMTP credentials, or production secrets to `.env.example` or the repository.
