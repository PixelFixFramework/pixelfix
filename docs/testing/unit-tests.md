# Unit Tests

Unit tests isolate a framework class or small set of collaborators and are commonly placed under `tests/Unit`.

## Basic structure

```php
namespace Tests\Unit\Example;

use PixelFix\Framework\Testing\TestCase;

class ExampleTest extends TestCase
{
    public function testValueIsCorrect(): void
    {
        $this->assertSame(
            2,
            1 + 1
        );
    }
}
```

Use the unit layer for behavior that can be tested without booting the full HTTP or database stack.

## Exception testing

The assertion API includes helpers for expected exception messages and codes. Prefer testing the observable exception contract rather than implementation details.

```php
$this->expectException(RuntimeException::class);
$this->expectExceptionMessage('Invalid configuration');

$service->run();
```

Or use the assertion helper when the test should remain a single expression:

```php
$this->assertThrows(
    fn () => $service->run(),
    'Invalid configuration'
);
```

## Temporary resources

`TestCase` can create temporary directories that are automatically removed during teardown. This is useful for filesystem and generator tests.

The same base class can capture output from a callback with `captureOutput()` and create in-memory streams with `createMemoryStream()`.
