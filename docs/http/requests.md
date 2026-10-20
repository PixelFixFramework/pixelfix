# HTTP Requests

A request object represents the incoming HTTP request: its input fields, URL, headers, method, route parameters, and uploaded files. Controllers and Form Requests use it to inspect what the browser or client sent.

## Read input

```php
$title = $request->input('title');
$status = $request->input('status', 'pending');
```

`input()` reads a submitted value. The second argument is a fallback used when the field is absent. Do not treat a fallback as validation; validate required fields and allowed values before persisting them.

## Route parameters and query strings

Route parameters are part of the URL path (for example, `/tasks/42`). Query-string values follow `?` (for example, `/tasks?page=2`). Both can be used for lookup and filtering, but route parameters and user input must still be checked before use.

## Request method and headers

The request exposes HTTP metadata such as method, path, headers, and content type. This helps controllers distinguish a browser form submission from a JSON API request and choose an appropriate response.

## JSON requests

For an API client that sends JSON, confirm that the request uses the correct JSON content type and that the application reads the parsed payload through the request API supported by the installed version. Validate the parsed data just as you would validate an HTML form.

## Method spoofing for HTML forms

HTML forms normally submit GET or POST. PixelFix supports a method-spoofing convention for other state-changing methods when the web middleware recognizes the corresponding hidden field. Use it for update/delete forms and keep CSRF protection enabled.

## Uploaded files

Uploaded files are supplied by the request/file upload API. Check upload errors, size and allowed content type, choose a safe server-generated name, and store the file outside the public root unless it is intentionally public. Never trust a client-supplied filename as a filesystem path.

## Prefer validated data

After validation through a Form Request, use `$request->validated()` or the specific validated data API rather than writing arbitrary request fields into a model. Validation protects data shape; authorization protects which records the user may change.
