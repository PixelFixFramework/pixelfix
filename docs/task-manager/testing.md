# Task Manager Testing

The Task Manager includes the application-level test bootstrap and runner supplied by PixelFix, but the uploaded reference application currently contains no discovered test classes.

## Test bootstrap

`tests/bootstrap.php` defines `BASE_PATH`, loads Composer autoloading, boots the application, and registers the application's container globally.

## Application test case

`tests/TestCase.php` extends:

```php
PixelFix\Framework\Testing\TestCase
```

This gives application tests access to the framework testing foundation without replacing the framework test case.

## Test runner

The application includes `tests/run.php`, which discovers PHP test classes extending the framework `TestCase` and runs them through `PixelFix\Framework\Testing\TestRunner`.

Supported command-line filters include:

```bash
php tests/run.php
php tests/run.php --dir=tests/Feature
php tests/run.php --filter=SomeTest
php tests/run.php --exclude=Fixtures
```

## Current reference-app state

A live run of the uploaded Task Manager currently reports:

```text
Total: 0
Passed: 0
Failed: 0
```

That is an accurate statement about the uploaded proof-of-concept at this documentation snapshot. The framework itself has its own test suite and testing documentation; application-specific tests can be added to the Task Manager as the reference application continues to mature.

## Recommended application tests

As features are added, the Task Manager should eventually protect its public behavior with tests for authentication flows, task authorization, task CRUD, validation failures, and important database behavior. Those should test the application's behavior rather than duplicate the framework's internal unit tests.
