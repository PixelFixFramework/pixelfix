# Validation

PixelFix provides a standalone validator as well as the higher-level Form Request abstraction.

## Quick validation

Use the global `validate()` helper when a dedicated Form Request would add unnecessary structure:

```php
$data = validate(
    $input,
    [
        'email' => 'required|email',
        'name' => 'required|string|max:255',
    ]
);
```

The same operation can be performed directly through `Validator`:

```php
use PixelFix\Framework\Validation\Validator;

$data = Validator::make(
    $input,
    $rules
)->validate();
```

`Validator::check()` is a convenience method that performs validation and returns the validated payload.

## Inspecting validation state

The validator supports:

```php
$validator->passes();
$validator->fails();
$validator->validationErrors();
```

Calling `validate()` throws a `ValidationException` when errors are present.

## Validated payload

The validator returns only fields defined in the rule set and only when they have no validation errors. This makes the validated result suitable for passing into persistence code after any necessary application-specific enrichment.

## Old input and errors

The framework stores validation errors and old input in session state when the HTTP validation flow redirects back to a browser form.

Global helpers expose the state:

```php
old('email');
errors();
error('email');
has_error('email');
```

Twig exposes the same functionality through registered functions:

```twig
{{ old('email') }}
{{ error('email') }}
{% if has_error('email') %}
    ...
{% endif %}
```

Use `old()` to repopulate a form after validation failure and `error()` or `errors()` to display feedback.

## Rule objects

Rules may be provided as strings or instantiated rule objects. The rule parser normalizes both forms and converts built-in string rules into their corresponding rule implementations.

This makes custom rules possible without changing the validator's public entry point.
