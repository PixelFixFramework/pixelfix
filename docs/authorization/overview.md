# Authorization

PixelFix separates authentication from authorization. Authentication answers whether a user is signed in; authorization answers whether that user may perform a particular ability against an application resource.

PixelFix supports both gates and policies.

## Gates

A gate is an application-defined ability represented by a callback.

Define a gate through `Gate::define()`:

```php
use PixelFix\Framework\Support\Gate;

Gate::define(
    'access-admin',
    function ($user): bool {
        return $user->role === 'admin';
    }
);
```

The gate receives the currently authenticated user as the first argument.

Check the result without throwing:

```php
if (Gate::allows('access-admin')) {
    // ...
}
```

or:

```php
if (Gate::denies('access-admin')) {
    // ...
}
```

Authorize and throw on denial with:

```php
Gate::authorize('access-admin');
```

## Gate callbacks

The gate manager supports global `before` and `after` callbacks:

```php
Gate::before(function ($user, $ability, ...$arguments) {
    // Optional override logic.
});
```

```php
Gate::after(function ($user, $ability, $result, ...$arguments) {
    // Observe or override the result when appropriate.
});
```

These callbacks participate in the gate evaluation lifecycle.

## Policies

Policies group authorization rules around a model.

Generate a policy with:

```bash
php pixelfix make:policy TaskPolicy
```

A typical policy contains methods named after application abilities:

```php
class TaskPolicy
{
    public function view(
        User $user,
        Task $task
    ): bool {
        return (int) $task->user_id
            === (int) $user->getAuthIdentifier();
    }
}
```

## Policy registration

Register the model-to-policy relationship through `PolicyRegistry`:

```php
$policies = $this->app()
    ->make(PolicyRegistry::class);

$policies->policy(
    Task::class,
    TaskPolicy::class
);
```

PixelFix also supports policy convention discovery. By default it looks for a policy under `App\\Policies\\` named after the model basename with a `Policy` suffix.

For example:

```text
App\\Models\\Task
        ↓
App\\Policies\\TaskPolicy
```

Explicit registration is preferable when an application wants a clear and stable mapping.

## Authorizing a policy operation

Use the `Policy` helper when an authorization check is not naturally tied to a controller:

```php
Policy::authorize(
    'update',
    $task
);
```

or:

```php
if (Policy::allows('update', $task)) {
    // ...
}
```

The controller base class exposes the same policy authorization through `HandlesAuthorization`:

```php
$this->authorize(
    'update',
    $task
);
```

## Class-level abilities

A class can be passed when the ability concerns the model type rather than a concrete record:

```php
$this->authorize(
    'create',
    Task::class
);
```

This is useful for operations such as creating a new model instance.

## Policy lifecycle

When a policy authorization is requested, PixelFix:

```text
Resolve model policy
       ↓
Resolve authenticated user
       ↓
Call policy before()
       ↓
Call the requested ability method
       ↓
Run gate after callbacks
       ↓
Normalize to AuthorizationResponse
       ↓
authorize() throws when denied
```

Policy methods may return `bool` or `AuthorizationResponse`.

## Authorization responses

The `HandlesAuthorization` trait provides convenient methods such as:

```php
$this->allow();
$this->deny();
$this->denyAsNotFound();
$this->allowIf($condition);
$this->denyIf($condition);
```

A denial defaults to HTTP status `403`; `denyAsNotFound()` produces a not-found-style denial response.

## Ownership checks

The authorization trait also provides an `owns()` helper for common ownership checks:

```php
return $this->owns(
    $user,
    $task
);
```

The default model ownership field is `user_id`, and the user identifier is taken from the authenticated model's authentication identifier unless explicitly configured.

## Middleware authorization

The `can` middleware evaluates an ability through the gate manager. It is available as a built-in middleware alias:

```php
->middleware('can:access-admin')
```

Use it when the authorization rule naturally belongs at the route boundary. For resource-specific checks, a controller policy call can be clearer because it passes the concrete model instance directly.

## Task Manager example

The Task Manager uses both authorization mechanisms.

The application defines an application gate in `AuthServiceProvider`:

```php
Gate::define(
    'access-admin',
    function ($user): bool {
        return $user->role === 'admin';
    }
);
```

The `/admin-test` route calls:

```php
Gate::authorize('access-admin');
```

Task authorization is model-based. `PolicyServiceProvider` registers:

```php
Task::class => TaskPolicy::class
User::class => UserPolicy::class
```

`TaskPolicy` then restricts `view`, `update`, `delete`, `restore`, and `forceDelete` by comparing the task owner to the authenticated user.

The result is a clear separation:

```text
Route gate
    → global ability: access-admin

Task policy
    → model ability: view/update/delete Task
```
