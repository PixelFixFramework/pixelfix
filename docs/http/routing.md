# Routing

PixelFix routes HTTP requests to application callables or controller actions. Routes are normally defined under `routes/web.php` and `routes/api.php` and use the `PixelFix\Framework\Routing\Route` facade-style API.

## Defining a route

The HTTP method helpers are:

```php
use PixelFix\Framework\Routing\Route;

Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::put('/tasks/{id}', [TaskController::class, 'update']);
Route::patch('/tasks/{id}', [TaskController::class, 'update']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
```

Each call returns a pending route, so names and middleware can be attached fluently.

```php
Route::get(
    '/tasks',
    [TaskController::class, 'index']
)->name('tasks.index');
```

Route actions can be controller action arrays or callables:

```php
Route::get('/health', function () {
    return 'OK';
});
```

## Return JSON from a route

A route can return a JSON response when the caller needs data rather than a Twig page. For example, assuming the application has an `App\Models\User` model:

```php
use App\Models\User;
use PixelFix\Framework\Routing\Route;

Route::get('/users', function () {
    $users = User::all();

    return response()->json($users);
});
```

`User::all()` retrieves the records. `response()->json($users)` creates a JSON response with status `200` by default and the content type `application/json; charset=UTF-8`. The JSON body is generated from the model collection; the exact fields depend on the model's serialization settings.

A route defined with URI `/users` responds at `/users`. PixelFix loads `routes/api.php` directly and does **not** silently prepend `/api`; define `/api/users` explicitly or add a route group prefix if that is the URL you want.

You can return a status code and error payload when needed:

```php
Route::get('/users/{id}', function (int|string $id) {
    $user = User::find($id);

    if ($user === null) {
        return response()->json([
            'message' => 'User not found.',
        ], 404);
    }

    return response()->json($user);
});
```

The second argument to `response()->json()` is the HTTP status. Use a meaningful status so a client can distinguish success from a missing record or a rejected request. Avoid returning private user fields; use `$hidden`/`$visible` on the model or an API resource that explicitly selects the fields exposed to clients. See [Returning JSON from a Route or Controller](json-responses.md) for a complete walkthrough.

## Named routes

Names are registered with `name()` and are used to generate URLs without hard-coding paths.

```php
Route::get(
    '/tasks/{task:\d+}',
    [TaskController::class, 'show']
)->name('tasks.show');
```

Generate a URL with the global `route()` helper:

```php
route('tasks.show', [15]);
```

Named parameters can also be supplied explicitly:

```php
route('tasks.show', [
    'task' => 15,
]);
```

Route parameters may also be supplied as objects when the object exposes `getRouteKey()`; otherwise an `id` property can be used.

## Route parameters

Parameters are written inside braces. PixelFix supports FastRoute-style parameter expressions.

```php
Route::get(
    '/tasks/{task:\d+}',
    [TaskController::class, 'show']
);
```

The `\d+` expression restricts the parameter to digits.

Inside the request, route parameters are available through `Request::route()`:

```php
$id = $request->route('task');
```

The global `Route` API also exposes the current parameter set:

```php
Route::parameters();
Route::parameter('task');
```

## Route groups

Groups apply a common prefix and/or middleware to all routes defined inside the callback.

```php
Route::group(
    '/admin',
    function () {

        Route::get(
            '/users',
            [UserController::class, 'index']
        )->name('admin.users.index');
    },
    [
        'middleware' => ['auth'],
    ]
);
```

Nested groups combine prefixes and middleware.

There are also fluent group builders:

```php
Route::prefix('/api')
    ->middleware('auth')
    ->group(function () {

        Route::get(
            '/profile',
            [ProfileController::class, 'show']
        );
    });
```

`Route::middleware(...)` and `Route::groupMiddleware(...)` create middleware group builders.

## Route middleware

Middleware can be attached directly to a route:

```php
Route::get(
    '/dashboard',
    [DashboardController::class, 'index']
)->middleware('auth');
```

Multiple middleware definitions can be supplied as an array:

```php
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'csrf']);
```

