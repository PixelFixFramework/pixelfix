# Build a Safe JSON API, Step by Step

This guide shows how to move from a route that returns data to a maintainable API endpoint. It explains the response body, status codes, field selection, validation, authorization, pagination, and testing. The snippets use `Task` and `User` as examples; adapt the fields to your own schema.

## 1. Decide what the client is asking for

A JSON API returns data to a client such as browser JavaScript, a mobile application, or an integration. It is not a complete HTML page. Clients usually need both a response body and an HTTP status code so they can tell whether the request succeeded.

A route in `routes/api.php` is not automatically prefixed with `/api`. The URI you register is the URI PixelFix uses unless you explicitly add a group prefix.

## 2. Start with a read endpoint

Assuming the application has an `App\Models\User` model and a working database connection, put this route in an appropriate route file:

```php
<?php

use App\Models\User;
use PixelFix\Framework\Routing\Route;

Route::get('/users', function () {
    return response()->json(User::all());
});
```

`User::all()` retrieves model records. `response()->json(...)` creates a JSON response, sets the JSON content type, and uses status `200` by default. It is explicit: a future reader can immediately see that this endpoint returns JSON rather than a Twig page.

The result is a JSON array of serialized users. **Do not expose all user fields blindly.** Password hashes, remember tokens, reset-token data, private notes, and internal flags should never be included just because they exist on a model. Model `$hidden` and `$visible` controls affect model serialization; for public APIs, a resource is usually a better explicit contract.

## 3. Handle one record and a missing record

```php
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

`find()` returns a matching model or `null`. The example returns `404 Not Found` when no matching user exists. The second argument to `json()` is the response status code. A client should not need to parse a successful `200` response to learn that a requested record is missing.

## 4. Give the API an explicit response shape

A small internal endpoint can return a model collection directly. A public API should generally choose the fields and structure deliberately. Create a resource:

```powershell
php pixel make:resource UserResource
```

Edit `app/Http/Resources/UserResource.php` so `toArray()` returns only the approved public fields:

```php
<?php

namespace App\Http\Resources;

use PixelFix\Framework\Http\Resources\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(): array
    {
        $user = $this->resource();

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}
```

Return one resource from the route:

```php
use App\Http\Resources\UserResource;

Route::get('/users/{id}', function (int|string $id) {
    $user = User::find($id);

    if ($user === null) {
        return response()->json(['message' => 'User not found.'], 404);
    }

    return new UserResource($user);
});
```

The default resource representation wraps a single resource under `data`. A resource collection wraps items under `data` and may include `meta`. These shapes are part of your API contract: write down the shape and test it so clients can rely on it.

## 5. Return the correct status

Use status codes that match the result:

| Status | Typical use | Example |
|---|---|---|
| `200 OK` | A successful read or update with a response body | Return a user or updated task. |
| `201 Created` | A record was successfully created | Return the new record or its identifier. |
| `204 No Content` | The operation succeeded and no body is needed | A delete endpoint with no response payload. |
| `400 Bad Request` | The request cannot be interpreted under your API contract | Malformed or unsupported request shape. |
| `401 Unauthorized` | Authentication is required or credentials are invalid | No acceptable identity was established. |
| `403 Forbidden` | The client is known but not allowed to perform the action | Policy/gate denies an operation. |
| `404 Not Found` | The requested resource does not exist or is deliberately not disclosed | A missing or inaccessible resource, depending on your policy. |
| `422 Unprocessable Content` | The body can be parsed but the submitted data fails validation | Invalid task title or status. |
| `500 Internal Server Error` | An unexpected server failure | Do not expose internal exception details publicly. |

These are design guidelines for the API contract. Confirm the actual response produced by your route, validation path, authentication middleware, and exception handler; do not assume every exception automatically becomes a particular JSON shape.

## 6. Validate input before persisting it

For a simple endpoint, the validation helper returns the validated fields or throws a `ValidationException`:

```php
$validated = validate(
    $request->all(),
    [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:5000',
    ]
);
```

In controller actions that use a Form Request, keep rules in that request class and consume `$request->validated()`. The key principle is the same: **only persist the fields validated for this operation**. Never take every client-supplied field and pass it to `create()` merely because the request contains it.

For example, a task's `user_id`, `role`, `is_admin`, or billing status is usually server-controlled. Do not accept those values directly from a general user request. Derive ownership from the authenticated user and enforce the ability through a Gate or Policy.

See [Validation](../validation/overview.md) and [Form Requests](../validation/requests.md) for the complete lifecycle, field rules, custom messages, and error handling.

## 7. Authenticate and authorize the endpoint

Do not assume placing a route in `routes/api.php` automatically enables token authentication. PixelFix supports session and token guards, but the application must configure the intended guard and apply the appropriate middleware. See [Authentication Guards](../authentication/guards.md) and [API Tokens](../authentication/tokens.md).

For an action that only signed-in users may perform:

```php
Route::post('/tasks', [TaskController::class, 'store'])
    ->middleware('auth');
```

For a particular task, also authorize the record:

```php
$this->authorize('update', $task);
```

If task records belong to users, scope the index query by the current user's identifier and write a policy that checks ownership. Never rely only on whether a browser UI displays an Edit button.

## 8. Paginate large collections

Avoid returning thousands of rows from every request. Paginate at the query level:

```php
$tasks = Task::query()
    ->where('user_id', '=', auth()->id())
    ->orderBy('created_at', 'desc')
    ->paginate(20);

return response()->json($tasks);
```

The paginator is JSON-serializable and includes the current page's `data`, navigation `links`, and pagination `meta`. If your API needs a strict public field schema, use a resource to transform each item while preserving the pagination contract. See [API Pagination](../api/pagination.md).

## 9. Return predictable errors

For an expected condition, create a safe JSON error body explicitly:

```php
return response()->json([
    'message' => 'The requested task was not found.',
    'code' => 'TASK_NOT_FOUND',
], 404);
```

Do not return database exception messages, SQL statements, filesystem paths, stack traces, secrets, or access tokens to callers. Log appropriate diagnostic context on the server and send a safe message to the client. See [Exception Handling](../application/exceptions.md) and [Logging](../application/logging.md).

## 10. Test the endpoint like a client

Request the endpoint with Postman or a terminal client. When the local application server is listening on port 8000:

```powershell
curl.exe -i http://127.0.0.1:8000/users
```

`-i` shows the status line and headers. Check that the status is correct, the `Content-Type` is JSON, and the body has the agreed shape. Test at least:

- a valid list request;
- a missing identifier;
- malformed or invalid input;
- an unauthenticated request to a protected endpoint;
- an authenticated user who lacks permission;
- a user trying to access someone else's record;
- records with sensitive fields to verify that the resource never returns them.

Use the PixelFix test runner for repeatable tests. Do not rely solely on manually clicking through a happy path.

## Common API mistakes

- Returning every model field and accidentally disclosing secrets.
- Returning a plain string while expecting a JSON body.
- Returning `200` for a failed operation.
- Reading all request data and mass-assigning fields that the client should not control.
- Assuming `routes/api.php` automatically adds `/api` to every URI.
- Assuming an API route is automatically authenticated.
- Fetching an unbounded collection instead of paginating it.
- Treating a resource's field filtering as authorization.

## Related guides

- [JSON Responses](../http/json-responses.md)
- [API Resources](../api/resources.md)
- [API Pagination](../api/pagination.md)
- [Authentication Tokens](../authentication/tokens.md)
- [Authorization from Zero](authorization-from-zero.md)
- [Testing Real Workflows](testing-real-workflows.md)
