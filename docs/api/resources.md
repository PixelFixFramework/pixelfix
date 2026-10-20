# API Resources

An API resource defines exactly which parts of a model are returned to an API client. This is useful when a database model contains internal columns that should not be exposed, or when you want the public JSON format to remain stable even if the table changes later.

If you only need a quick internal endpoint, you can return `response()->json($users)`. For a public API, prefer a resource that explicitly selects its fields. See [Returning JSON from a Route or Controller](../http/json-responses.md) for the basic response pattern.

## 1. Create a resource

Run this command from the root of an existing application:

```powershell
php pixel make:resource UserResource
```

The generator creates a starting class in `app/Http/Resources`. Open the generated file and implement `toArray()`. The example below exposes an identifier, display name, and email address but does not expose a password hash or internal fields:

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

`resource()` returns the original model or value wrapped by the resource. `toArray()` returns the public representation. Each key in the array becomes a key in the JSON response. Only add fields that the caller is allowed to see.

## 2. Return one resource

Use the resource in a route or controller:

```php
use App\Http\Resources\UserResource;
use App\Models\User;
use PixelFix\Framework\Routing\Route;

Route::get('/users/{id}', function (int|string $id) {
    $user = User::find($id);

    if ($user === null) {
        return response()->json([
            'message' => 'User not found.',
        ], 404);
    }

    return new UserResource($user);
});
```

The response factory recognizes a `JsonResource` and converts it into JSON. By default, the resource wraps its data under `data`, so the response will look like:

```json
{
    "data": {
        "id": 7,
        "name": "Ada Lovelace",
        "email": "ada@example.com"
    }
}
```

The values above are illustrative; the actual values come from the selected user. Use `response()` on the resource if you need to set the status or headers explicitly:

```php
return (new UserResource($user))->response(
    200,
    ['Cache-Control' => 'no-store']
);
```

## 3. Return a collection

Pass an iterable of models to the static `collection()` method:

```php
$users = User::all();

return UserResource::collection($users);
```

Each model is passed through `UserResource::toArray()`, so the same field selection is applied to every item. The default output shape is:

```json
{
    "data": [
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
    ],
    "meta": []
}
```

Resource collections in this framework include a `data` list and a `meta` object. The empty `meta` object is expected when no additional metadata is supplied.

## 4. Add metadata

Use `additional()` to attach metadata that describes the response without mixing it into individual user records:

```php
return UserResource::collection($users)
    ->additional([
        'request_id' => $requestId,
        'source' => 'users-index',
    ]);
```

Metadata is merged into the collection's `meta` field. Use it for details such as a trace identifier or information the API contract defines; do not treat it as a substitute for pagination links or permissions.

## 5. Include a field conditionally

A resource may include an attribute only when a condition is true. For example, the following includes a user's email only when the current authenticated user is viewing their own record:

```php
return [
    'id' => $user->id,
    'name' => $user->name,
    'email' => $this->when(
        (string) auth()->user()?->getAuthIdentifier() === (string) $user->id,
        $user->email
    ),
];
```

The protected `when()` helper returns the value when the condition is true and `null` otherwise. Null values are filtered from the final resource output. Use authorization rules as well as conditional serialization; hiding a value in the response does not itself protect an operation on that data.

`mergeWhen()` conditionally merges a group of fields into the resource's array.

## 6. Resource wrapping and hidden fields

Resources are wrapped under the `data` key by default. A resource subclass can change the wrapping key by defining:

```php
<?php

namespace App\Http\Resources;

use PixelFix\Framework\Http\Resources\JsonResource;

class UserResource extends JsonResource
{
    protected static ?string $wrap = 'user';

    public function toArray(): array
    {
        $user = $this->resource();

        return [
            'id' => $user->id,
            'name' => $user->name,
        ];
    }
}
```

A resource can also define a protected `$hidden` list to remove keys from the representation after `toArray()` returns. Prefer selecting safe fields directly in `toArray()`; it is easier to review than building a large representation and trying to remove secrets afterward.

Model `$hidden` and `$visible` settings are useful for model serialization generally. Resource field selection is often the clearest contract for public APIs.

## 7. Resources and pagination

A paginated endpoint needs to transform the current page's records and communicate pagination state. See [Pagination](pagination.md) for the paginator API and how to combine pagination metadata with public response representations.

## Common mistakes

- **Returning the model without checking its fields:** serialization can include model attributes you did not intend to publish. Use a resource for public endpoints.
- **Forgetting the `data` wrapper:** a resource is wrapped by default; clients should read the `data` key.
- **Using a resource as authorization:** resources choose output fields; policies/gates decide whether an operation is allowed.
- **Calling `json_encode()` inside `toArray()`:** return PHP arrays and values. PixelFix encodes the final resource response.
