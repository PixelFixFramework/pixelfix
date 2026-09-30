# Routing API Reference

PixelFix routing is exposed through `PixelFix\\Framework\\Routing\\Route` and its pending/group/resource builders.

## HTTP route declarations

The primary methods are:

```text
get()
post()
put()
patch()
delete()
options()
match()
any()
```

A route action can be a controller action array or a callable.

```php
Route::get(
    '/tasks',
    [TaskController::class, 'index']
)->name('tasks.index');
```

## Route metadata

A pending route supports:

```text
name()
middleware()
withScopedBindings()
withoutScopedBindings()
when()
```

Example:

```php
Route::get(
    '/tasks/{task}',
    [TaskController::class, 'show']
)
->name('tasks.show')
->middleware('auth');
```

## Groups

The framework supports grouped prefixes and middleware:

```php
Route::middleware('web')->group(function () {
    // routes
});
```

Or:

```php
Route::prefix('/admin')
    ->middleware('auth')
    ->group(function () {
        // routes
    });
```

Nested groups inherit the active prefix and middleware and restore the previous state after the group callback completes.

## Resource routes

`Route::resource($name, $controller)` returns a resource route builder. It supports selecting or excluding actions and customizing generated names.

Use the resource API when conventional CRUD routing matches the application; explicit routes remain appropriate when URLs or actions are intentionally different.

## Route parameters

Parameters can use FastRoute-compatible expressions:

```php
'/tasks/{task:\\d+}'
```

This restricts the `task` parameter to digits.

The current route context is available through:

```php
Route::parameters();
Route::parameter('task');
```

## Model binding

Explicit model binding can be registered with:

```php
Route::model('task', Task::class);
```

Custom bindings can be registered with a resolver callable:

```php
Route::bind('task', function ($value) {
    return Task::where('slug', $value)->first();
});
```

The framework also supports relation-scoped bindings through:

```text
scope()
scopeBindings()
withScopedBindings()
withoutScopedBindings()
```

## Route names

Named routes are consumed by redirect helpers and view helpers in applications. For example:

```php
return redirect_to_route(
    'tasks.show',
    [$task->id]
);
```

Use stable route names for application navigation so URL changes do not require changing every call site.

## Route cache

The current console provides:

```text
route:list
route:cache
route:clear
```

Caching is a deployment/runtime optimization. Route definitions should remain deterministic so the compiled route collection can be safely rebuilt.
