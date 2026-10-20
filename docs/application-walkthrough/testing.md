# Example Application Testing

PixelFix provides a lightweight test runner. Add application tests as you implement each feature; framework tests do not replace tests for your application's own behavior.

## How setup works

`tests/bootstrap.php` defines `BASE_PATH`, loads Composer's autoloader, boots the application, and makes the application container available to tests. `tests/TestCase.php` extends `PixelFix\Framework\Testing\TestCase`, giving application tests the framework's assertions and setup helpers.

## Run tests

From the application root:

```powershell
php tests/run.php
php tests/run.php --dir=tests/Feature
php tests/run.php --filter=record
php tests/run.php --exclude=Fixtures
```

A filter narrows the run by a matching test class or method name. A new starter may initially have no application tests. If the runner reports zero discovered tests, that does not mean an application workflow has passed.

## Tests the application should add

Start with the behaviors that could break users or expose data:

1. Registration stores a password hash rather than the plain submitted password.
2. Login succeeds for correct credentials and rejects incorrect credentials.
3. Creating a record assigns the current user's ID on the server.
4. Invalid record input does not insert a row.
5. User A cannot view, update, or delete User B's record.
6. Deleting a record soft-deletes it; normal queries no longer return it.
7. Guests cannot open protected record pages.

## HTTP test support limitation

The current base `TestCase` does not implement Laravel-style simulated HTTP methods such as `$this->get()` or `$this->assertRedirect()`. Do not write tests using those methods unless the application separately provides an HTTP testing client. Service/database integration can be tested with the existing helpers; full request-cycle coverage can be executed against the real runtime or a separately implemented HTTP test utility.

See [Testing Overview](../testing/overview.md), [Database Testing](../testing/database-testing.md), and [Feature Tests](../testing/feature-tests.md).
