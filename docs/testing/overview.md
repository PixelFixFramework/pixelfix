# Testing

PixelFix ships with its own lightweight, framework-native testing layer.
The application test suite uses
`PixelFix\\Framework\\Testing\\TestCase`, `TestSuite`, and `TestRunner`
to discover, organize, execute, and report tests.

The application's `tests/run.php` script is the canonical entry point
for running the test suite.

## Test Organization

The application organizes tests into areas including:

``` text
Tests/
├── Feature/
├── Foundation/
├── Integration/
├── Runtime/
└── Unit/
```

The exact directory boundaries are a project convention. The test runner
recursively discovers PHP test classes within the test directories.

## Running Tests

The application's complete test suite can be executed using:

``` bash
php tests/run.php
```

The application also provides the following Composer command:

``` bash
composer test
```

The `composer test` command invokes the same native PixelFix test
runner.

## Running a Specific Test Directory

The test runner supports directory filtering, allowing tests within a
specific directory to be executed.

For example, to run the unit tests:

``` bash
php tests/run.php --dir=tests/Unit
```

To run integration tests:

``` bash
php tests/run.php --dir=tests/Integration
```

To run database unit tests:

``` bash
php tests/run.php --dir=tests/Unit/Database
```

Directory filtering is useful when developing or debugging a specific
area of the application without running the complete test suite.

## Filtering Tests

The test runner supports filtering tests by name.

For example:

``` bash
php tests/run.php --filter=Database
```

Filtering is useful when working on a particular feature, class,
subsystem, or group of related tests.

## Test Classes

Test classes extend:

``` php
PixelFix\\Framework\\Testing\\TestCase
```

Test methods are discovered when their names begin with `test`.

For example:

``` php
<?php

namespace Tests\\Unit;

use PixelFix\\Framework\\Testing\\TestCase;

class TaskTest extends TestCase
{
    public function testTaskCanBeCreated(): void
    {
        $this->assertTrue(true);
    }
}
```

Each test method is executed using a fresh test case instance.

This helps prevent state created by one test from affecting another
test.

## Assertions

The PixelFix testing layer provides assertions for values, strings,
types, arrays, files, directories, comparisons, and exception
expectations.

Common assertions include:

``` php
$this->assertTrue($condition);

$this->assertFalse($condition);

$this->assertEquals(
    $expected,
    $actual
);

$this->assertSame(
    $expected,
    $actual
);

$this->assertNull(
    $value
);

$this->assertNotNull(
    $value
);

$this->assertContains(
    $needle,
    $haystack
);

$this->assertStringContainsString(
    $needle,
    $actual
);

$this->assertInstanceOf(
    User::class,
    $user
);

$this->assertCount(
    $expectedCount,
    $items
);
```

Exceptions can be tested using:

``` php
$this->assertThrows(
    fn () => $service->run(),
    'expected message'
);
```

These assertions allow application tests to verify expected behaviour
using the native PixelFix testing layer.

## Test Lifecycle and Isolation

`TestCase` provides lifecycle handling around individual tests.

Framework state such as routes and session data is reset between tests,
while temporary directories registered during a test can also be removed
during cleanup.

This is important for tests that interact with shared framework state
such as:

-   the application container;
-   routing;
-   sessions;
-   temporary files and directories;
-   database-related services; and
-   other shared application state.

Test isolation reduces the possibility of one test affecting the result
of another test.

## Test Discovery

The native test runner recursively discovers PHP test classes within the
configured test directories.

A test class should:

1.  Be a PHP class.
2.  Extend `PixelFix\\Framework\\Testing\\TestCase`.
3.  Not be abstract.
4.  Contain test methods whose names begin with `test`.

For example:

``` php
<?php

namespace Tests\\Feature;

use PixelFix\\Framework\\Testing\\TestCase;

class TaskTest extends TestCase
{
    public function testTaskCanBeCreated(): void
    {
        $this->assertTrue(true);
    }

    public function testTaskHasATitle(): void
    {
        $task = [
            'title' => 'Complete documentation',
        ];

        $this->assertSame(
            'Complete documentation',
            $task['title']
        );
    }
}
```

There is no need to manually register individual test classes with the
runner.

## Test Suite

`PixelFix\\Framework\\Testing\\TestSuite` manages the collection of test
cases that are executed during a test run.

The test suite provides the structure required to group discovered test
cases before they are passed to the test runner.

This separation keeps test collection and test execution
responsibilities distinct.

## Test Runner

`PixelFix\\Framework\\Testing\\TestRunner` is responsible for executing
the discovered test suite.

The runner works with `TestSuite` to:

1.  Discover eligible test classes.
2.  Instantiate test cases.
3.  Execute individual test methods.
4.  Capture test results.
5.  Report passed and failed tests.
6.  Produce the final test summary.

The native runner also supports options such as directory selection and
test filtering.

## TestCase

`PixelFix\\Framework\\Testing\\TestCase` is the base class for
application tests.

It provides access to the framework's assertion methods and manages the
lifecycle concerns required to keep individual tests isolated.

Application tests should normally extend `TestCase` rather than
implementing their own assertion and lifecycle infrastructure.

## Writing Tests

When adding a new test:

1.  Place the test in the appropriate directory under `tests/`.
2.  Extend `PixelFix\\Framework\\Testing\\TestCase`.
3.  Give test methods names beginning with `test`.
4.  Use the available PixelFix assertions to verify expected behaviour.
5.  Run the focused test or test directory while developing.
6.  Run the complete test suite before committing changes.

For example:

``` php
<?php

namespace Tests\\Feature;

use PixelFix\\Framework\\Testing\\TestCase;

class TaskTest extends TestCase
{
    public function testTaskCanBeCreated(): void
    {
        $task = [
            'title' => 'Complete documentation',
        ];

        $this->assertSame(
            'Complete documentation',
            $task['title']
        );
    }
}
```

## Recommended Testing Workflow

A typical development workflow is:

``` text
1. Create or modify the application code.
2. Create or update the corresponding test.
3. Run the focused test or test directory.
4. Fix any failures.
5. Run the complete test suite.
6. Confirm that all tests pass.
7. Commit the application changes.
```

For example, after modifying database functionality:

``` bash
php tests/run.php --dir=tests/Unit/Database
```

After the focused tests pass, run the complete suite:

``` bash
php tests/run.php
```

The native PixelFix testing layer is the standard testing mechanism for
the application and its framework components.
