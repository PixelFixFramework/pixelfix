# Task Manager: Authorization

The Task Manager demonstrates both gates and policies.

## Admin gate

`AuthServiceProvider` defines an `access-admin` gate:

```php
Gate::define(
    'access-admin',
    function ($user): bool {
        return $user->role === 'admin';
    }
);
```

The `/admin-test` route authorizes the gate before returning its response.

## Task policy

`PolicyServiceProvider` registers `TaskPolicy` for the `Task` model. The policy contains resource abilities such as:

```text
viewAny
view
create
update
delete
restore
forceDelete
```

For concrete task records, the policy compares the task's `user_id` with the authenticated user's identifier.

This prevents one user from viewing, editing, or deleting another user's task through the controller's normal authorization boundary.

## Controller usage

`TaskController` authorizes class-level create access:

```php
$this->authorize(
    'create',
    Task::class
);
```

and concrete-record access:

```php
$this->authorize(
    'update',
    $taskModel
);
```

The distinction is important because `create` concerns the ability to create a `Task`, while `update` concerns one specific persisted task.
