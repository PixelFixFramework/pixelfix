# Policies: Protect Actions on Specific Records

A policy is a class containing authorization decisions for a model. Use it when the answer depends on the particular record being viewed, edited, deleted, restored, or permanently deleted. For example, “may this user update this task?” depends on both the signed-in user and the task's owner.

A Policy is not a database permission table. PixelFix supplies policy resolution and authorization primitives, but your application decides who owns records, what roles mean, and which rules apply.

## 1. Generate a policy, then read it before using it

```powershell
php pixel make:policy TaskPolicy --model=Task
```

The generator creates `app/Policies/TaskPolicy.php` and may prepare the framework's policy registration file. Inspect the generated files and verify how the model-to-policy relationship is discovered or registered in your application.

> **Security warning:** the current generic policy stub returns `true` from several generated methods. These methods are permissive scaffolding, not a secure default. Replace the methods with real rules before relying on this policy to protect a route or database operation.

## 2. Write a real ownership policy

Assume each row in `tasks` has a `user_id` owner. An example policy is:

```php
<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use PixelFix\Framework\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Task $task): bool
    {
        return (string) $task->user_id
            === (string) $user->getAuthIdentifier();
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Task $task): bool
    {
        return (string) $task->user_id
            === (string) $user->getAuthIdentifier();
    }

    public function delete(User $user, Task $task): bool
    {
        return (string) $task->user_id
            === (string) $user->getAuthIdentifier();
    }
}
```

This is only an example for an owner-controlled task application. Here, `viewAny()` and `create()` allow authenticated users to enter those workflows, while `view()`, `update()`, and `delete()` restrict actions on a specific record to its owner. The list controller must still scope the database query to the user, and create code must set `user_id` from the authenticated user rather than accepting it from request data.

If your application is multi-tenant, compare tenant membership as well as record ownership. If administrators can manage all tasks, encode that exception deliberately and test it. Do not blindly paste an example policy without adapting it to your business rules.

## 3. How model-to-policy resolution works

PixelFix can discover a policy by convention. For a model named `App\Models\Task`, the conventional policy class is `App\Policies\TaskPolicy`. You can also register a model/policy pair through `PolicyRegistry` when you want an explicit mapping. Do not register the same model twice: `PolicyRegistry::policy()` throws if the mapping already exists.

If the policy is not being used, check the model class, policy class, namespace, autoloading, and the provider/discovery setup before changing the policy method.

## 4. Authorize an action from a controller

The controller base class uses `HandlesAuthorization`, so a controller can call:

```php
$this->authorize('update', $task);
```

The first argument is the ability name; the second is the model instance passed to the policy. On denial, the authorization path raises an authorization failure, so the action must stop. Do not catch that failure just to continue with the update.

For a class-level operation such as creating a new task, pass the class instead of a record:

```php
$this->authorize('create', Task::class);
```

A policy method used with the class must accept the arguments appropriate for that ability. A concrete record and a model class are not interchangeable.

## 5. Check without throwing

Use `Policy::allows()` when the application needs a boolean decision:

```php
use PixelFix\Framework\Support\Policy;

if (Policy::allows('update', $task)) {
    // Show or perform the allowed action.
}
```

`Policy::denies()` returns the inverse decision. `Policy::authorize()` enforces the decision and raises on denial. A boolean check is useful for presentation or conditional logic, but the protected operation must still enforce authorization at the server boundary.

## 6. Return a meaningful denial

Policies can return a boolean or an `AuthorizationResponse`. The `HandlesAuthorization` trait includes helpers such as `allow()`, `deny()`, `denyAsNotFound()`, `allowIf()`, and `denyIf()`.

- `allow()` creates an allow decision.
- `deny()` creates a denial response, normally interpreted as forbidden access.
- `denyAsNotFound()` can be used when the application deliberately wants an inaccessible resource to appear not to exist.
- `allowIf($condition)` and `denyIf($condition)` express conditional decisions.

Choose whether a denied operation should appear as `403 Forbidden` or `404 Not Found` according to your application's policy and information-disclosure requirements. A 404-style denial should not be used to hide broken application logic.

## 7. A route Gate and a model Policy answer different questions

A Gate is appropriate for a broad ability such as `manage-users` or `access-admin`. A Policy is appropriate for whether a user may update a specific task. The built-in `can` route middleware calls the Gate manager; controller policy authorization is often clearer when a model instance must be checked.

For example, an administrative route can use a broad gate:

```php
Route::get('/admin/reports', [ReportController::class, 'index'])
    ->middleware(['auth', 'can:manage-users']);
```

A task update action can separately call `$this->authorize('update', $task)`. One check does not replace the other if both broad and record-specific rules apply.

## 8. Scope query results and test negative paths

For an owner's task list, query only tasks owned by the authenticated user:

```php
$tasks = Task::query()
    ->where('user_id', '=', auth()->id())
    ->orderBy('created_at', 'desc')
    ->paginate(20);
```

Then use the policy to protect the detail/update/delete action. Tests should prove that one user cannot retrieve or modify another user's record by changing an identifier in the URL.

At minimum, test an allowed owner, a denied non-owner, an unauthenticated request, a missing record, and any administrator exception. Also assert that a denied request did not change the database. UI visibility is not evidence that the server is secure.

## 9. Common mistakes

- Leaving generated policy methods returning `true`.
- Assuming authentication alone means a user may access every record.
- Checking a policy for a model class when the policy requires a particular instance, or vice versa.
- Filtering records only in Twig after loading every user's data.
- Accepting ownership/role fields from the client.
- Registering the same policy mapping twice.
- Catching an authorization exception and then continuing with a write.

For a complete role-based example, including the `users.role` migration and a Gate, see [Authorization from Zero](../guides/authorization-from-zero.md). For the broader distinction between built-in authorization and application-specific roles/permissions, see the [Capability Matrix](../reference/capability-matrix.md).
