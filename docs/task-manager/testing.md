# Task Manager Testing

The supplied Task Manager project includes a test bootstrap and PixelFix's test runner, but the uploaded reference application currently contains **zero discovered application test classes**. The infrastructure is installed; the application's behavior is not yet protected by tests.

## How setup works

`tests/bootstrap.php` defines `BASE_PATH`, loads Composer's autoloader, boots the application, and makes the application container available to tests. `tests/TestCase.php` extends `PixelFix\Framework\Testing\TestCase`, giving application tests the framework's assertions and setup helpers.

## Run tests

From the application root:

```powershell
php tests/run.php
php tests/run.php --dir=tests/Feature
php tests/run.php --filter=Task
php tests/run.php --exclude=Fixtures
```

A filter narrows the run by a matching test class or method name. At this snapshot, running the existing suite reports `Total: 0`; this means no tests were discovered, not that all application workflows passed.

## Tests the application should add

Start with the behaviors that could break users or expose data:

1. Registration stores a password hash rather than the plain submitted password.
2. Login succeeds for correct credentials and rejects incorrect credentials.
3. Creating a task assigns the current user's ID on the server.
4. Invalid task input does not insert a row.
5. User A cannot view, update, or delete User B's task.
6. Deleting a task soft-deletes it; normal queries no longer return it.
7. Guests cannot open protected task pages.

## HTTP test support limitation

The current base `TestCase` does not implement Laravel-style simulated HTTP methods such as `$this->get()` or `$this->assertRedirect()`. Do not write tests using those methods unless the application separately provides an HTTP testing client. Service/database integration can be tested with the existing helpers; full request-cycle coverage can be executed against the real runtime or a separately implemented HTTP test utility.

See [Testing Overview](../testing/overview.md), [Database Testing](../testing/database-testing.md), and [Feature Tests](../testing/feature-tests.md).
