# Testing

PixelFix ships with its own lightweight testing layer. The framework test suite uses `PixelFix\Framework\Testing\TestCase` and a custom `TestRunner` rather than requiring PHPUnit for the framework's primary runner.

The package also declares PHPUnit as a development dependency, so both styles can coexist in a project. The built-in runner is the canonical runner used by the framework's own `tests/run.php` script.

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

```php
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

The framework assertion trait provides common assertions for values, strings, types, arrays, files, directories, comparisons, and exception expectations. Examples include:

```php
$this->assertTrue($condition);
$this->assertEquals($expected, $actual);
$this->assertSame($expected, $actual);
$this->assertNull($value);
$this->assertNotNull($value);
$this->assertContains($needle, $haystack);
$this->assertInstanceOf(User::class, $user);
$this->assertThrows(
    fn () => $service->run(),
    'expected message'
);
```

## Lifecycle isolation

`TestCase` resets routes and framework session state between tests and removes temporary directories registered during a test. This is important for tests that interact with the global application container or session layer.

See the focused testing guides for runner usage and database testing.
