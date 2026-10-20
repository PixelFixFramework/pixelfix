# Configuration Reference

PixelFix loads the application's configuration into the framework configuration repository during bootstrap. The starter application defines the main settings in `config/config.php`; environment variables are read there and then exposed through `config()` and the repository. Do not assume that every conventional configuration filename is loaded automatically.

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

## Configuration groups in the starter

The current starter `config/config.php` defines the following top-level groups:

| Group | Purpose |
|---|---|
| `app` | Application name, environment, base URL/path and timezone |
| `auth` | Authentication defaults, providers/guards and remember-me settings |
| `cache` | Default cache store, file path and lock store |
| `rate_limiting` | Prefix and authentication attempt limits/decay |
| `database` | Default driver and connection definitions |
| `session` | Session driver, lifetime, cookie and encryption settings |
| `security` | CSRF and password-reset security settings |
| `view` | Twig view locations/debug/cache configuration |
| `ui` | UI driver and Zebra Dialog theme |
| `logging` | Log channel/level/path settings |
| `mail` | SMTP transport, sender and timeout |
| `scheduling` | Scheduler timezone |
| `notifications` | Default notification channels and database table |
| `broadcasting` | Default broadcaster and Redis prefix |
| `websockets` | WebSocket host/port, allowed origins, frame limits and relay settings |
| `redis` | Named Redis connections and Pub/Sub connection |
| `events` | Event cache/manifest settings |
| `queue` | Queue driver, retry, database/Redis tables and connection settings |
| `schedules` | Configuration for schedules registered by this application |
| `providers` | Provider configuration/registration |

The exact group values and defaults in the application's `config/config.php` are authoritative for that application. The framework APIs and default behavior are described in the subsystem references for [Cache](../cache/overview.md), [Queues](../queue/overview.md), [Events](../events/overview.md), [Scheduling](../scheduling/overview.md), [Mail](../mail/overview.md), [Notifications](../notifications/overview.md), [Redis](../redis/overview.md), [Broadcasting](../broadcasting/overview.md), and [WebSockets](../websockets/overview.md).

## Environment values versus application configuration

`.env` values are deployment-specific inputs. The starter's `config/config.php` maps them into namespaced configuration keys. Prefer consuming `config()` from application code after bootstrap, instead of calling `env()` throughout controllers/services. Each installed application has its own `.env`; matching key names across applications do not cause values to be shared.

For the current environment-key inventory and which subsystem uses each group, see [Environment Reference](environment.md).
