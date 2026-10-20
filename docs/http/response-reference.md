# Response Reference

PixelFix route and controller actions return values. The response factory converts those values into HTTP responses, and you can also create a response explicitly when you need to control its type, status code, or headers.

## The response factory

Call the global `response()` helper to obtain `PixelFix\Framework\Http\Responses\ResponseFactory`:

```php
$response = response();
```

Common factory methods are:

| Method | Returns | Use it when |
|---|---|---|
| `make($result)` | `AbstractResponse` | You need to normalize a handler's return value manually. Usually the router does this for you. |
| `json($data, $status = 200, $headers = [])` | `JsonResponse` | Returning JSON data. |
| `html($content = '', $status = 200, $headers = [])` | `HtmlResponse` | Returning an explicit HTML body. |
| `view($view, $data = [], $status = 200, $headers = [])` | `HtmlResponse` | Rendering a Twig view. |
| `file($path, $headers = [])` | `BinaryFileResponse` | Returning a file for inline delivery. |
| `download($path, $name = null, $headers = [])` | `BinaryFileResponse` | Asking the client to download a file. |
| `stream($callback, $status = 200, $headers = [])` | `StreamedResponse` | Producing content with a callback. |
| `noContent($status = 204)` | `HtmlResponse` | Returning a bodyless response. |
| `redirect($url, $status = 302)` | `RedirectResponse` | Redirecting to a path, full URL, or supported named destination. |
| `redirectIntended($default = '/')` | `RedirectResponse` | Returning to a stored intended destination after authentication. |

## JSON responses

```php
return response()->json($data);
```

The defaults are status `200` and content type `application/json; charset=UTF-8`. Pass a status code when the normal success status does not describe the result, and pass headers as the third argument:

```php
return response()->json(
    ['message' => 'Created.', 'data' => $user],
    201,
    ['Cache-Control' => 'no-store']
);
```

The `json()` global helper is a shorthand for creating a `JsonResponse`:

```php
return json(['message' => 'OK']);
```

Do not call `json_encode()` and echo the result from a route. Returning a PixelFix response lets the framework send the body, status, and headers as part of its normal response lifecycle. See [JSON Responses](json-responses.md) for complete route examples, error handling, and testing.

## HTML and view responses

Use `view()` for a Twig template:

```php
return response()->view('tasks/show', [
    'task' => $task,
]);
```

This is equivalent in purpose to the global `view()` helper. Use `html()` when you already have the HTML string and do not need Twig rendering:

```php
return response()->html('<h1>Ready</h1>', 200);
```

HTML responses use `text/html; charset=UTF-8` by default.

## Redirect responses

```php
return response()->redirect('/tasks');
```

For application code, the redirect helpers can also target named routes:

```php
return redirect_to_route('tasks.show', [$task->id]);
```

Use `redirectIntended('/')` or the `redirect_intended('/')` helper when the authentication workflow has stored an intended URL. The default path is used when there is no suitable intended destination.

Redirect flash methods include `with()`, `withErrors()`, `withSuccess()`, `withError()`, and `withInput()`. They store values in session-backed flash state for a subsequent request; a template can then display those values.

## File and stream responses

```php
return response()->file($path);
return response()->download($path, 'report.csv');
return response()->stream(function () {
    echo "generated content";
});
```

Authorize file access and validate paths before calling `file()` or `download()`. A stream callback must produce the response body itself.

## Automatic response conversion

The dispatcher uses the response factory to normalize a handler's return value. If a handler returns an existing `AbstractResponse`, PixelFix uses it. It also converts API resources, JSON-serializable objects, iterable collections, arrays, and scalar boolean/numeric values into JSON responses. Returning `null` creates a `204 No Content` response, while strings are returned as HTML.

This means the following often works:

```php
Route::get('/users', function () {
    return User::all();
});
```

`User::all()` returns a JSON-serializable collection. Nevertheless, `return response()->json(User::all())` is clearer when you are writing an API endpoint and need an explicit status or headers.

## Response objects

Concrete response classes expose their HTTP status and headers through the common response contract. `JsonResponse` also provides `data()`, `getData()`, and `options()` for adjusting the payload or JSON encoding flags before sending the response. Encoding uses `JSON_THROW_ON_ERROR`; when encoding fails at send time, the response changes to status `500` and returns an error payload.
