# Custom Validation Rules

A custom rule expresses a domain-specific requirement that is not clear or reusable as a built-in rule. For example, a task code might need to follow a format such as `OPS-1234`. PixelFix accepts rule objects that implement `RuleInterface`.

## 1. Check whether a built-in rule is enough

Use built-in rules for common requirements such as `required`, `email`, `integer`, `date`, `min`, `max`, `unique`, or `exists`. Create a custom rule when the condition represents your application's own vocabulary or needs a clearer reusable name.

## 2. Implement the rule contract

Create a class that implements `PixelFix\Framework\Validation\Contracts\RuleInterface`:

```php
<?php

namespace App\Validation\Rules;

use PixelFix\Framework\Validation\Contracts\RuleInterface;

final class TaskCodeRule implements RuleInterface
{
    public function validate(
        string $field,
        mixed $value,
        array $data = []
    ): bool {
        return is_string($value)
            && preg_match('/^[A-Z]{3}-[0-9]{4}$/', $value) === 1;
    }

    public function message(string $field): string
    {
        return "{$field} must use the format ABC-1234.";
    }
}
```

`validate()` receives the field name, the candidate value, and all submitted data. It must return `true` when the value is accepted and `false` when it is rejected. `message()` returns the message to show when the rule fails. It should not write to the database or perform unrelated business operations.

The regular expression in this example accepts three uppercase letters, a hyphen, and four digits—for example `OPS-1042`. It rejects `ops-1042`, `OPS1042`, and `OPS-12`.

## 3. Use the rule in a Form Request

```php
use App\Validation\Rules\TaskCodeRule;
use PixelFix\Framework\Http\Requests\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'task_code' => [
                'required',
                new TaskCodeRule(),
            ],
        ];
    }
}
```

PixelFix supports a mixture of built-in string rules and instantiated rule objects in the array for a field. The controller should consume `$request->validated()` after the request has passed validation, instead of persisting the entire raw request body.

## 4. Test both outcomes

Create tests for at least one value that should pass and one that should fail:

```php
$rule = new TaskCodeRule();

$rule->validate('task_code', 'OPS-1042'); // true
$rule->validate('task_code', 'ops-1042'); // false
```

A complete test should assert the return value, and for validation failures it should also verify that the expected message is attached to the field. Test boundary cases and empty values if the field can be optional. Combine `nullable` with a custom rule when an absent value is allowed; custom rules should handle ordinary invalid user input by returning `false`, not by throwing an exception.
