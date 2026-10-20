# PixelFix subsystem verification and service management

## Framework-wide diagnostics

From any PixelFix application root, run:

```powershell
php pixelfix subsystems:verify
```

This command is part of the PixelFix framework, not an application-specific script. It does not assume any application model, domain event, or business table.

The command checks the PHP/runtime configuration, database connection and migration ledger, file-session path, configured queue driver and its required storage, Event dispatcher, Scheduler, Cache, Rate Limiter, Notification channel availability, and Redis connections when the active queue/broadcast configuration requires them. It then runs isolated runtime probes using unique diagnostic markers:

- Event dispatch with a temporary listener.
- Cache write/read/delete and Rate Limiter hit/count/clear.
- Schema index creation using unique temporary tables, where the active schema builder supports SQLite or MySQL.
- Queue push/pop and job processing on a unique queue name. It deliberately does **not** run the long-lived worker's expired-reservation sweep, which could affect unrelated jobs.
- Database notification delivery when the configured notification table exists.
- Notification-to-Broadcast-to-Redis Pub/Sub delivery when Redis broadcasting is configured, enabled, and reachable.

The command cleans up its own temporary cache entries, schema tables, receipt files, queue items, and diagnostic notification row. It never runs the application's scheduled callbacks or sends a real email. It exits non-zero if a configured/required stage fails and prints `[PASS]`, `[FAIL]`, or `[INFO]` for each stage.

Options:

```powershell
php pixelfix subsystems:verify --check-only
php pixelfix subsystems:verify --skip-broadcast
php pixelfix subsystems:verify --skip-notifications
```

`--check-only` skips temporary SQL schema creation, queue processing, notification writes, and broadcast publication. It still performs safe, token-scoped Event, Cache, and Rate Limiter probes and removes their temporary registrations/keys. `--skip-broadcast` is useful in applications that intentionally do not configure broadcasting. `--skip-notifications` skips the generic diagnostic notification flow.

## App-specific integration probes

Framework diagnostics verify the framework-level plumbing. A business flow—such as an order lifecycle event, invoice notification, or booking workflow—belongs to the application and should be tested with an application-specific probe, not hard-coded into the framework command.

Implement `PixelFix\Framework\Console\Diagnostics\SubsystemVerificationProbe`, then register its class in the application's `config/config.php`:

```php
'subsystems' => [
    'verification' => [
        'probes' => [
            App\Diagnostics\OrderWorkflowProbe::class,
        ],
    ],
],
```

A probe's `run(SubsystemVerificationContext $context)` can use `$context->token()` to tag synthetic records, report assertions with `$context->check($condition, $label, $detail)`, and provide informational notes with `$context->info($label, $detail)`. Probes must clean up only their own diagnostic data in `finally` blocks, never touch unrelated jobs/records, and must not send real messages unless explicitly designed for a separate opt-in delivery test.

For a generic framework-only run, the `probes` array can remain absent or empty.

## Background services on Windows

`PixelFixServices.ps1` is included for newly generated applications. For an existing application, place it at `scripts/PixelFixServices.ps1` in that application's root. Run PowerShell as the same Windows user that runs the application:

```powershell
Set-ExecutionPolicy -Scope Process Bypass -Force
.\scripts\PixelFixServices.ps1 setup -Queues "default,notifications"
```

Replace the queue list with the application's actual job queues. You can also set `PIXELFIX_WORKER_QUEUES` in `.env`; its default is `default`. A worker is registered only for `database` or `redis` queue drivers. The scheduler service calls `schedule:run` once a minute. Windows Task Scheduler manages the background processes and the wrapper restarts a worker after it exits. The tasks run while the configured Windows user is logged on.

Useful commands:

```powershell
.\scripts\PixelFixServices.ps1 status
.\scripts\PixelFixServices.ps1 stop
.\scripts\PixelFixServices.ps1 start
.\scripts\PixelFixServices.ps1 remove
.\scripts\PixelFixServices.ps1 verify
```

Logs are written to `storage/logs/pixelfix-queue-worker.log` and `storage/logs/pixelfix-scheduler.log`.

## Diagnostics boundary

The built-in command uses the application's actual configured queue and Redis drivers. A PHP Redis extension is required for framework Redis publishing; `redis-cli PING` alone does not prove PHP can publish. A passing framework smoke test does not imply that a user-facing browser push client or WebSocket transport exists, nor does it prove an SMTP provider can deliver externally. Those require separate, explicit app-level probes.
