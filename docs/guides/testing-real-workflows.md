# Test Real Workflows, Not Just Individual Methods

A useful test proves observable behavior. For an authorization-sensitive task update, it is not enough to test that a policy callback returns `false`; also test that the application refuses the HTTP request and does not change the database. For a JSON endpoint, it is not enough to test a helper; inspect the status, headers, shape, and data returned by the route.

PixelFix includes its own test runner and `TestCase` implementation. Do not assume PHPUnit is installed or that PHPUnit annotations/assertions are available. Read the test conventions in the generated application and the framework's own tests when building new tests.

## 1. Run all tests or narrow the test run

From the framework repository root:

```powershell
php tests/run.php
```

Filter by part of a test name or class:

```powershell
php tests/run.php --filter=Policy
```

Run tests from a specific directory:

```powershell
php tests/run.php --dir=tests/Integration/Auth
```

Exclude one or more subdirectories:

```powershell
php tests/run.php --exclude=Fixtures,Slow
```

The runner scans PHP files in the selected directory, loads test classes, and runs public test methods following its naming conventions. Use the same runner and options documented by the actual `tests/run.php` in your project; do not copy PHPUnit-only command flags into PixelFix instructions.

## 2. Learn the assertion style

PixelFix's `TestCase` provides assertion methods such as `assertTrue()`, `assertFalse()`, `assertSame()`, `assertEquals()`, and exception expectations. Assertions throw the framework's assertion-failure exception when a condition is not met. A test should make its expected behavior clear and fail with a message that helps locate the cause.

A simple unit test follows this structure:

```php
<?php

namespace Tests\Unit;

use PixelFix\Framework\Testing\TestCase;

class SlugFormatTest extends TestCase
{
    public function test_slug_contains_no_spaces(): void
    {
        $slug = str_replace(' ', '-', 'my task');

        $this->assertSame('my-task', $slug);
    }
}
```

This example demonstrates the structure; in a real application, test the actual class or function you own rather than testing PHP's `str_replace()` as if it were application business logic.

## 3. Test failures and exceptions deliberately

Use `expectException()` and, where appropriate, `expectExceptionMessage()` before executing the action that should fail:

```php
$this->expectException(\RuntimeException::class);
$this->expectExceptionMessage('A meaningful error message.');

$service->performInvalidOperation();
```

Do not catch an exception inside the test and then pass unconditionally. The test should fail if the expected failure does not happen, and it should fail if an unrelated exception occurs.

## 4. Separate the test levels

### Unit test

Tests one class or rule in isolation. Use explicit inputs and assert exact outputs. Substitute dependencies where the design supports it.

### Integration test

Tests multiple framework pieces together, such as route registration and middleware resolution, model relationships, password guards, policy evaluation, or service-provider bootstrapping.

### Feature/workflow test

Tests a behavior visible to an application user or client. It may include routing, validation, authorization, database state and response rendering. For example: a user attempts to update a task owned by another user; the response is denied and the stored title does not change.

### Database test

Tests schema, queries, relationships, transactions, soft deletes, and persistence. Configure the required PDO driver. If a test uses SQLite in memory, PHP must have `pdo_sqlite` enabled; a missing driver is an environment problem, not evidence that the query assertion itself is wrong.

## 5. Example: test the authorization decision

For a small gate, test both sides of the rule with users representing different states. A gate should not be tested only with an administrator:

- administrator + `manage-users` → allowed;
- ordinary user + `manage-users` → denied;
- unauthenticated request to a route protected by `auth` → rejected/redirected according to the app's configured flow.

Use the real provider, gate, and test setup used by the application. If a Gate callback depends on a `role` attribute, first confirm that the model/schema and fixture actually provide that field. The starter user schema does not contain a role column until your application adds one.

## 6. Example: test a record-ownership workflow

For an update endpoint, arrange two tasks and two users: one owns the task and another does not. Then test:

1. The owner can update the task.
2. The non-owner is denied.
3. The task in the database remains unchanged after the denied request.
4. The controller never accepts `user_id` from the request to transfer ownership.
5. A missing task returns the agreed not-found response.

Testing only the UI is insufficient; direct HTTP requests must be denied too.

## 7. Database isolation

A database test should not depend on records left behind by a previous test. Prefer an isolated test database or in-memory database where supported, create the schema needed by the test, and clean up after it. Do not run tests against a production database. If a test drops tables, make sure it can only reach a disposable database.

If you use SQLite for tests but deploy to MySQL/MariaDB, also test migrations and critical SQL on the production engine. Differences in DDL, locking, unique constraints, JSON handling and concurrency can matter.

## 8. Test JSON endpoints as clients see them

For an API request, assert more than the PHP return value:

- status code;
- content type;
- expected JSON envelope and fields;
- omitted sensitive fields;
- validation failure shape;
- authentication and authorization behavior;
- pagination metadata when relevant.

For example, if a resource wraps data under `data`, the test should read `data` rather than expecting model properties at the JSON root. See [JSON Responses](../http/json-responses.md) and [API Resources](../api/resources.md).

## 9. Keep the suite focused and readable

Use test names that state a behavior, for example `test_non_owner_cannot_update_task`. Arrange data, perform one action, and assert one or more related outcomes. Avoid one enormous test that covers login, create, update, delete, authorization, and pagination all at once: when it fails, it should be easy to tell which behavior regressed.

When a bug is reported, first write a failing test that reproduces the observed behavior, then fix the code, then rerun the focused test and the broader suite. This makes the intended contract executable documentation.

## 10. Troubleshoot the test environment

- If PHP says `could not find driver`, check `php -m` and `PDO::getAvailableDrivers()` for the configured driver.
- If Composer autoload cannot be located, run tests from the correct project root and inspect the test bootstrap's expected autoload locations.
- If a test passes alone but fails in the suite, inspect global/static state, sessions, route registry resets, environment variables, and cleanup.
- If an HTTP test unexpectedly receives a redirect, inspect authentication middleware and the request's expected response format.
- If a policy test unexpectedly allows an operation, inspect the generated policy defaults and verify that the controller actually calls authorization.

Related reading: [Testing Overview](../testing/overview.md), [Test Runner](../testing/test-runner.md), [Feature Tests](../testing/feature-tests.md), [Database Testing](../testing/database-testing.md), and [Authorization from Zero](authorization-from-zero.md).
