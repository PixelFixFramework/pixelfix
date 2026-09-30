# Task Manager: Routing

The Task Manager keeps its browser routes in `routes/web.php`. The routes are wrapped in the framework's `web` middleware group:

```php
Route::middleware('web')
    ->group(function () {
        // Browser routes...
    });
```

This gives the routes session and CSRF middleware through the framework's predefined group.

## Public routes

The application exposes the welcome page and authentication pages:

```text
GET  /           → HomeController@index
GET  /register   → AuthController@showRegistration
POST /register   → AuthController@register
GET  /login      → AuthController@showLogin
POST /login      → AuthController@login
POST /logout     → AuthController@logout
```

Each route has a named route used by the views and controllers.

## Task routes

The task surface is deliberately explicit:

```text
GET    /tasks/index           → tasks.index
GET    /tasks/create          → tasks.create
POST   /tasks                 → tasks.store
GET    /tasks/{task}          → tasks.show
GET    /tasks/{task}/edit     → tasks.edit
PUT    /tasks/{task}          → tasks.update
DELETE /tasks/{task}          → tasks.destroy
```

The `{task}` parameter is constrained to digits with:

```php
'/tasks/{task:\\d+}'
```

The explicit parameter name is useful because the controller uses it consistently across the show, edit, update, and destroy actions.

## Generating URLs

Views and controllers use the route names rather than hard-coded URLs:

```twig
{{ route('tasks.index') }}
```

```php
return redirect_to_route(
    'tasks.show',
    [$task->id]
);
```

## Authorization route

The application also demonstrates a gate-based route:

```php
Route::get(
    '/admin-test',
    function () {
        Gate::authorize('access-admin');

        return 'Admin access granted.';
    }
)->name('admin.test');
```

The route illustrates that authorization can be enforced directly in a route endpoint, while task operations use model policies in the controller.
