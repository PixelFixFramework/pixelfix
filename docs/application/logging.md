# Logging

Logs help you understand what happened when a request or background maintenance task fails. PixelFix exposes the `logger()` helper so application code can write diagnostic messages without directly managing log files.

## Write a log entry

```php
logger()->info('Task created', [
    'task_id' => $task->id,
    'user_id' => $user->id,
]);
```

The first argument is the message. The optional context array adds structured values that help identify the affected record. Other levels are available for different severity, such as warning and error messages.

## Log exceptions

When catching an exception to add context, include useful diagnostic information and preserve the exception details:

```php
try {
    // Perform an operation that may fail.
} catch (\Throwable $exception) {
    logger()->error('Unable to complete task operation', [
        'exception' => $exception->getMessage(),
    ]);

    throw $exception;
}
```

Do not swallow exceptions silently. If the current layer cannot recover, rethrow the exception or return an appropriate failure response.

## Protect sensitive information

Never log passwords, authentication tokens, session identifiers, private keys, or complete request bodies that may contain sensitive data. Log stable record IDs and a concise reason instead.

## Where to look for logs

The destination is controlled by the application's logging configuration. In the starter, runtime logs belong under `storage/`. In production, ensure the process has permission to write the log destination and that log files are rotated and protected.

Runtime debug metadata and ordinary application logs serve different purposes: debug metadata can help explain framework execution, while application log messages record events relevant to your domain.


## Choosing what to log

Use debug-level messages while diagnosing a problem, info-level messages for significant application milestones, warning-level messages when something unexpected was recovered from, and error-level messages when an operation failed. Keep logs useful to the person investigating the issue.

For example, a failed task save may be logged with a task identifier and a safe description of the failure. Do not log passwords, session IDs, access tokens, full authentication headers, or complete request payloads that might contain private data.

## How to investigate a missing log entry

1. Confirm the configured log path and that the process can write to its directory.
2. Check the configured minimum log level; a debug message may be intentionally filtered in production.
3. Check the exception handler and the code path to confirm execution reached the logging call.
4. Confirm the log directory is writable by the same operating-system user running PHP.
