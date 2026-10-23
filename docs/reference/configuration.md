# Configuration Reference

PixelFix loads environment values and then assembles configuration from PHP files in the application's `config/` directory. Each top-level file maps to one group: `config/app.php` supplies the `app` group, `config/database.php` supplies `database`, and `config/providers.php` supplies `providers`. Each file must return an array containing that group's values. The assembled repository is exposed through `config()` and the configuration service.

## Reading configuration

```php
$name = config('app.name');
$connection = config('database.default', 'sqlite');
$enabled = config('websockets.enabled', false);
```

Dot notation reads nested values. Supply a fallback for optional keys. `config('...')` is the application-facing helper; `app(PixelFix\Framework\Config\Config::class)` resolves the configuration service for direct repository operations.

```php
$config = app(PixelFix\Framework\Config\Config::class);
$config->get('app.name');
$config->has('database.default');
$config->missing('database.default');
$config->set('app.name', 'Example Portal');
$config->merge(['app' => ['debug' => false]]);
$config->all();
```

`set()` creates missing intermediate arrays. `merge()` recursively replaces nested values while preserving unrelated siblings. `replace()` replaces the full configuration array and `reset()` clears it; use these low-level operations deliberately.

## Bootstrap order

The starter bootstrap loads environment values and configuration before core services and application providers are initialized. Services that depend on configured values should therefore be resolved after configuration loading. Application providers should register application behavior, not mutate unrelated configuration as a workaround for missing bootstrap setup.

## Configuration files in the starter

| File | Group and purpose |
|---|---|
| `config/app.php` | Application name, environment, URL/base path, and timezone |
| `config/auth.php` | Authentication defaults, guards/providers, password resets, redirects, and remember-me settings |
| `config/cache.php` | Default cache store, file path, and lock store |
| `config/rate_limiting.php` | Rate-limit prefix and authentication attempt limits/decay |
| `config/database.php` | Default driver, named connection definitions, and root seeder |
| `config/filesystems.php` | Default storage disk, disk roots/URL prefixes, and public symbolic links |
| `config/exports.php` | Optional PDF and spreadsheet renderer defaults and output formatting |
| `config/session.php` | Session driver, lifetime, cookie attributes, storage path, and expire-on-close behavior |
| `config/security.php` | CSRF settings |
| `config/view.php` | Twig view settings |
| `config/ui.php` | UI driver and Zebra Dialog theme |
| `config/logging.php` | Logging level |
| `config/mail.php` | Mail transport, host, sender, and timeout |
| `config/scheduling.php` | Scheduler timezone |
| `config/notifications.php` | Default channels and notification database table |
| `config/broadcasting.php` | Default broadcaster and Redis prefix |
| `config/websockets.php` | WebSocket host/port, allowed origins, frame limits, and relay settings |
| `config/redis.php` | Named Redis connections and Pub/Sub connection |
| `config/events.php` | Event cache/manifest settings |
| `config/queue.php` | Queue driver, retry, database/Redis tables, connection settings, and worker queue list |
| `config/schedules.php` | Settings for schedules registered by the starter example |
| `config/providers.php` | Application provider classes to load |

These are starter defaults, not requirements that every application enable every subsystem. The framework APIs and behavior are described in the subsystem references for [Cache](../cache/overview.md), [Queues](../queue/overview.md), [Events](../events/overview.md), [Scheduling](../scheduling/overview.md), [Mail](../mail/overview.md), [Notifications](../notifications/overview.md), [Redis](../redis/overview.md), [Broadcasting](../broadcasting/overview.md), and [WebSockets](../websockets/overview.md).

## Add application-specific configuration

Add a top-level PHP file such as `config/services.php` and return an array. The filename becomes the configuration group name. For instance, a returned `['payments' => ['enabled' => true]]` is accessible as `config('services.payments.enabled')`. No change to framework code is needed to load another top-level group file.

## Environment values versus application configuration

`.env` values are deployment-specific inputs. Each individual configuration file maps those inputs into namespaced keys. Prefer consuming `config()` from application code after bootstrap instead of calling `env()` throughout controllers/services. Each installed application has its own `.env`; matching key names across applications do not cause values to be shared.

The framework also reads the older `config/config.php` file for backward compatibility. If a group-specific file and the legacy file both define a group, the group-specific file takes precedence. New scaffolds use the individual-file layout.

For the environment-key inventory and which subsystem uses each group, see [Environment Reference](environment.md).
