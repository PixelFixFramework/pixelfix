# Serialization

Serialization is the process of turning application values into a representation that can be sent over HTTP or stored elsewhere. In a web application, one common use is turning user or task records into JSON that another program can read.

PixelFix has a serialization layer, and its response factory also knows how to convert common return values into HTTP responses. For everyday JSON endpoints, you can usually use `response()->json()` or return an API resource; you do not need to call `json_encode()` yourself.

## Return JSON from a route

```php
use App\Models\User;
use PixelFix\Framework\Routing\Route;

Route::get('/users', function () {
    $users = User::all();

    return response()->json($users);
});
```

`response()->json()` makes the output format explicit, creates a `JsonResponse`, and sets the JSON content type by default. See [Returning JSON from a Route or Controller](../http/json-responses.md) for response bodies, status codes, headers, and a missing-record example.

## Automatic conversion versus an explicit JSON response

PixelFix's router passes the return value from a route/controller action through the response factory. Existing response objects pass through unchanged. JSON-serializable models/resources, iterable collections, arrays, and boolean/numeric scalar values are converted into JSON responses. A `Collection`, such as the result of `User::all()`, implements JSON serialization, so this also works:

```php
Route::get('/users', function () {
    return User::all();
});
```

Prefer `response()->json(...)` in instructional examples and API handlers when the response should clearly be JSON, when you need to choose a status code, or when you need to add headers. A plain string is treated as HTML by the response factory; it is not automatically encoded as a JSON string.

## Serializer and normalizers

The framework `Serializer` exposes two operations:

```php
$serializer->normalize($value);
$serializer->serialize($value, $format);
```

Normalization converts supported application values into arrays and scalar values that an encoder can handle. Serialization encodes the normalized representation in the requested format. PixelFix includes normalizers for common framework values such as date/time values and backed enums. Custom normalizers can participate through the framework's serialization contracts.

## Encoders and content negotiation

PixelFix includes JSON and XML encoders. The `ContentNegotiator` chooses among registered encoder definitions based on the requested representation and available configuration. Do not assume every route automatically switches between JSON and XML simply because the request has an `Accept` header; use the response/resource APIs and configuration that your endpoint actually implements.

## Use API resources to control what is exposed

Serialization answers how data becomes JSON. An API resource answers which fields should be included. For a public endpoint, an explicit resource is often safer than exposing the whole model:

```php
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

This makes the public response shape intentional and prevents newly added database columns from appearing in the API by accident. See [API Resources](resources.md).
