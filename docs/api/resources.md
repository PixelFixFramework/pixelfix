# API Resources

PixelFix provides API resources for transforming application data into explicit JSON response shapes.

## Creating a resource

Generate a resource with:

```bash
php pixelfix make:resource UserResource
```

Generated resources live under `app/Http/Resources` and extend `JsonResource`.

A resource implements `toArray()`:

```php
<?php

namespace App\Http\Resources;

use PixelFix\Framework\Http\Resources\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->resource()->id,
            'name' => $this->resource()->name,
            'email' => $this->resource()->email,
        ];
    }
}
```

The wrapped resource is available with `resource()`.

## Returning a resource

A resource can be returned directly from a controller. PixelFix's response factory recognizes `JsonResource` and `ResourceCollection` instances and converts them to JSON responses.

```php
public function show(User $user)
{
    return new UserResource($user);
}
```

You can also create an explicit response:

```php
return (new UserResource($user))->response();
```

`response()` accepts an HTTP status and additional headers.

## Collections

Create a collection from an iterable with:

```php
return UserResource::collection($users);
```

The default JSON shape is:

```json
{
    "data": [
        {
            "id": 1,
            "name": "Ada"
        }
    ],
    "meta": []
}
```

Additional collection metadata can be added with `additional()`:

```php
return UserResource::collection($users)
    ->additional([
        'request_id' => $requestId,
    ]);
```

## Conditional fields

Resources provide protected helpers for conditional output:

```php
return [
    'id' => $this->resource()->id,
    'name' => $this->resource()->name,
    'admin_note' => $this->when(
        auth()->user()?->role === 'admin',
        $this->resource()->admin_note
    ),
];
```

`mergeWhen()` conditionally merges an array of attributes into the resource output.

Null attributes are filtered from the final resource output, and resource instances nested inside arrays are resolved recursively.

## Hidden fields and wrapping

`JsonResource` supports a protected `$hidden` array for removing fields from the resource output. Resources are wrapped with `data` by default.

A derived resource may change the static wrapping key:

```php
protected static ?string $wrap = 'user';
```

Resource-level metadata is stored in the protected `$meta` array and is included alongside the wrapped data when present.

## Pagination

Paginated resource collections combine transformed records with pagination metadata and links. See [Pagination](pagination.md).

## Resource responses

`ResourceResponse` is the response type used when a resource or resource collection is explicitly converted into a response. It serializes JSON with an `application/json` content type by default.

## Scope of the API

The resource abstraction is intentionally small: define the representation in `toArray()`, compose resources and collections, and return them from HTTP handlers. Lower-level serialization remains a framework concern.
