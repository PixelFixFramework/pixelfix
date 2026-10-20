# Policy Reference

A policy is a class of authorization decisions associated with a model. A gate is a named rule not necessarily tied to one model instance. Both must be enforced on the server for every protected operation.

## Register a policy

The application maps a model class to its policy class through its authorization provider:

```php
$policies->policy(Task::class, TaskPolicy::class);
```

This tells PixelFix to consult `TaskPolicy` when checking abilities for a `Task`. Registration is required; creating a PHP class alone does not guarantee that authorization will use it.

## Policy method arguments

A record-oriented policy method normally receives the authenticated user first and the model instance second:

```php
public function view(User $user, Task $task): bool
{
    return (int) $task->user_id === (int) $user->getAuthIdentifier();
}
```

The method should return `true` only when access is allowed. Returning `false` denies the ability. The user is obtained from the active authentication guard; the model is the specific record on which the action is being attempted.

## Common abilities and their meaning

| Ability | Typical question |
|---|---|
| `viewAny` | May the user see the task list? |
| `view` | May the user see this particular task? |
| `create` | May the user create a task? |
| `update` | May the user change this task? |
| `delete` | May the user soft-delete this task? |
| `restore` | May the user restore a soft-deleted task? |
| `forceDelete` | May the user permanently remove this task? |

These are conventions, not automatic guarantees. Your controllers and views should call the abilities appropriate to the action they perform.

## Authorize and handle denial

```php
$this->authorize('update', $task);
```

The controller helper invokes the registered authorization logic and raises an authorization failure when the action is denied. Let the framework return the appropriate forbidden response, or catch/translate that failure only when the application has a deliberate alternative behavior.

## Gates and policies

Use a gate for broad abilities such as access to an operations dashboard. Use a policy for abilities attached to an individual model. Authentication middleware establishes that a user is signed in; the policy decides whether that user can act on this record. All three concerns can be necessary for a secure route.

## Ownership must be checked on every write

Do not rely on a record ID being difficult to guess. A user can alter a URL or form field. A policy should verify ownership or role permissions on the server, and queries should be scoped where appropriate so that one user's records are not listed to another user.
