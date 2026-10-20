# PixelFix Test Runner: Run, Filter, and Diagnose Tests

PixelFix ships a custom test runner. Its test case and assertions are not PHPUnit; do not assume PHPUnit is installed or that PHPUnit annotations and command-line switches are supported. Learn the runner that is in this source version and use the same runner in local development and continuous integration.

## Run the full suite

From the framework repository root:

```powershell
php tests/run.php
```

The runner loads `tests/bootstrap.php`, which loads the Composer autoloader, boots the test application, and registers its container. It discovers PHP files below the selected directory, loads test classes, and runs recognized test methods.

## Run a focused test

Use `--filter=` to match a class or test name:

```powershell
php tests/run.php --filter=Gate
```

Use `--dir=` to scan a narrower directory:

```powershell
php tests/run.php --dir=tests/Integration/Auth
```

The runner also accepts `--directory=` as an alias for `--dir=` and `--exclude=` with a comma-separated list of directories relative to the selected test directory. Confirm the exact path exists before using it. A test directory from a different PixelFix version may not exist in your checkout.

## Create a test class

Use the public generator when working inside an application or a framework repository that exposes it:

```powershell
php pixel make:test TaskPolicyTest
```

Inspect the created class. Tests normally extend `PixelFix\Framework\Testing\TestCase` and use public test methods named with the project's conventions, such as `test_task_owner_can_update_task()`. The framework's `TestCase` provides assertion methods and resets routes/session/application runtime between tests. Database tests may need their own schema setup or the documented database testing helpers.

## Arrange, act, assert

A well-structured test has three parts:

- **Arrange:** create the minimum records, objects, configuration, or authenticated state required.
- **Act:** call the public method or perform the request.
- **Assert:** verify the result and relevant side effects.

For example, an authorization test must assert not only that the policy denies a user but also that the protected operation does not update the row. A validation test should verify that invalid data is rejected and not saved. An API test should verify the HTTP status and JSON body, not merely a pre-response object.

## Assert a failure path

The testing library supports expected exception checks such as:

```php
$this->expectException(\RuntimeException::class);
$this->expectExceptionMessage('Expected failure message.');

$service->performInvalidOperation();
```

Place expectations immediately before the call expected to fail. If the operation does not throw, the test should fail. If you expect an authorization denial, use the exception or response behavior defined by that code path; do not assert an arbitrary exception class without verifying the implementation.

## Database driver requirements

Some framework tests use an in-memory SQLite database. PHP must have `pdo_sqlite` enabled for these tests. Check the exact PHP executable used by the terminal and inspect:

```powershell
php -v
php -m
php -r "var_export(PDO::getAvailableDrivers()); echo PHP_EOL;"
```

If the output does not list `sqlite`, database tests that construct an SQLite connection cannot run in that PHP environment. The presence of the SQLite native library alone does not guarantee the PDO driver is available. Use a compatible PHP build with the required extension enabled or run those tests in an environment that has it.

If an application uses MySQL/MariaDB in production, test critical migrations and queries against that database engine too. SQLite is useful for many tests but may differ in DDL, locking, constraints and query behavior.

## Why does a test fail only in the full suite?

Look for shared state: static registries, route definitions, global container instances, sessions, environment/config values, temporary files, database tables and cached services. PixelFix's test case resets several parts of the application runtime, but a test can still introduce state that other tests observe. Ensure the test arranges the state it needs and cleans up what it creates.

## CI recommendation

A useful CI job should install the project's Composer dependencies, enable the needed PHP extensions, run syntax checks, execute focused tests during development, then run the complete test suite. Keep the database services/driver explicit in CI configuration; do not interpret tests skipped or blocked by an unavailable driver as passing database verification.

Related reading: [Testing Overview](overview.md), [Unit Tests](unit-tests.md), [Integration Tests](integration-tests.md), [Feature Tests](feature-tests.md), [Database Testing](database-testing.md), and [Testing Real Workflows](../guides/testing-real-workflows.md).
