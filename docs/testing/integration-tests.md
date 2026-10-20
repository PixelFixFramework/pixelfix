# Integration Tests: Verify That Framework Pieces Work Together

A unit test checks one small piece in isolation. An integration test verifies that multiple pieces cooperate correctly. For example, a test might boot the application, resolve a service from the container, run a model query against a configured database, and confirm the result.

## When to write one

Use integration tests when a defect could occur between layers rather than inside one isolated method. Typical examples include:

- an application provider registering the expected service into the container;
- routing and middleware cooperating to dispatch an action;
- a model using the configured connection and SQL grammar;
- authentication resolving a user through the guard and user provider;
- a migration and model agreeing about database columns.

## Access the booted application

PixelFix's base test case bootstraps an application for the test. The application container is available through `$this->app`:

```php
use PixelFix\Framework\Database\Infrastructure\DatabaseManager;

$db = $this->app->make(DatabaseManager::class);
```

`make(DatabaseManager::class)` asks the container for the service registered under that class. This is preferable to manually constructing a second database manager when the test needs to inspect the application’s configured database service.

The example resolves the service; it does not run a query or create data by itself. Add setup and assertions for the behavior being tested, and ensure the database test environment is configured.

## Keep tests deterministic

A deterministic test yields the same result when run alone or with the rest of the suite. Avoid relying on another test's rows, timestamps, current session, or working directory. The base `TestCase` resets route and session state, but a test that modifies other global state must clean it up itself.

Use the temporary-file and directory helpers provided by the test case when working with the filesystem. When a test creates database records, use a dedicated test database or explicit cleanup strategy so it does not alter developer data.

## Important limitation

PixelFix's current `TestCase` is not a built-in HTTP simulation client; examples that call Laravel-style `$this->get()` or `$this->assertRedirect()` will not work unless your project adds that functionality. Test the actual service integration with the provided tools, or invoke the real application runtime for end-to-end HTTP coverage.

See [Testing Overview](overview.md), [Database Testing](database-testing.md), and [Feature Tests](feature-tests.md).
