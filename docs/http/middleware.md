# Middleware

Middleware surrounds request handling and can allow a request to continue, return a response immediately, or modify request processing.

## Middleware contract

Application middleware implements `PixelFix\\Framework\\Http\\Middleware\\MiddlewareInterface` and exposes a `handle()` method.

The framework calls middleware with the current request, a `$next` callback, and optional parameters:

```php
public function handle(
    Request $request,
    Closure $next,
    mixed ...$parameters
): AbstractResponse
{
    // ...
}
```

A middleware that permits the request to continue calls:

```php
return $next($request);
```

A middleware that should stop processing can return a response directly or throw an appropriate framework exception.

## Route middleware

Attach middleware to a route with `middleware()`:

```php
Route::get(
    '/dashboard',
    [DashboardController::class, 'index']
)->middleware('auth');
```

Multiple entries can be supplied:

```php
->middleware([
    'auth',
    'csrf',
])
```

## Middleware groups

A group is a named collection of middleware definitions.

The framework's default registry defines:

```text
web
├── session
└── csrf

api
└── (currently empty)
```

The Task Manager uses the `web` group around its browser routes:

```php
Route::middleware('web')
    ->group(function () {
        // Routes...
    });
```

Groups are expanded recursively by `MiddlewareRegistry`. Circular group references are rejected.

## Built-in aliases

PixelFix registers these aliases:

| Alias | Class | Purpose |
|---|---|---|
| `session` | `StartSessionMiddleware` | Starts the application session for the request. |
| `csrf` | `CsrfMiddleware` | Verifies the request CSRF token when enabled. |
| `auth` | `AuthMiddleware` | Requires an authenticated user. |
| `guest` | `GuestMiddleware` | Allows unauthenticated users and redirects authenticated users. |
| `can` | `CanMiddleware` | Evaluates an authorization ability through the gate manager. |

## Authentication middleware

`auth` allows authenticated requests to continue.

For browser requests that are not authenticated, it stores the intended URL for GET requests, flashes an error message, and redirects to `/login` by default.

For requests that expect JSON, the middleware returns a `401` JSON response instead.

A different redirect target can be passed as a middleware parameter:

```php
->middleware('auth:/signin')
```

## Guest middleware

`guest` is the inverse access boundary. Unauthenticated users may continue. Authenticated users are redirected to `/` by default.

For JSON requests, the middleware returns a `403` response with an `Already authenticated.` message.

A custom redirect target can be supplied:

```php
->middleware('guest:/dashboard')
```

## Authorization middleware

`can` delegates authorization to the framework gate manager. The middleware accepts parameters, so its exact usage should be chosen to match the ability and arguments registered by the application.

For operation-specific authorization inside a controller, the controller's `authorize()` method is often clearer because it can pass a concrete model instance directly to the policy.

## CSRF protection

CSRF protection is handled by `CsrfMiddleware` and is part of the default `web` group.

A normal HTML form should include:

```php
<?= csrf_field() ?>
```

or in Twig:

```twig
{{ csrf|raw }}
```

The generated field is a hidden `_token` input. The middleware also accepts the CSRF token from the `X-CSRF-TOKEN` or `X-XSRF-TOKEN` request headers.

When CSRF protection rejects a request, PixelFix throws a `CsrfException`.

## Sessions

`StartSessionMiddleware` attaches the configured session to browser requests. Because `session` is part of the default `web` group, application routes using `Route::middleware('web')` receive session support automatically.

The session layer is also used by authentication, flash messages, intended URLs, old validation input, and CSRF tokens.

## Controller middleware

Middleware can also be registered by a controller and restricted to selected actions:

```php
$this->middleware('auth')
    ->only(['index', 'create']);
```

or:

```php
$this->middleware('auth')
    ->except(['show']);
```

This is stored by the controller and resolved during controller dispatch.

## Custom middleware

Create a middleware class in the application's middleware directory using the generator:

```bash
php pixelfix make:middleware EnsureActiveUser
```

Implement the middleware contract:

```php
namespace App\Http\Middleware;

use Closure;
use PixelFix\Framework\Http\Middleware\MiddlewareInterface;
use PixelFix\Framework\Http\Requests\Request;
use PixelFix\Framework\Http\Responses\AbstractResponse;

class EnsureActiveUser implements MiddlewareInterface
{
    public function handle(
        Request $request,
        Closure $next,
        mixed ...$parameters
    ): AbstractResponse {

        // Check application-specific state.

        return $next($request);
    }
}
```

Register an application alias through the `MiddlewareRegistry`, typically from an application service provider:

```php
$middleware = $this->app()
    ->make(MiddlewareRegistry::class);

$middleware->alias(
    'active',
    EnsureActiveUser::class
);
```

Then use the alias in routes or middleware groups:

```php
->middleware('active')
```

Do not reuse the framework-reserved aliases unless you intentionally want to replace their meaning.

## Middleware execution model

At runtime, PixelFix resolves route middleware definitions, expands middleware groups, resolves aliases, builds the middleware pipeline, and executes the pipeline around the route/controller endpoint.

This produces a structure conceptually similar to:

```text
Request
   ↓
Middleware A
   ↓
Middleware B
   ↓
Controller / Endpoint
   ↓
Response
```

Middleware may perform work both before and after the `$next($request)` call by inspecting or transforming the downstream response before returning it.

## Task Manager example

The Task Manager places its browser routes behind the `web` group:

```php
Route::middleware('web')
    ->group(function () {
        // authentication and task routes
    });
```

The task actions then perform their more specific authorization at the controller/policy layer rather than relying only on an `auth` route boundary. This keeps authentication and object-level authorization as separate concerns.
