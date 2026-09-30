# HTTP Requests

PixelFix represents an incoming HTTP request with `PixelFix\Framework\Http\Requests\Request`.

## Request input

The request combines query-string and POST input into its normalized input collection.

```php
$request->input('email');
$request->all();
$request->only(['email', 'name']);
$request->except(['password']);
$request->has('email');
$request->filled('email');
```

For more explicit access, PixelFix also exposes query and POST collections:

```php
$request->query('page');
$request->post('email');
$request->allQuery();
$request->allPost();
```

## Route parameters

After routing, route parameters are available through the request:

```php
$id = $request->route('id');
```

This is particularly useful for custom request classes that need route context during validation or authorization.

## HTTP metadata

Common request information includes:

```php
$request->getMethod();
$request->getUri();
$request->path();
$request->header('Accept');
$request->ip();
```

## JSON requests

PixelFix detects JSON requests and decodes a JSON object payload. JSON input is merged into the request data and can then be accessed with the same input helpers.

```php
$data = $request->all();
```

You can inspect the request with:

```php
$request->isJson();
$request->expectsJson();
$request->json('field');
$request->isApi();
```

## Method spoofing

HTML forms can submit POST data with an `_method` field to represent `PUT`, `PATCH`, or `DELETE`:

```html
<input type="hidden" name="_method" value="DELETE">
```

`getMethod()` normalizes the method before routing continues.

## Uploaded files

File helpers include:

```php
$request->file('avatar');
$request->hasFile('avatar');
$request->allFiles();
```

Validation rules can then be used to validate uploaded files.
