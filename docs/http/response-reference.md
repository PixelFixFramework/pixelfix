# Response Reference

PixelFix applications can return framework response objects directly or use the response helpers.

## Response factory

`PixelFix\\Framework\\Http\\Responses\\ResponseFactory` exposes:

```text
make()
json()
html()
view()
file()
download()
stream()
noContent()
redirect()
redirectIntended()
```

The common helper is:

```php
return response()->json($data, 200);
```

For normal MVC pages, `view()` is usually the clearest form:

```php
return view('tasks/index', [
    'tasks' => $tasks,
]);
```

## JSON responses

```php
return json([
    'message' => 'Task created.',
], 201);
```

`JsonResponse` uses JSON encoding with Unicode and slash escaping disabled and keeps `JSON_THROW_ON_ERROR` enabled. The default content type is:

```text
application/json; charset=UTF-8
```

You may replace the data or encoding options on the response object when needed.

## HTML responses

```php
return response()->html(
    '<h1>Hello</h1>',
    200
);
```

`HtmlResponse` defaults to:

```text
text/html; charset=UTF-8
```

It also supports `content()`, `append()`, and `prepend()` for response construction.

## Views

The `view()` helper returns an `HtmlResponse` containing the rendered Twig output:

```php
return view('tasks/show', [
    'task' => $task,
]);
```

The response factory provides the same operation explicitly:

```php
return response()->view(
    'tasks/show',
    ['task' => $task]
);
```

## Redirects

Redirect responses are created with:

```php
return redirect('/tasks');
```

or with a named route:

```php
return redirect('tasks.index');
```

Use `redirectIntended()` after authentication when the middleware stored an intended destination:

```php
return redirect_intended('/');
```

## Redirect flash helpers

`RedirectResponse` supports fluent flash methods:

```php
return redirect('tasks.index')
    ->withSuccess('Task created.');
```

The supported methods include:

```text
with()
withErrors()
withSuccess()
withError()
withInput()
```

These values are stored in the current session for subsequent requests.

## Files and downloads

The response factory exposes:

```php
return response()->file($path);
return response()->download($path);
```

Use these helpers when the application needs to return existing files rather than HTML or JSON.

## Streaming and empty responses

A callback can be streamed with:

```php
return response()->stream(
    function () {
        echo "chunk";
    }
);
```

For a successful operation with no response body:

```php
return response()->noContent();
```

## Choosing a response

Use `view()` for server-rendered pages, `json()` for API-style responses, `redirect()` after browser workflows, and `download()`/`file()` for file delivery.
