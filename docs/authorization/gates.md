# Gates

Gates are named authorization abilities defined with callbacks.

## Defining a gate

A gate is typically defined from a service provider:

```php
Gate::define(
    'access-admin',
    function ($user): bool {
        return $user->role === 'admin';
    }
);
```

The Task Manager registers exactly this kind of gate in `AuthServiceProvider`.

## Checking a gate

The gate manager supports:

```php
Gate::allows('access-admin');
Gate::denies('access-admin');
Gate::check(['feature-a', 'feature-b']);
Gate::any(['feature-a', 'feature-b']);
Gate::none(['feature-a', 'feature-b']);
```

## Authorizing

For an operation that should stop on denial:

```php
Gate::authorize('access-admin');
```

`authorize()` evaluates the ability and throws through the framework's authorization response flow when access is denied.

## Gates vs policies

Use a gate for a named ability that is naturally expressed as a callback. Use a policy when authorization is centered on a model and a set of CRUD-style abilities such as `view`, `create`, `update`, or `delete`.
