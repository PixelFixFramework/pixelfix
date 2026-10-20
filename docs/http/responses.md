# HTTP Responses

A **response** is the result PixelFix sends to the browser or API client after a route or controller action runs. The response contains a body (the returned content), an HTTP status code, and headers. Choose the response type that matches what the caller expects: HTML for a page, JSON for data, a redirect after a browser form submission, or a file/download when returning a file.

## Return a rendered view

For a server-rendered page, use `view()`:

```php
return view('tasks/index', [
    'tasks' => $tasks,
]);
```

This renders `resources/views/tasks/index.twig`. The `tasks` array key becomes the Twig variable `tasks`, so the template can loop over it. A view response normally has status `200` and an HTML content type.

## Return JSON

Use `response()->json()` when an endpoint is meant to return data to JavaScript, Postman, a mobile app, or another API client:

```php
return response()->json($users);
```

The `json()` method returns a `JsonResponse`. It encodes the supplied value as JSON and sets `Content-Type` to `application/json; charset=UTF-8` unless you explicitly provide a content-type header. The default status is `200`.

For example, a route that lists users can be written as:

```php
use App\Models\User;
use PixelFix\Framework\Routing\Route;

Route::get('/users', function () {
    $users = User::all();

    return response()->json($users);
});
```

`User::all()` fetches the records; `response()->json($users)` declares that the response body is JSON. For a complete walkthrough—including response examples, status codes, and testing—read [Returning JSON from a Route or Controller](json-responses.md).

You may return a simple list, a single object, or a structured object:

```php
return response()->json([
    'success' => true,
    'data' => $users,
    'meta' => [
        'count' => $users->count(),
    ],
]);
```

Only include fields that the caller is allowed to see. For a stable public API shape, use a [JSON resource](../api/resources.md) instead of exposing whole model objects by default.

### Set a status code

The method signature is:

```php
response()->json($data, $status = 200, $headers = []);
```

For example, return `201 Created` after saving a new record:

```php
return response()->json([
    'message' => 'Task created successfully.',
    'data' => ['id' => $task->id],
], 201);
```

Return a not-found response when the requested record is absent:

```php
return response()->json([
    'message' => 'Task not found.',
], 404);
```

Do not use `201` unless the operation created a resource. Use meaningful status codes so API clients can decide whether a request succeeded.

### Add response headers

Pass an associative array as the third argument:

```php
return response()->json(
    ['data' => $users],
    200,
    ['Cache-Control' => 'no-store']
);
```

Headers can control caching and other HTTP behavior. Set them deliberately; do not add headers you do not understand or need.

## The `json()` helper and automatic response conversion

PixelFix also provides the shorter global helper:

```php
return json($users);
```

It creates the same type of JSON response as `response()->json($users)`. PixelFix also normalizes certain returned values automatically: arrays, JSON-serializable models/resources, and iterable collections are converted to JSON responses by the response factory. For instance, returning `User::all()` normally results in JSON because the collection supports JSON serialization.

Explicit `response()->json(...)` is still recommended for API handlers because the response type, status code, and headers are visible in the code. A plain string is treated as HTML, not JSON.

## Redirect after a form submission

After a browser form successfully changes data, redirect to a page rather than rendering a duplicate submission result:

```php
return redirect_to_route('tasks.index')
    ->withSuccess('Task created successfully.');
```

The redirect tells the browser to make a new request to the destination. This Post/Redirect/Get pattern helps prevent a page refresh from submitting the same form again. The flash message is stored for the next request and can be shown by the layout's flash-message component.

Use a named route where possible. If the route's URI changes, the name can remain stable and your redirect code need not change.

## Return an empty response

When an operation succeeds but there is no response body to send, use:

```php
return response()->noContent();
```

The default status is `204 No Content`. A `204` response should not contain a success message or other body. Use JSON instead if the client needs data about the result.

## Return a file or download

```php
return response()->file($path);

return response()->download($path, 'report.csv');
```

`file()` returns a file for inline viewing when the response type and browser support it. `download()` asks the client to download the file, optionally with the supplied filename. Validate the path and authorize access before returning a file; never pass an untrusted path directly from the request.

## Streams

Use a streamed response when content should be emitted by a callback rather than assembled as one complete string first:

```php
return response()->stream(function () {
    echo "first chunk\n";
    echo "second chunk\n";
});
```

The callback is responsible for producing the response content. Streaming is useful for large or generated output, but ordinary HTML pages and JSON objects are usually clearer with `view()` or `json()`.

## Which response should I choose?

| Goal | Use | Why |
|---|---|---|
| Display a Twig page | `view()` | Renders HTML with view data. |
| Send data to an API client | `response()->json()` | Produces JSON with an explicit status and headers. |
| Finish a browser form action | `redirect_to_route()` | Sends the browser to another page and can carry flash data. |
| Confirm an operation with no body | `response()->noContent()` | Returns a `204` response. |
| Deliver a file | `response()->file()` or `download()` | Uses the file response behavior. |

See [Response Reference](response-reference.md) for the complete factory method list and [Returning JSON from a Route or Controller](json-responses.md) for a practical API example.
