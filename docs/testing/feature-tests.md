# Feature Tests

A feature test verifies an application behavior that involves more than one small function—for example, saving a task with its owner, restoring a soft-deleted record, or ensuring a service refuses an invalid operation. A unit test usually isolates one small piece; a feature test checks the result that matters to the user or database.

## Know what the built-in test runner provides

PixelFix ships with its own test runner, not PHPUnit. Test classes extend `PixelFix\Framework\Testing\TestCase`, and each public test method whose name begins with `test` is discovered by the runner. The base test case resets route and session state between tests and exposes the application container through `$this->app`.

The current base test case does **not** provide a Laravel-style HTTP test client with methods such as `get('/tasks')`, `post('/tasks', ...)`, or `assertRedirect()`. Do not copy those methods into your tests unless your application has implemented its own test helper. You can still write valuable integration tests against real model/service behavior and use the database assertions below. For full request lifecycle tests, use the application's available runtime entry point or add a dedicated test client as a separate testing capability.

## Example: verify a task is stored for the correct owner

The following database-backed example assumes your application has `User` and `Task` models, their migrations have been run against the test database, and `Task` has `user_id`, `title`, and `status` fields. It exercises model persistence and database state. It is not a simulated browser request because the stock test case does not include an HTTP test client.

```php
<?php

use App\Models\Task;
use App\Models\User;
use PixelFix\Framework\Testing\TestCase;
use PixelFix\Framework\Testing\Database\InteractsWithDatabase;

final class TaskCreationTest extends TestCase
{
    use InteractsWithDatabase;

    public function test_task_is_saved_with_its_owner(): void
    {
        $email = 'test-' . bin2hex(random_bytes(4)) . '@example.com';

        $owner = User::create([
            'name' => 'Test User',
            'email' => $email,
            'password' => password_hash('local-test-password', PASSWORD_DEFAULT),
        ]);

        $task = Task::create([
            'title' => 'Write JSON documentation',
            'user_id' => $owner->id,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Write JSON documentation',
            'user_id' => $owner->id,
            'status' => 'pending',
        ]);
    }
}
```

The test first creates a user, then creates a task owned by that user, and finally queries the database to confirm the exact values were saved. The random email prevents a unique-email constraint from causing a collision when the test is run repeatedly. This example uses the field names from a conventional Task Manager model; adapt the attributes to your own migrations and `$fillable` configuration.

Use a dedicated test database. Do not point this example at production data. For complete cleanup/isolation, use your application's database-test setup or reset the test tables between runs.

## Assertions you will use often

```php
$this->assertDatabaseHas('tasks', ['id' => $taskId]);
$this->assertDatabaseMissing('tasks', ['id' => $deletedId]);
$this->assertDatabaseCount('tasks', 3);
$this->assertSoftDeleted('tasks', ['id' => $taskId]);
```

These answer different questions: whether a matching row exists, whether no matching row exists, whether a table has an exact number of rows, and whether a soft-deleted row still exists with `deleted_at` set. See [Database Testing](database-testing.md) for the complete set.

## Test failure paths as well as success paths

A useful feature test checks both what should happen and what must not happen. For example, when an operation is rejected, confirm the record was not changed. For code that throws an exception, declare the expected exception before invoking the operation:

```php
$this->expectException(\InvalidArgumentException::class);
$this->expectExceptionMessage('Task title is required.');

$service->createTask(['title' => '']);
```

The runner passes this test only if the expected exception type and message occur. If the operation succeeds instead, the test fails because the expected exception was not thrown.

## Keep tests repeatable

Each test should create or identify the records it needs, avoid depending on another test's data, and clean up external resources. Use a dedicated test database rather than a production database. A test that passes only after another test has run is not reliable.

## Run the tests

From the application root, use the test script shipped in `tests/`:

```powershell
php tests/run.php
```

You can narrow a run with a filter or directory, for example `php tests/run.php --filter=TaskCreationTest` or `php tests/run.php --dir=tests/Feature`. Use the smallest relevant test while developing, then run the full suite before sharing changes.

Related topics: [Testing Overview](overview.md), [Integration Tests](integration-tests.md), [Database Testing](database-testing.md), and [Migrations](../database/migrations.md).
