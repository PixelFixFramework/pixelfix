# Middleware Reference

PixelFix resolves middleware through `MiddlewareRegistry`. Middleware may be attached to a route, a route group, or a controller pipeline.

## Built-in aliases

The framework registers these aliases by default:

| Alias | Middleware |
| --- | --- |
| `session` | `StartSessionMiddleware` |
| `csrf` | `CsrfMiddleware` |
| `auth` | `AuthMiddleware` |
| `guest` | `GuestMiddleware` |
| `can` | `CanMiddleware` |

The default `web` group contains:

```text
session
csrf
```

The default `api` group is currently empty.

## Route middleware

Attach middleware to a route through the routing API:

```php
Route::get('/tasks', [TaskController::class, 'index'])
    ->middleware('auth');
```

For a group:

```php
Route::middleware('web')->group(function () {
    // routes
});
```

## Authentication middleware

`auth` permits authenticated users to continue. For a browser GET request from a guest it stores the intended URL, flashes an error, and redirects to `/login` by default.

For a request that expects JSON, it returns a `401` response instead of redirecting.

A redirect target may be supplied as middleware parameter where the pipeline supports parameters.

## Guest middleware

`guest` allows unauthenticated visitors through. An already authenticated user is redirected away from the guest-only route by default.

For JSON requests it returns `403` with an `Already authenticated.` message.

## Authorization middleware

`can` requires an ability name:

```text
can:access-admin
```

Additional parameters can identify authorization arguments. A parameter is first looked up on the current route; if no route value exists, the literal parameter is used.

Conceptually:

```text
can:ability,routeParameter
```

The middleware delegates the actual decision to the framework gate manager.

## Role middleware

`RoleMiddleware` exists in the framework source and checks a user's `role` attribute against one or more allowed roles. It is **not** one of the default framework aliases in `FrameworkMiddleware::all()`.

Applications that need role middleware therefore need to register and use their own alias rather than assuming `role` is built in.

## CSRF middleware

`csrf` skips verification for:

```text
GET
HEAD
OPTIONS
TRACE
```

It also skips requests identified as API requests and paths configured as excluded. For state-changing browser requests it verifies the request token against the session token and throws a CSRF exception when they do not match.

The normal `web` middleware group therefore gives form submissions CSRF protection automatically.

## Session middleware

`session` starts the configured session store before the request continues and ensures a CSRF token exists. Because it implements the terminable middleware contract, it saves the session after the response has been produced.

## Custom middleware

A custom middleware class implements:

```php
interface MiddlewareInterface
{
    public function handle(
        Request $request,
        Closure $next,
        mixed ...$parameters
    ): AbstractResponse;
}
```

A basic implementation is:

```php
final class EnsureFeatureEnabled implements MiddlewareInterface
{
    public function handle(
        Request $request,
        Closure $next,
        mixed ...$parameters
    ): AbstractResponse {

        // decide whether the request may continue

        return $next($request);
    }
}
```

Register the alias with `MiddlewareRegistry` through application/provider bootstrapping.

## Middleware groups

`MiddlewareRegistry` supports named groups and expands nested groups recursively. Duplicate middleware entries are removed during expansion, and circular group references are rejected.

## Ordering matters

Middleware is part of the request lifecycle, so ordering can affect behavior. In the default `web` group, the session starts before CSRF validation so the CSRF token can be read from the session.
