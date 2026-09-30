# Task Manager: Validation

The Task Manager uses Form Requests for user-submitted data.

```text
app/Http/Requests/
├── LoginRequest.php
├── RegisterUserRequest.php
├── StoreTaskRequest.php
├── UpdateTaskRequest.php
├── StoreUserRequest.php
└── UpdateUserRequest.php
```

## StoreTaskRequest

The task creation request defines:

```php
public function authorize(): bool
{
    return auth()->check();
}
```

and:

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

Custom messages are supplied for the fields where the application wants clearer user-facing text.

## Controller integration

The controller type-hints the request:

```php
public function store(
    StoreTaskRequest $request
)
```

The validated payload is then retrieved with:

```php
$data = $request->validated();
```

The controller does not persist `request()->all()` directly.

## Edit and update

`UpdateTaskRequest` provides the corresponding validation boundary for updates. Before persistence, `TaskController::update()` removes `user_id` from the validated data so that an update cannot change task ownership through request input.

## Forms

The create view uses the framework Twig helpers for route generation and CSRF protection:

```twig
<form method="POST" action="{{ route('tasks.store') }}">
    {{ csrf|raw }}
    ...
</form>
```

Validation state is made available back to the view through the framework's session-backed error and old-input helpers.
