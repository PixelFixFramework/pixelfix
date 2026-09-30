# Form Requests

Form Requests combine request data, authorization, validation rules, custom messages, and lifecycle hooks into a dedicated request class.

The base class is `PixelFix\\Framework\\Http\\Requests\\FormRequest`.

## Creating a Form Request

Use the generator:

```bash
php pixelfix make:request StoreTaskRequest
```

The generated application convention places requests under `app/Http/Requests`.

A Form Request must define `rules()`:

```php
namespace App\Http\Requests;

use PixelFix\Framework\Http\Requests\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
        ];
    }
}
```

## Authorization

Override `authorize()` when the request should only be accepted for authorized callers:

```php
public function authorize(): bool
{
    return auth()->check();
}
```

When `authorize()` returns `false`, `FormRequest` throws `AuthorizationException` before the validation rules are executed.

Authorization at this level is useful for a request-wide access condition. More specific object-level permissions can be checked with a policy in the controller.

## Validation rules

A Form Request can return string rules or rule objects:

```php
public function rules(): array
{
    return [
        'title' => 'required|string|max:255',
        'status' => 'required|in:pending,in_progress,completed',
        'due_date' => 'required|date',
    ];
}
```

The built-in rule parser supports rules including:

```text
required
required_if
nullable
bail
string
email
integer
numeric
boolean
array
alpha
alpha_num
confirmed
same
different
in
not_in
min
max
regex
date
date_format
file
image
mime
max_file_size
exists
unique
```

The exact parameter syntax should be checked against the rule implementation when using database-backed or file-specific rules.

## Custom messages

Override `messages()` to provide field-and-rule-specific messages:

```php
public function messages(): array
{
    return [
        'title.required' =>
            'Task title is required.',

        'title.max' =>
            'Task title may not exceed 255 characters.',
    ];
}
```

## Validation lifecycle

When a Form Request is validated, PixelFix follows this sequence:

```text
Base Request
    ↓
Create FormRequest instance
    ↓
Copy normalized input
    ↓
Copy route parameters
    ↓
prepareForValidation()
    ↓
authorize()
    ↓
rules() + messages()
    ↓
Validator::validate()
    ↓
passedValidation()
    ↓
Validated FormRequest
```

This order matters. Authorization runs before validation; `passedValidation()` only runs when validation succeeds.

## Preparing input

Override `prepareForValidation()` when input needs normalization before rules run:

```php
protected function prepareForValidation(): void
{
    $this->merge([
        'name' => strtoupper(
            $this->input('name')
        ),
    ]);
}
```

Because the base request's input is copied into the Form Request first, request methods such as `input()`, `all()`, and `route()` work with the inherited request state.

## Accessing validated data

After validation, use `validated()` rather than reading raw input for fields that the action is going to persist:

```php
$data = $request->validated();
```

A single validated key can be read with a default:

```php
$title = $request->validated(
    'title',
    ''
);
```

`payload()` is an alias for `validated()`, and `safe()` returns the validated array.

## Checking validated keys

Use `hasValidated()` to test whether a key exists in the validated payload:

```php
if ($request->hasValidated('status')) {
    // ...
}
```

## Route parameters

Form Requests inherit the route parameter bag from the base request:

```php
$id = $request->route('id');
```

This allows validation or authorization logic to incorporate a route resource identifier.

## Validation failures

The underlying `Validator` throws `ValidationException` when validation fails. The exception contains:

- the field error messages;
- the original input used during validation;
- the HTTP status code `422`.

The framework's HTTP exception handling can expose validation state to browser responses, while the helper functions and Twig globals make the error bag and old input available to views.

## Task Manager example

The Task Manager uses dedicated requests for task creation and update. `StoreTaskRequest` currently requires:

```php
[
    'title' => 'required|string|max:255',
    'description' => 'required|string',
    'status' => 'required|in:pending,in_progress,completed',
    'due_date' => 'required|date',
]
```

Its `authorize()` method requires an authenticated user:

```php
public function authorize(): bool
{
    return auth()->check();
}
```

The controller therefore receives a request that has already passed the request-level authorization and validation lifecycle:

```php
public function store(
    StoreTaskRequest $request
) {
    $data = $request->validated();

    // Persist only validated data.
}
```
