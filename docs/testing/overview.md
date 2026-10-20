# Testing

PixelFix ships with its own lightweight testing layer. The framework test suite uses `PixelFix\Framework\Testing\TestCase` and a custom `TestRunner`.

PixelFix applications use the framework's native testing layer and custom test runner. The built-in runner is the canonical runner used by the framework's own `tests/run.php` script.

## Test organization

The framework repository currently organizes tests into areas including:

```text
Tests/
├── Feature/
├── Foundation/
├── Integration/
├── Runtime/
└── Unit/
```

The exact directory boundaries are a project convention; the test runner discovers PHP test classes recursively.

## Test classes

Test classes extend:

```text
PixelFix\Framework\Testing\TestCase
```

and test methods are discovered when their names begin with `test`.

```php
class TaskTest extends TestCase
{
    public function testTaskCanBeCreated(): void
    {
        $this->assertTrue(true);
    }
}
```

Each test method is executed on a fresh instance.

## Assertions

The framework assertion trait provides common assertions for values, strings, types, arrays, files, directories, comparisons, and exception expectations. Use the assertion that expresses the behavior you want to verify:

```php
$this->assertTrue($condition);
$this->assertEquals($expected, $actual);
$this->assertSame($expected, $actual);
$this->assertNull($value);
$this->assertNotNull($value);
$this->assertContains($needle, $haystack);
$this->assertInstanceOf(User::class, $user);
```

Use `assertSame()` when both the value and type must match—for example, integer `1` is not the same type as string `'1'`. `assertEquals()` compares values more loosely. `assertContains()` checks whether a value occurs in an array or supported collection.

To check an exception, set the expected class and, optionally, its exact message **before** invoking the operation:

```php
$this->expectException(\InvalidArgumentException::class);
$this->expectExceptionMessage('Task title is required.');

$service->createTask(['title' => '']);
```

Replace `$service->createTask(...)` with the operation your application expects to reject. The test passes only when the expected exception type and message are thrown; if the operation returns normally, the test fails. PixelFix does not provide an `assertThrows()` assertion.

## Lifecycle isolation

`TestCase` resets routes and framework session state between tests and removes temporary directories registered during a test. This is important for tests that interact with the global application container or session layer.

See the focused testing guides for runner usage and database testing.
