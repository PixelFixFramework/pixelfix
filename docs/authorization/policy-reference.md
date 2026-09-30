# Policy Reference

PixelFix policies centralize model-oriented authorization decisions.

## Register a policy

Use the `Policy` support API:

```php
Policy::policy(
    Task::class,
    TaskPolicy::class
);
```

The application's provider is a natural place to register policies because providers participate in application bootstrap.

## Policy methods

The policy convention is to expose ability methods such as:

```text
viewAny
view
create
update
delete
restore
forceDelete
```

The names are abilities, not magic requirements. The policy manager dispatches the requested ability to the policy implementation.

## Authorize in a controller

```php
$this->authorize(
    'update',
    $task
);
```

The controller base class uses the framework authorization handling support.

## Static policy API

Application code may also use:

```php
Policy::authorize('update', $task);
Policy::allows('update', $task);
Policy::denies('update', $task);
```

Use `authorize()` when denial should become the framework's authorization exception/HTTP response flow. Use `allows()`/`denies()` for conditional logic.

## Gates versus policies

Use a gate for an ability that is not naturally tied to a particular model instance:

```php
Gate::define(
    'access-admin',
    function ($user) {
        return $user->role === 'admin';
    }
);
```

The Task Manager includes an `access-admin` gate check for its admin test route.

Use a policy when the decision is naturally about an operation on a model.

## Global hooks

`Gate` exposes:

```text
before()
after()
```

These hooks allow framework/application authorization code to run before and after an ability decision.

## Middleware

The built-in `can` middleware delegates to the gate manager:

```text
can:ability
```

Additional middleware parameters can refer to current route parameters.