Middleware aliases and groups are resolved by the framework's `MiddlewareRegistry`.

## Built-in middleware aliases

The framework registers these aliases by default:

| Alias | Middleware |
|---|---|
| `session` | `StartSessionMiddleware` |
| `csrf` | `CsrfMiddleware` |
| `auth` | `AuthMiddleware` |
| `guest` | `GuestMiddleware` |
| `can` | `CanMiddleware` |

The predefined `web` group contains `session` and `csrf`.

```php
Route::middleware('web')
    ->group(function () {
        // Browser routes...
    });
```

The predefined `api` group is currently registered as an empty group.

## Parameterized middleware

Middleware definitions can contain comma-separated parameters:

```php
Route::put('/tasks/{task}', [TaskController::class, 'update'])
    ->middleware('can:update,task');
```

The middleware registry parses the alias and parameters before the middleware is instantiated and executed.

## Resource routes

PixelFix includes a resource route builder:

```php
Route::resource(
    'users',
    UserController::class
)->register();
```

The default resource actions are:

| Method | URI | Action | Default name |
|---|---|---|---|
| GET | `/users` | `index` | `users.index` |
| GET | `/users/create` | `create` | `users.create` |
| POST | `/users` | `store` | `users.store` |
| GET | `/users/{id}` | `show` | `users.show` |
| GET | `/users/{id}/edit` | `edit` | `users.edit` |
| PUT | `/users/{id}` | `update` | `users.update` |
| PATCH | `/users/{id}` | `update` | `users.update` |
| DELETE | `/users/{id}` | `destroy` | `users.destroy` |

Resource routes can be filtered and customized:

```php
Route::resource(
    'users',
    UserController::class
)
    ->only(['index', 'show'])
    ->middleware('auth')
    ->register();
```

Available resource builder methods include `only()`, `except()`, `names()`, `as()`, `middleware()`, and `actionMiddleware()`.

The current implementation uses `{id}` as the resource parameter for generated resource routes. If an application requires a parameter with a different name, define the routes explicitly.

## Route model binding

PixelFix supports explicit model binding through `Route::model()` and custom resolvers through `Route::bind()`.

```php
Route::model(
    'user',
    User::class
);
```

The default model resolver uses the model's route key name.

Custom resolution can be defined with a callback:

```php
Route::bind(
    'user',
    function ($value) {
        return User::query()
            ->where('email', $value)
            ->first();
    }
);
```

Models can define a custom route key, and PixelFix exposes `getRouteKeyName()` and `getRouteKey()` for that purpose.

## Scoped bindings

Route bindings can be scoped when a child resource should be resolved through a parent relationship.

```php
Route::scopeBindings();
```

A pending route can opt into or out of scoped bindings with:

```php
Route::get('/users/{user}/tasks/{task}', [TaskController::class, 'show'])
    ->withScopedBindings();

// If the route should not use scoped bindings:
Route::get('/tasks/{task}', [TaskController::class, 'show'])
    ->withoutScopedBindings();
```

## Conditional route configuration

Pending routes support conditional configuration with `when()`:

```php
Route::get(
    '/admin',
    [AdminController::class, 'index']
)
->when(
    environment('production'),
    function ($route) {
        $route->middleware('auth');
    }
);
```

## Current route information

PixelFix tracks the current route name and makes it available through `Route::currentRouteName()`.

Views also receive the current route name as the `current_route` Twig global.

## Task Manager example

The Task Manager declares all browser routes in `routes/web.php`. The routes are wrapped in the `web` middleware group and named consistently:

```php
Route::middleware('web')
    ->group(function () {

        Route::get(
            '/tasks/index',
            [TaskController::class, 'index']
        )->name('tasks.index');

        Route::get(
            '/tasks/{task:\d+}',
            [TaskController::class, 'show']
        )->name('tasks.show');

        Route::put(
            '/tasks/{task:\d+}',
            [TaskController::class, 'update']
        )->name('tasks.update');
    });
```

This route design keeps the browser request surface explicit while sharing session and CSRF middleware across the entire web group.
