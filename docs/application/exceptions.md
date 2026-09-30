# Exceptions

PixelFix centralizes exception handling in `ExceptionHandler` and maps common framework exceptions to appropriate HTTP responses.

## Framework exception categories

The current handler explicitly recognizes:

- validation failures
- CSRF failures
- authorization failures
- HTTP exceptions
- missing-model exceptions
- unhandled server exceptions

## Validation failures

A failed `FormRequest` or validator produces a `ValidationException`.

For JSON requests, PixelFix returns a `422` response containing a validation message and an `errors` payload.

For browser form requests, the handler flashes validation errors and old input and redirects back.

## CSRF failures

A `CsrfException` is converted to an HTTP error response. JSON requests are handled as JSON; browser requests use the normal error rendering path.

## Authorization failures

An `AuthorizationException` is rendered as a forbidden response. Controllers can use the authorization helpers documented in [Authorization](../authorization/overview.md).

## HTTP and model-not-found exceptions

`HttpException` preserves its HTTP status code. `ModelNotFoundException` is rendered as a `404` response.

Use `abort()` for application-level HTTP errors:

```php
abort(404, 'Task not found.');
```

The framework also provides `abort_if()` and `abort_unless()` helpers.

## Debug mode

When debugging is enabled, the exception renderer can expose detailed exception information to the error view, including class, message, file, line, trace, and previous-exception information.

In non-debug mode, unhandled exceptions use a generic server-error message instead of exposing the exception details.

## Reporting

Exceptions are reported through the framework logger. `ExceptionHandler::report()` writes the exception message and exception object to the logger context.

Application code should prefer meaningful context and should avoid placing secrets or credentials into exception messages or logging context.
