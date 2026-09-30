# Logging

PixelFix includes a lightweight logger for application and framework diagnostics.

## Logger helper

Resolve the logger with:

```php
logger()->info('Task created');
```

The logger supports the standard severity methods:

```php
logger()->emergency($message, $context);
logger()->alert($message, $context);
logger()->critical($message, $context);
logger()->error($message, $context);
logger()->warning($message, $context);
logger()->notice($message, $context);
logger()->info($message, $context);
logger()->debug($message, $context);
```

The context argument is optional and defaults to an empty array.

## Log destination

The default log path is:

```text
storage/logs/app.log
```

The logger creates the parent directory when necessary.

## Context and exceptions

Context values are JSON encoded. When a context value is a `Throwable`, PixelFix serializes useful diagnostic information including its message, file, line, and stack trace.

```php
try {
    // ...
} catch (Throwable $e) {
    logger()->error(
        'Task operation failed',
        ['exception' => $e]
    );
}
```

## Runtime metadata

The logger also records lightweight runtime metadata in memory. This can be retrieved through `runtimeMetadata()` and cleared through `reset()`.

This runtime metadata is distinct from the file log and is useful to framework internals and tests.
