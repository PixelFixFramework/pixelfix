# Environment and Configuration Reference

The starter application ships a commented `.env.example`. Copy it to `.env` (or run `composer environment:setup`) and customize the values for your machine or deployment. The PHP files under `config/` translate environment values into typed, namespaced settings. After bootstrap, application code should generally read `config()` rather than call `env()` throughout controllers and services.

Never commit real credentials, API tokens, production secrets, or private connection strings. A blank environment value is an empty string; it does not always mean “use the fallback.” Boolean values use `true` or `false`; use `null` only where the specific option documents null as meaningful.

## Helpers

```php
env('APP_ENV', 'production');
environment();
environment('local');
config('app.name');
```

`env()` returns the loaded value or the supplied fallback. `environment()` reports the active environment or compares it with the supplied name. `config()` reads a configuration value using dot notation and accepts a fallback.

## Configuration groups

The starter has individual files for `app`, `auth`, `cache`, `rate_limiting`, `database`, `filesystems`, `exports`, `session`, `security`, `view`, `ui`, `logging`, `mail`, `scheduling`, `notifications`, `broadcasting`, `websockets`, `redis`, `events`, `queue`, `schedules`, and `providers`. For details, see [Configuration Reference](configuration.md). The installed application's files are authoritative for actual option names and defaults.

## Environment variable inventory

The names below correspond to the shipped `.env.example`; a subsystem uses a variable only when its configuration or application code reads it.

| Area | Environment options | Configuration file |
|---|---|---|
| Application | `APP_NAME`, `APP_ENV`, `APP_DEBUG`, `APP_URL`, `APP_BASE_PATH`, `TIMEZONE` | `config/app.php` |
| Views and UI | `TWIG_DEBUG`, `UI_DRIVER`, `UI_ZEBRA_THEME` | `config/view.php`, `config/ui.php` |
| Default database | `DB_CONNECTION`, `MYSQL_*`, `MARIADB_*`, `PGSQL_*`, `SQLITE_DATABASE`, `SQLSRV_*`, `DBLIB_*`, `MONGODB_URI`, `MONGODB_DATABASE` | `config/database.php` |
| Named database connections | App-defined keys such as the commented `REPORTING_DB_*` example | `config/database.php` |
| Filesystem | `FILESYSTEM_DISK` | `config/filesystems.php` |
| PDF export | `PDF_PAPER`, `PDF_ORIENTATION`, `PDF_ENCODING`, `PDF_DEFAULT_FONT`, `PDF_DPI`, `PDF_REMOTE_ENABLED` | `config/exports.php` |
| Spreadsheet export | `SPREADSHEET_FORMAT`, `SPREADSHEET_SHEET_NAME`, `SPREADSHEET_AUTO_SIZE_COLUMNS`, `SPREADSHEET_HEADER_BOLD` | `config/exports.php` |
| Session | `SESSION_DRIVER`, `SESSION_LIFETIME`, `SESSION_COOKIE`, `SESSION_COOKIE_PATH`, `SESSION_COOKIE_DOMAIN`, `SESSION_COOKIE_SECURE`, `SESSION_COOKIE_HTTP_ONLY`, `SESSION_COOKIE_SAME_SITE`, `SESSION_EXPIRE_ON_CLOSE` | `config/session.php` |
| Authentication | `AUTH_REMEMBER_COOKIE`, `AUTH_REMEMBER_DURATION` | `config/auth.php` |
| Security and password reset | `CSRF_ENABLED`, `PASSWORD_RESET_EXPIRE`, `PASSWORD_RESET_THROTTLE` | `config/security.php`, `config/auth.php` |
| Logging | `LOG_LEVEL` | `config/logging.php` |
| Mail | `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_ENCRYPTION`, `MAIL_TIMEOUT`, `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME` | `config/mail.php` |
| Cache and locks | `CACHE_DRIVER`, `CACHE_PATH`, `CACHE_LOCK_DRIVER` | `config/cache.php` |
| Rate limiting | `RATE_LIMIT_PREFIX`, `AUTH_LOGIN_MAX_ATTEMPTS`, `AUTH_LOGIN_DECAY_SECONDS` | `config/rate_limiting.php` |
| Scheduling | `SCHEDULER_TIMEZONE`, `SCHEDULE_REMINDERS_ENABLED`, `SCHEDULE_REMINDERS_FREQUENCY`, `SCHEDULE_REMINDERS_START_HOUR`, `SCHEDULE_REMINDERS_END_HOUR` | `config/scheduling.php`, `config/schedules.php` |
| Queue and worker | `QUEUE_CONNECTION`, `QUEUE_AFTER_COMMIT`, `QUEUE_RETRY_AFTER`, `QUEUE_DATABASE_TABLE`, `QUEUE_FAILED_TABLE`, `QUEUE_DEAD_LETTER_TABLE`, `QUEUE_REDIS_CONNECTION`, `QUEUE_REDIS_PREFIX`, `WORKER_QUEUES` | `config/queue.php` |
| Notifications | `NOTIFICATIONS_CHANNELS`, `NOTIFICATIONS_TABLE` | `config/notifications.php` |
| Broadcasting | `BROADCAST_DRIVER`, `BROADCAST_REDIS_PREFIX` | `config/broadcasting.php` |
| Redis | `REDIS_CONNECTION`, `REDIS_PUBSUB_CONNECTION`, `REDIS_HOST`, `REDIS_PORT`, `REDIS_USERNAME`, `REDIS_PASSWORD`, `REDIS_DB`, `REDIS_TIMEOUT`, `REDIS_PERSISTENT`, `REDIS_PERSISTENT_ID`, `REDIS_READ_TIMEOUT` | `config/redis.php` |
| WebSockets and relay | `WEBSOCKETS_ENABLED`, `WEBSOCKETS_HOST`, `WEBSOCKETS_PORT`, `WEBSOCKETS_ALLOWED_ORIGINS`, `WEBSOCKETS_MAX_FRAME_SIZE`, `WEBSOCKETS_MAX_HANDSHAKE_SIZE`, `WEBSOCKETS_RELAY_PORT`, `WEBSOCKETS_RELAY_MAX_BYTES` | `config/websockets.php` |

