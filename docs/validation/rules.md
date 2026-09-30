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
