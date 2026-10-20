# Validation: Check User Input Before Using It

Validation determines whether data sent by a browser or API client satisfies the rules your application requires. It is different from authorization: validation asks “is this input acceptable?”, while authorization asks “is this user allowed to do this?” A valid title does not prove that the current user may update a particular task.

## Validate an array directly

Use the `validate()` helper when a few rules are all you need:

```php
$validated = validate(
    $input,
    [
        'email' => 'required|email',
        'name' => 'required|string|max:255',
    ]
);
```

`$input` is the data to check, usually from a request. The return value is an array of accepted fields covered by the rules. If validation fails, the validation flow throws a `ValidationException`; in a browser request, the framework's configured handling typically redirects back with errors and old input. For an API request, use the API/JSON error flow appropriate to your application.

The direct API is also available through the `Validator` class:

```php
use PixelFix\Framework\Validation\Validator;

$validated = Validator::make($input, $rules)->validate();
```

`passes()` returns `true` when all rules pass; `fails()` returns `true` when any rule fails. `validationErrors()` returns the collected validation error data so you can inspect which fields failed. `validate()` returns the validated payload on success and throws when it cannot validate the input.

## Why the validated payload matters

Prefer `$validated` or `$request->validated()` over writing `request()->all()` directly into a model. The request may contain extra fields the form was never supposed to control, including an owner ID or role. Validating a field does not automatically make every other request field safe to persist.

## Use a Form Request for a reusable feature

A Form Request keeps authorization, rules, and custom messages next to one use case. For example, `StoreTaskRequest` can require a title, constrain status to known values, and authorize only a signed-in user. The controller receives the typed request and calls `$request->validated()` before creating the model. See [Form Requests](requests.md).

## Rules and common meanings

- `required`: the field must be present and non-empty.
- `string`: the value must be text.
- `email`: the value must have a valid email-like format.
- `max:255`: limit a text value to 255 characters.
- `in:pending,completed`: accept only one of the listed values.
- `nullable`: allow the field to be empty; it is different from `required`.

The complete supported rule set and parameters are documented in [Validation Rules](rules.md). For a rule that cannot be expressed with built-in rules, implement a [Custom Rule](custom-rules.md).

## Showing browser validation errors

After the browser validation flow redirects back, PixelFix exposes helpers such as `old('email')`, `errors()`, `error('email')`, and `has_error('email')`. Use `old()` to prefill the user's previous entry and `error()` to show a field-specific message. Never echo user input into HTML without normal output escaping.
