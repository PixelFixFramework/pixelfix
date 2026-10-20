# Exceptions and Error Responses

An exception tells PixelFix that an operation could not continue normally. During a web request, the framework's exception handler converts supported exceptions into HTTP responses. The right response helps the client understand whether to correct input, sign in, request permission, choose another URL, or report a server problem.

## Return a not-found or forbidden response

Use `abort()` when the current handler knows that the request cannot continue:

```php
use App\Models\Task;
use PixelFix\Framework\Routing\Route;

Route::get('/tasks/{id}', function (string $id) {
    $task = Task::find($id);

    if ($task === null) {
        abort(404, 'Task not found.');
    }

    if ((string) $task->user_id !== (string) auth()->id()) {
        abort(403, 'You are not allowed to view this task.');
    }

    return view('tasks/show', ['task' => $task]);
})->middleware('auth');
```

`abort(404, ...)` throws an HTTP exception with status 404; it does not return a response from the line where it is called. Execution stops at that point and control moves to the framework's exception handling. `403` means the requested operation is forbidden. Choose the status that matches the situation instead of returning `200 OK` for an error.

PixelFix also provides conditional helpers:

```php
abort_if($task === null, 404, 'Task not found.');
abort_unless(auth()->check(), 401, 'Please sign in.');
```

`abort_if()` throws only when the condition is true. `abort_unless()` throws when the condition is false.

## Common error categories

- **Validation failure:** the submitted values do not satisfy the rules. Browser form flows can redirect back with validation errors; API flows should return an API-appropriate response.
- **CSRF failure:** a protected browser form did not submit a valid CSRF token.
- **Authentication failure:** the client is not signed in or has not presented valid credentials (often 401 for APIs or a redirect for browser forms).
- **Authorization failure:** the client is known, but is not allowed to perform the operation (403 is commonly appropriate).
- **Not found:** the requested route, model, or resource does not exist or is intentionally hidden (404).
- **Unexpected exception:** a programming error or infrastructure issue prevented the operation from completing (usually a 500 response).

Different cases should not all be converted into success responses. A validation problem needs different handling from a missing record or an unexpected programming error.

## When to catch an exception

Catch an exception only when the current layer can recover, add useful context, or translate the failure into a meaningful application response. Avoid swallowing every exception and then returning success:

```php
try {
    $task->save();
} catch (\RuntimeException $exception) {
    // Perform operation-specific cleanup if it is needed.
    throw $exception;
}
```

This catch block is useful only if your application has something specific to do before rethrowing—for example, undoing a related external operation. If you cannot recover, add useful context, or translate the exception into a meaningful response, let it reach the framework's exception handler. Use a narrower exception type when you know which failure you are handling. Never log passwords, session cookies, bearer tokens, or other secrets.

## Debug mode and production safety

Debug output is useful locally because it can show the exception type, message, and stack trace. In production, detailed error pages may expose filesystem paths, SQL queries, configuration values, or secrets. Keep debug mode disabled in production and log enough detail for operators to investigate without exposing sensitive information to the browser.

## Troubleshoot a 500 response

1. Check the application's configured log location under `storage/`.
2. Read the exception type and message and locate the first stack-trace entry from your application code.
3. Confirm the referenced route, controller, model, configuration key, or template exists.
4. Reproduce the request with the smallest possible input.
5. Fix the underlying cause and add a test for the failure so it does not return later.

Related topics: [Routing](../http/routing.md), [Validation](../validation/overview.md), [CSRF Protection](../http/csrf.md), and [Troubleshooting](../reference/troubleshooting.md).
