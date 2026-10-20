# Task Manager Validation: Reject Bad Input Before Saving

Validation checks whether submitted data has an acceptable shape and value. In the Task Manager, `StoreTaskRequest` and `UpdateTaskRequest` extend PixelFix's `FormRequest`, so the controller receives a validated request rather than trusting arbitrary browser input.

## Rules for creating a task

The create request requires a title, description, status, and due date:

```php
public function rules(): array
{
    return [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'status' => 'required|in:pending,in_progress,completed',
        'due_date' => 'required|date',
    ];
}
```

Read each rule as a condition:

- `required` means the field must be present and non-empty.
- `string` means the value must be text.
- `max:255` limits the title length to 255 characters.
- `in:...` restricts status to one of the listed values.
- `date` checks that the value can be interpreted as a date.

The update request differs: description and due date may be `nullable`, meaning the user may leave them empty; title and status remain required. `nullable` is not the same as `required` and should be chosen according to the form's intended behavior.

## Authorization is a separate decision

The request's `authorize()` method returns `auth()->check()`. It verifies that a user is signed in; it does not decide which task they own. `TaskPolicy` handles the record-specific decision later in the controller.

## Use only the validated payload

The controller type-hints the request:

```php
public function store(StoreTaskRequest $request)
{
    $data = $request->validated();
    // Continue with trusted, validated fields.
}
```

`validated()` returns an array containing fields defined by the request's rules and accepted by validation. If validation fails, the normal form-request flow prevents the action from proceeding and returns the browser through the validation-error flow.

The controller then adds ownership itself:

```php
$user = auth()->user();
$data['user_id'] = $user->id;
$data['status'] = $data['status'] ?? 'pending';

Task::create($data);
```

This is important: `user_id` is not accepted from the submitted form. If a request could choose an arbitrary `user_id`, a user could attempt to create a task owned by someone else.

## Show errors and retain safe input

The framework makes validation errors and old input available after the browser flow redirects back. The Task Manager's Twig templates use field-level error components and old-input helpers to explain which field needs attention and repopulate safe form values.

For a form to work, it must submit the expected names (`title`, `description`, `status`, `due_date`), use the correct HTTP method, include the CSRF field (`{{ csrf|raw }}`), and point to the named route.

See [Form Requests](../validation/requests.md), [Validation Rules](../validation/rules.md), and [CSRF Protection](../http/csrf.md).
