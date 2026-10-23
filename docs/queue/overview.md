# Queues and Jobs

PixelFix includes a queue manager, job contract, dispatch helpers, batches, and the `queue:work` command. Resolve the manager with `queue()` and use `dispatch($job)` as the global convenience helper.

## Define a job

A job implements `PixelFix\Framework\Queue\Job`; the `Queueable` trait supplies common queue options.

```php
use PixelFix\Framework\Queue\Job;
use PixelFix\Framework\Queue\Queueable;

final class RebuildReportJob implements Job
{
    use Queueable;

    public function handle(): void
    {
        // Perform the report work.
    }

    // Implement the remaining Job contract methods, or use the complete
    // generated job scaffold from `php pixel make:job RebuildReportJob`.
}

dispatch(new RebuildReportJob());
```

The `Job` contract includes `handle`, `middleware`, `maxAttempts`, `backoff`, `timeout`, `getQueue`, `getDelay`, `getTags`, `traceId`, `isReplaying`, and `metadata`. Prefer `php pixel make:job ...` to create a complete contract-conforming starting point. The `Queueable` trait configures delay, queue, attempts, timeout, and backoff options.

`dispatch($job)` returns a `PendingDispatch`, which supports `delay`, `onQueue`, and `dispatch`. `batch($jobs)` creates a `PendingBatch`; batches support completion/failure/finally callbacks and queue/delay configuration.

## Queue manager API

`queue()` resolves `QueueManager`. Its API includes `push`, `pushMany`, `dispatch`, `batch`, `batchRepository`, `pop`, `release`, `delete`, `fail`, `deadLetter`, `size`, `clear`, `recoverExpired`, `afterCommit`, `flushAfterCommit`, `clearAfterCommit`, `enable`, `disable`, `enabled`, `driver`, `fake`, and queue assertions such as `assertPushed` and `assertNotPushed`.

## Drivers and configuration

The starter configuration supports `sync`, `database`, and `redis` queue drivers. `QUEUE_CONNECTION` selects `queue.default`; other settings include `QUEUE_AFTER_COMMIT`, `QUEUE_DATABASE_TABLE`, `QUEUE_FAILED_TABLE`, `QUEUE_DEAD_LETTER_TABLE`, `QUEUE_RETRY_AFTER`, `QUEUE_REDIS_CONNECTION`, `QUEUE_REDIS_PREFIX`, and `WORKER_QUEUES` (the comma-separated list used by the local development supervisor). Database-backed jobs need the queue and failed/dead-letter tables available through migrations. Redis queues require the PHP Redis extension and reachable Redis server. Use the driver selected by the application configuration; do not assume the database queue is active merely because a database is configured.

## Run a worker

```powershell
php pixel queue:work
php pixel queue:work notifications
php pixel dev --queues=default,notifications
```

`queue:work` accepts a queue name or a comma-separated set of queues and worker options for sleep, memory, job/runtime limits, visibility timeout, worker ID, and stop-when-empty. The `dev` command manages a worker for database/Redis queue drivers and accepts `--queues`.

For database queues, failed jobs can be inspected/retried with `queue:failed` and `queue:retry`. These recovery commands operate on the SQL `failed_jobs` table; they are not a universal viewer for Redis-specific failures. Review the configured dead-letter policy before retrying production jobs.

## Testing and safety

Use `queue()->fake()` and `assertPushed` / `assertNotPushed` for job-dispatch tests. Keep `handle()` safe to retry when possible; a process can fail after external work but before acknowledging a job. Do not put passwords, tokens, or full sensitive records in job metadata or tags.
