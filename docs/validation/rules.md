# Validation Rules

PixelFix includes a set of built-in validation rules and supports rule objects through the validation contracts.

## Common rules

The current framework includes rules for:

| Category | Rules |
|---|---|
| Presence/type | `required`, `nullable`, `string`, `integer`, `numeric`, `boolean`, `array` |
| Text/content | `alpha`, `alpha_num`, `regex` |
| Values | `in`, `not_in`, `same`, `different`, `confirmed` |
| Size | `min`, `max` |
| Date | `date`, `date_format` |
| Database | `exists`, `unique` |
| Files | `file`, `image`, `mime`, `max_file_size` |
| Conditional | `required_if`, `bail` |

Rule names are parsed by PixelFix's rule parser.

## Example

```php
public function rules(): array
{
    return [
        'title' => [
            'required',
            'string',
            'max:255',
        ],

        'status' => [
            'required',
            'in:pending,in_progress,completed',
        ],

        'due_date' => [
            'nullable',
            'date',
        ],
    ];
}
```

This is the pattern used by the Task Manager's `StoreTaskRequest`.

## Validation outside FormRequest

For simple validation, use the global helper:

```php
$data = validate(
    $input,
    [
        'email' => ['required', 'email'],
    ]
);
```

The helper delegates to the framework validator and returns the validated payload or raises the normal validation failure.

## Custom rule objects

The validation package contains a `RuleInterface` contract for rule objects. Use a rule object when a validation condition is domain-specific or cannot be expressed clearly with the built-in string rules.


## Read a validation rule as a requirement

For example, `required|string|max:120` says the value must be supplied, must be a string, and must not exceed the allowed length. Combining rules expresses the conditions an input must satisfy before the controller trusts it. A rule failure should result in a validation response or error bag; it should not allow invalid data to be saved.

Validation is different from authorization. A valid `user_id` can still belong to another user, so it may be syntactically valid but not authorized. Validate data shape first, then enforce ownership and permission where the action requires it.

When adding a rule, test one valid value and at least one invalid value. For boundaries such as maximum length, test the largest accepted value and the next value beyond it. This catches mistakes that a happy-path-only test will miss.
