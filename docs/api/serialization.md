# Serialization

PixelFix contains a serialization layer used by HTTP resources and by the framework's response handling.

## Serializer

The framework `Serializer` exposes two main operations:

```php
$serializer->normalize($value);
$serializer->serialize($value, $format);
```

Normalization converts application values into serialization-ready structures. Serialization then encodes the normalized representation.

## Normalizers

The framework includes normalizers for common framework values, including date/time values and backed enums. Custom normalizers can participate in the normalizer pipeline through the framework's serialization contracts.

## Encoders

PixelFix includes JSON and XML encoders. The `ContentNegotiator` selects an encoder according to the requested representation and registered encoder definitions.

The framework keeps content negotiation separate from the application data transformation layer. API resources define *what* should be exposed; the serialization layer handles *how* that representation is encoded.

## JSON responses

For normal application responses, use the response factory or the `json()` helper:

```php
return json([
    'message' => 'Created',
], 201);
```

`response()->json()` provides the same capability through the response factory.

## API resources and serialization

`JsonResource` implements `JsonSerializable`. A resource can therefore be returned through the framework response pipeline and encoded as JSON without manually calling `json_encode()`.

See [API Resources](resources.md) for application-facing transformation patterns.