## Named database connections

`DB_CONNECTION` selects the default named connection. Additional connections are declared in the `connections` array in `config/database.php`; adding environment keys by itself does not create a connection. The variable prefix for each added connection is chosen by the application. The commented `REPORTING_DB_*` values in `.env.example` illustrate a convention only; uncomment and use them only after defining the matching `reporting` connection in `config/database.php`. See [Database Connections](../database/connections.md).

The configured database driver and the installed PHP extension are separate requirements. For example, a MySQL/MariaDB connection needs the matching PDO driver, SQLite needs `pdo_sqlite`, and PostgreSQL needs `pdo_pgsql`. Migration/schema support is not identical across every recognized connection name; check the installed framework version's [migration](../database/migrations.md) and [schema](../database/schema.md) guides.

## Storage and public files

`FILESYSTEM_DISK=local` selects the private local disk. `config/filesystems.php` defines each disk's driver, root and optional public URL prefix, plus symbolic links. The default public disk writes under `storage/app/public` and uses `/storage`; create its public link with `php pixel storage:link`. Do not make private exports or documents public merely to make them downloadable. See [Filesystem](../application/filesystem.md).

## PDF and spreadsheet exports

Export support is optional. Install `dompdf/dompdf` for PDF rendering and `phpoffice/phpspreadsheet` for spreadsheet generation. The environment settings only configure rendering; they do not install the packages.

- PDF: `PDF_PAPER`, `PDF_ORIENTATION`, `PDF_ENCODING`, `PDF_DEFAULT_FONT`, `PDF_DPI`, `PDF_REMOTE_ENABLED`. Remote assets are disabled by default because remote rendering can introduce SSRF and unsafe-resource risks.
- Spreadsheet: `SPREADSHEET_FORMAT` accepts `xlsx`, `xls`, `csv`, or `ods`; `SPREADSHEET_SHEET_NAME` selects the worksheet title; `SPREADSHEET_AUTO_SIZE_COLUMNS` and `SPREADSHEET_HEADER_BOLD` configure basic output formatting.

Read [PDF and Spreadsheet Exports](../exports/overview.md) for installation, APIs and security guidance. A PDF view/template, report layout, financial calculation or transcript/certificate design remains application-specific.

## Queues and workers

`QUEUE_CONNECTION` selects `sync`, `database`, or `redis`. Database/Redis queues require their supporting service and a running worker. `WORKER_QUEUES` is a comma-separated list used by `php pixel dev` when it launches a worker; a CLI `--queues` option overrides this value. Do not confuse the application's queue connection with the names of the queues it processes. See [Queues](../queue/overview.md) and [Developer Runtime](../console/developer-runtime.md).

## Defaults and deployment

The template defaults are intended for local development, not production. Before deployment, set `APP_ENV=production`, `APP_DEBUG=false`, a correct `APP_URL` and `TIMEZONE`, secure session cookies when serving HTTPS, valid database/mail credentials, and explicit WebSocket allowed origins when WebSockets are enabled. Install only optional packages your application uses, and never expose database diagnostics or secrets to untrusted users.
