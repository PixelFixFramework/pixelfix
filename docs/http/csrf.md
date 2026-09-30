# CSRF Protection

PixelFix includes CSRF protection through `CsrfMiddleware` for browser-style state-changing requests.

## Protected methods

Safe methods (`GET`, `HEAD`, `OPTIONS`, and `TRACE`) bypass CSRF verification. API requests also bypass this browser form token check. Other requests must provide a valid token unless the route is excluded by middleware configuration.

## Form token

The framework exposes:

```php
csrf_token();
csrf_field();
```

`csrf_field()` returns a hidden form input. In Twig templates, the Task Manager uses:

```twig
{{ csrf|raw }}
```

The `csrf` global delegates to the same helper.

## Verification

The middleware compares the submitted token with the token stored in the current session. An invalid token raises the framework's CSRF exception.

## Regeneration

Applications can regenerate the token with:

```php
regenerate_csrf_token();
```

This is useful when the application intentionally rotates the session's CSRF token.
