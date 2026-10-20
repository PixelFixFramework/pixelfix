# Returning JSON from a Route or Controller

This guide shows how to return JSON from PixelFix. JSON is a text format commonly used when a browser's JavaScript, a mobile application, Postman, or another server requests data instead of a complete HTML page.

By the end of this guide, you will be able to return a list of users, return one user, choose an HTTP status code, and inspect the result in a client.

## 1. Return a collection of records

Suppose your application already has a `User` model in `app/Models/User.php` and the database has a `users` table. Add a route to `routes/api.php` (or to `routes/web.php` if that is where you are organizing the endpoint):

```php
<?php

use App\Models\User;
use PixelFix\Framework\Routing\Route;

Route::get('/users', function () {
    $users = User::all();

    return response()->json($users);
});
```

Here is what each part does:

1. `Route::get('/users', ...)` registers a handler for an HTTP GET request to `/users`.
2. `User::all()` retrieves the user records and returns them in a collection.
3. `response()` gives you PixelFix's response factory.
4. `response()->json($users)` creates a JSON response containing the collection.
5. The response uses HTTP status `200 OK` by default and the content type `application/json; charset=UTF-8`.

**Important:** PixelFix loads `routes/api.php` directly; it does not automatically add an `/api` prefix just because the route is in that file. The example above is therefore available at `/users`. To make its URL `/api/users`, define the URI as `/api/users` or put the route inside a group with the `/api` prefix.

## 2. What the JSON response looks like

Assume the database contains two users and the model exposes the fields `id`, `name`, and `email`. The response body will be similar to:

```json
[
    {
        "id": 1,
        "name": "Ada Lovelace",
        "email": "ada@example.com"
    },
    {
        "id": 2,
        "name": "Grace Hopper",
        "email": "grace@example.com"
    }
]
```

The actual fields depend on the attributes available on your model and its serialization settings. Do not include passwords, password hashes, reset tokens, private notes, or other sensitive information in a public response. Use model `$hidden`/`$visible` settings or, preferably when you need a stable API contract, an API resource that explicitly lists the fields to return.

## 3. Return one record and handle a missing record

When a client requests one user, return a JSON object. If the record does not exist, return a clear message and a `404 Not Found` status:

```php
use App\Models\User;
use PixelFix\Framework\Routing\Route;

Route::get('/users/{id}', function (int|string $id) {
    $user = User::find($id);

    if ($user === null) {
        return response()->json([
            'message' => 'User not found.',
        ], 404);
    }

    return response()->json($user);
});
```

The second argument to `response()->json()` is the HTTP status code. `404` tells the client the requested record was not found; the JSON body explains the problem in a machine-readable way.

## 4. Return a consistent response object

A JSON response can be an array/list or an object-like structure. For an API where clients benefit from a consistent envelope, wrap the records in keys such as `data` and `meta`:

```php
Route::get('/users', function () {
    $users = User::all();

    return response()->json([
        'data' => $users,
        'meta' => [
            'count' => $users->count(),
        ],
    ]);
});
```

The response is now an object with a `data` property and a `meta` property. Choose a shape and keep it consistent across the endpoints in your API. If you use `JsonResource`, see [API Resources](../api/resources.md) for field-by-field transformation and resource collections.

## 5. Choose a status code and headers

The `json()` method accepts three arguments:

```php
response()->json($data, $statusCode, $headers);
```

For example, after successfully creating a record, return `201 Created`:

```php
return response()->json([
    'message' => 'User created successfully.',
    'data' => [
        'id' => $user->id,
        'name' => $user->name,
    ],
], 201);
```

That example assumes `$user` has already been validated and saved. Do not return `201` for a read-only request or when creation failed. Common status codes include `200` for a successful read, `201` for a newly created record, `400` for a malformed request when appropriate, `401` for unauthenticated requests, `403` for authenticated users who are not allowed to act, `404` for a missing record, and `422` for input that fails validation when that is your API's agreed response contract.

You can add response headers as the third argument:

```php
return response()->json(
    ['data' => $users],
    200,
    ['Cache-Control' => 'no-store']
);
```

## 6. `json()` versus `response()->json()`

PixelFix provides both forms:

```php
return json($users);

return response()->json($users);
```

They both create a `JsonResponse`. The second form makes it explicit that the response factory is being used and is useful when you also need methods such as `response()->view()` or `response()->download()` nearby.

PixelFix's response pipeline also converts return values such as arrays, `JsonSerializable` objects, and iterable collections into suitable responses. Since PixelFix's `Collection` implements JSON serialization, returning `$users` directly from a route will normally be converted to JSON too:

```php
Route::get('/users', function () {
    return User::all();
});
```

Even so, prefer `response()->json(...)` when teaching or maintaining an API endpoint: it makes the intent obvious and lets you specify the status code and headers in the same place. A plain string, by contrast, is treated as an HTML response; it is not automatically wrapped as a JSON string.

## 7. Test the endpoint

Start your application with the documented local development workflow and request the URL using Postman or a terminal client. For example, when the local server is listening on port 8000:

```powershell
curl.exe -i http://127.0.0.1:8000/users
```

The `-i` option displays the HTTP response headers as well as the body. Look for a status such as `HTTP/1.1 200` and a content type similar to:

```text
Content-Type: application/json; charset=UTF-8
```

If you see HTML instead of JSON, confirm that the route returns `response()->json(...)`, that you requested the correct URI, and that the response is not a redirect or an error page. If you receive an empty list, confirm that the database connection is correct and that the `users` table contains records.

## Common mistakes

- **Assuming `routes/api.php` adds `/api`:** it does not; the URI is exactly the one you register unless you explicitly use a route prefix.
- **Returning every model field:** this can expose data that the client should not receive. Use `$hidden`/`$visible` or an API resource.
- **Calling `json_encode()` manually:** return a PixelFix JSON response instead so the framework can set the content type and handle encoding.
- **Returning a string and expecting JSON:** strings are treated as HTML by the default response normalization. Use `response()->json($value)` for a JSON string or value.
- **Using the wrong status code:** choose a status that describes the result, not simply `200` for every situation.

Next, read [HTTP Responses](responses.md), [API Resources](../api/resources.md), and [API Pagination](../api/pagination.md).
