# Integration Tests

Integration tests exercise multiple framework components together. PixelFix's `tests/Integration` directory contains tests for interactions such as routing, database behavior, authentication, providers, and framework lifecycle features.

## When to use integration tests

Use an integration test when the behavior depends on collaboration between services that would be misleading to isolate. Examples include:

- a route passing through middleware and reaching a controller
- a model operation reaching the configured database connection
- a provider registering services into the application container
- authentication resolving a user through a guard and provider

## Application access

`TestCase` exposes the current application instance through its protected `$app` property after setup. The application container can then resolve framework services normally.

```php
$db = $this->app->make(
    PixelFix\Framework\Database\Infrastructure\DatabaseManager::class
);
```

## Keeping integration tests deterministic

Reset shared framework state between tests. The base `TestCase` resets route state and session state automatically. Tests that modify other global state should clean that state themselves.

Where a test needs temporary files or directories, use the helpers supplied by the base test case so teardown can remove them reliably.
