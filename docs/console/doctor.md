# `php pixelfix doctor`

`doctor` is a fast, read-only diagnostic for a PixelFix application. It checks the CLI PHP runtime and extensions, active database connectivity, file-session storage, migration status, configured queue driver/storage, Redis connectivity where required, notification storage/channel resolution, and core service resolution.

```powershell
php pixelfix doctor
php pixelfix doctor --verbose
```

The normal output focuses on checks and remediation for warnings/failures. `--verbose` also includes informational guidance, including worker/scheduler operation and the limits of a connectivity-only broadcasting check.

## What it does not do

Doctor does **not** apply migrations, write queue jobs or cache entries, send notifications/email, publish broadcasts, or execute scheduled callbacks. It runs a read-only database `SELECT 1`, checks configured tables, resolves services, and issues Redis `PING` only when an active queue or broadcasting driver requires Redis.

Use `php pixelfix subsystems:verify` for isolated end-to-end runtime smoke tests. That command intentionally has a broader scope, writes unique diagnostic data, processes only its isolated queue and notification diagnostics, and publishes an actual broadcast for receipt verification.

## Common remediation

- **Wrong PHP version/extension:** run `php -v`, `php --ini`, and `php -m` in the same terminal that runs `php pixelfix`.
- **Database connection failure:** check `database.default`, the corresponding `database.connections` entry, relevant environment variables, and database service availability. Run `php pixelfix migrate` only after confirming the configured database is the intended target.
- **Pending migrations or missing queue/notification tables:** review the migration names/configured table names, then run `php pixelfix migrate` against the intended database.
- **File sessions not writable:** create the directory configured by `session.files` and grant write permission to the account running PHP.
- **Redis connection failure:** check `redis.default`, `redis.pubsub.connection` and/or `queue.redis.connection`, the matching `redis.connections` entry, and the active CLI's PhpRedis extension. A blank `read_timeout` should remain unset rather than being converted to zero.
- **Persistent queue worker:** start `php pixelfix dev --no-server --queues=<queue>[,<queue>...]` with the queues used by the application, or set `PIXELFIX_WORKER_QUEUES` and start `php pixelfix dev`.
- **Scheduler:** `doctor` only counts registered records. Run `php pixelfix dev` to manage the scheduler with the local development runtime, or run `php pixelfix schedule:work` separately. Do not start both for the same application unless duplicate scheduler processes are intended.

Doctor's framework checks are application-independent. Business workflows belong in application-owned tests/probes and must not be hard-coded into this command.
