# HTTP Responses

PixelFix provides response classes and global helpers for common HTTP response types.

## HTML responses

A rendered view normally produces an HTML response:

```php
return view('tasks/index', [
    'tasks' => $tasks,
]);
```

Controllers can also return an `HtmlResponse` directly when they need to manage rendered content explicitly.

## JSON responses

Use the `json()` helper for API responses:

```php
return json([
    'message' => 'Task created successfully.',
    'task' => $task,
]);
```

A status code can be supplied:

```php
return json([
    'message' => 'Unauthenticated.',
], 401);
```

## Redirects

PixelFix supports redirects to paths, URLs, or named routes:

```php
return redirect('/tasks/index');

return redirect_to_route('tasks.index');
```

For route parameters:

```php
return redirect_to_route(
    'tasks.show',
    [$task->id]
);
```

`redirect_back()` uses the request referer when it is suitable and otherwise falls back to the supplied path.

## Flashing response data

Redirect responses can carry flash data such as errors and old input. The response API also exposes `withErrors()`, `withSuccess()`, `withError()`, and `withInput()`.

The framework's validation helpers use the same session-backed mechanism, which lets a redirected form display the previous input and validation messages.

## Other response types

The response factory also exposes methods for files, downloads, streamed responses, and no-content responses. Choose the response type based on the HTTP contract of the endpoint rather than returning HTML for an API operation.
