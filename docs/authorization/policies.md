# Policies

Policies group model-related authorization rules into a dedicated class.

## Creating a policy

The CLI can generate policies:

```bash
php pixelfix make:policy TaskPolicy
```

A policy normally receives the authenticated user and the relevant model:

```php
public function update(
    User $user,
    Task $task
): bool {
    return (int) $task->user_id
        === (int) $user->getAuthIdentifier();
}
```

## Registering a policy

The Task Manager explicitly maps models to policies:

```php
$policies->policy(
    Task::class,
    TaskPolicy::class
);
```

## Common abilities

The generated policy surface used by the reference application includes:

```text
viewAny
view
create
update
delete
restore
forceDelete
```

Policies may also define a `before()` hook for an early decision.

## Controller authorization

Controllers use the authorization helper supplied by `HandlesAuthorization`:

```php
$this->authorize(
    'update',
    $task
);
```

This keeps authorization close to the action being protected while leaving the actual rule in the policy class.

## Reference example

In Task Manager, a task can be viewed, updated, deleted, restored, or force-deleted only when the task belongs to the authenticated user. The policy therefore contains the ownership check rather than duplicating it in each controller method.
