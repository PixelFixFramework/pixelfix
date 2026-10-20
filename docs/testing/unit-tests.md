# Unit Tests

A unit test checks one small unit of behavior, such as a service method or a validation helper. The aim is to find out whether that unit produces the expected result for given inputs without requiring the entire application to handle an HTTP request.

## Example structure

```php
use PixelFix\Framework\Testing\TestCase;

class TaskTitleTest extends TestCase
{
    public function test_title_is_trimmed(): void
    {
        $value = trim('  Write docs  ');

        $this->assertSame('Write docs', $value);
    }
}
```

The test method name begins with `test`, so the runner discovers it. The assertion compares the expected value with the actual result. The small example illustrates the test shape; in a real application, call the application method that performs the behavior rather than testing PHP's `trim()` function itself.

## Assertions

Use `assertSame()` when both value and type should match, `assertEquals()` when value equality is sufficient, `assertTrue()`/`assertFalse()` for boolean results, and `assertNull()`/`assertNotNull()` for missing/present values. Choose the assertion that expresses the requirement, so a failure tells you what was wrong.

## Test exceptions

When an operation should throw, use the test runner's exception assertion and check the expected message or type where appropriate. Do not catch an exception in the test and then silently pass; the test must fail if the expected exception never occurs.

## Temporary resources

If a unit test writes files or creates directories, use the framework's temporary-resource helpers or clean up in teardown. Tests should not leave files that change the outcome of the next test.

## Run tests while developing

From the application root, use the project's test runner. Run the narrowest test first, then the full suite before committing. A focused test makes iteration quicker; the full suite catches interactions with the rest of the application.
