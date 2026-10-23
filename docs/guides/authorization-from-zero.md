# Build Authorization from Zero: Roles, Gates, Policies, and Tests

This guide builds a small, working authorization design in a PixelFix application. It assumes that a user can sign in and that a `users` table already exists. It teaches both the code to write and the security decisions behind it.

## First, understand the pieces

Authentication answers **who is making this request?** Authorization answers **may that user perform this action on this resource?** They are related, but they are not interchangeable.

- A **role** is an application concept such as `admin`, `manager`, or `member`.
- A **permission/ability** is an action such as `manage-users`, `view-task`, or `delete-task`.
- A **Gate** is a named ability checked by a callback. It is useful for broad actions that are not tied to one model record.
- A **Policy** groups decisions about a particular model, such as whether a user may update a particular `Task`.
- **Middleware** can prevent a request from reaching a route when an ability is denied.
- A **view condition** may hide a link, but it is not a security control. The route/controller must enforce the rule even if the link is hidden.

PixelFix provides Gates, Policies, authorization responses, and the built-in `auth`, `can`, `role`, and `permission` middleware aliases. The `role` alias checks a single `role` attribute on the authenticated user. The `permission` alias uses a Gate-backed checker by default and can be connected to an application-owned checker. The framework does **not** provide a prebuilt `Role` model, `Permission` model, roles table, permission table, or complete role-management package. You choose and implement the application's role/permission data model. The first example below uses one role column because it is a straightforward starting point.

## Part 1: Add a role column safely

### Step 1: Generate a migration

Run this from the root of the existing application:

```powershell
php pixel make:migration add_role_to_users_table
```

The generator creates a migration skeleton. Open the generated file in `database/migrations/` and edit its `up()` and `down()` methods. The generator does not decide your business schema for you.

### Step 2: Add the column

Use the existing `Schema::table()` and `Blueprint` APIs:

```php
use PixelFix\Framework\Database\Migrations\Migration;
use PixelFix\Framework\Database\Schema\Blueprint;
use PixelFix\Framework\Database\Schema\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('role', 32)->default('user');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn('role');
        });
    }
};
```

`up()` adds the new column. Existing users receive the database default `user`; the column is not allowed to be `NULL`. `down()` removes the column if you roll back this migration. Review the migration against your actual database driver before applying it to production.

Run and verify the migration:

```powershell
php pixel migrate
php pixel migrate:status
```

Do not use `migrate:fresh` on a database containing data you need: it drops tables and rebuilds the schema.

### Step 3: Do not let a registration form choose its own role

A malicious client can submit fields that are not displayed in the form. Never trust a posted `role=admin` value. The starter `User` model's `$fillable` list does not include `role`, which is a useful default: keep it that way unless you have a carefully controlled reason to permit assignment through mass assignment.

For ordinary registration, the application should create a normal user and let the database default assign `user`. Administrative role assignment should be a separate, authorized operation or a carefully controlled seed/setup step. A user must not be able to grant themselves administrative access by editing the request payload.

## Part 2: Define a Gate for an application-wide ability

### Step 4: Create a service provider

Use the normal provider generator:

```powershell
php pixel make:provider AuthorizationServiceProvider
```

Open `app/Providers/AuthorizationServiceProvider.php` and define a gate in its `boot()` method:

```php
<?php

namespace App\Providers;

use PixelFix\Framework\Providers\ServiceProvider;
use PixelFix\Framework\Support\Gate;

class AuthorizationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('manage-users', static function ($user): bool {
            return ($user->role ?? null) === 'admin';
        });
    }
}
```

Application providers under `app/Providers/` are discovered by the framework's provider discovery mechanism. If your application has customized provider discovery, ensure this provider is loaded. `Gate::define()` registers a named ability. When PixelFix checks the ability, the callback receives the authenticated user; it returns `true` only for a user whose role equals `admin`.

The gate does not create the role column, assign roles, or authenticate a user. Those are separate responsibilities.

### Step 5: Protect a route

For example, protect an administrative route:

```php
use PixelFix\Framework\Routing\Route;

Route::get('/admin/users', [AdminUserController::class, 'index'])
    ->middleware(['auth', 'can:manage-users'])
    ->name('admin.users.index');
```

`auth` requires the configured authentication guard to identify a signed-in user. `can:manage-users` asks the Gate manager to authorize the `manage-users` ability. If authorization is denied, the request does not proceed to the controller action.

Putting a rule on a route is useful for broad access control. A route can still require an additional resource-specific check inside the controller or policy.

## Part 3: Protect individual records with a Policy

A role check such as “is this user an administrator?” does not answer “does this user own this particular task?” Policies handle decisions tied to a model instance.

### Step 6: Generate a policy, then inspect its defaults

```powershell
php pixel make:policy TaskPolicy --model=Task
```

Open `app/Policies/TaskPolicy.php`. **Do not assume the generated policy is secure without editing it.** The current generic policy stub returns `true` from several abilities so the generated file is structurally complete. Those defaults allow access until replaced. Change every ability that matters before exposing the action.

A policy for owner-controlled tasks can use this pattern (adjust names to match your application's model and field):

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
        // Listing is allowed for signed-in users; the query must still
        // be scoped so each user receives only their own tasks.
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

This is an example of an **ownership policy**, not a universal policy. If administrators may manage every task, include that rule deliberately. If a user can belong to a team, compare the task's team with the user's authorized teams. Never copy an ownership condition without checking the fields and business rules in your own schema.

The `viewAny()` and `create()` decisions above permit an authenticated user to open the listing/create workflow; the controller must still scope the listing and set `user_id` from the authenticated user. Do **not** accept `user_id` from a submitted form as the owner.

### Step 7: Enforce the Policy before changing the database

Inside a controller that extends PixelFix's controller base class, use the authorization helper:

```php
$this->authorize('update', $task);
```

Pass the actual model instance for record-level abilities. For a class-level operation, such as checking whether a user may create tasks in general, pass the model class:

```php
$this->authorize('create', Task::class);
```

The authorization call must stop the operation on denial. Do not catch an authorization failure and continue with a database update.

A sound update flow is:

1. Find the task; decide how the application handles a missing record.
2. Authorize the current user against that task.
3. Validate only the fields that the user is allowed to change.
4. Assign trusted server-owned values such as `user_id` separately.
5. Save the change and return an appropriate response.

### Step 8: Scope the query as well as checking the record

A policy on `show`, `update`, or `delete` is not a substitute for scoping the index query. For a personal task list, filter before retrieving results:

```php
$tasks = Task::query()
    ->where('user_id', '=', auth()->id())
    ->orderBy('created_at', 'desc')
    ->paginate(20);
```

This query keeps other users' tasks out of the result set. Use a policy when opening or changing one task. Good systems use both query scoping and authorization at the action boundary.

## Part 4: Use authorization in different layers

### Route boundary

Use middleware for broad route-level access. `can` checks a named Gate ability; `role` checks a user's stored role name; `permission` checks a named permission through the configured `PermissionChecker`:

```php
Route::get('/admin/reports', [ReportController::class, 'index'])
    ->middleware(['auth', 'can:manage-users']);

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware('role:admin');

Route::get('/reports/export', [ReportController::class, 'export'])
    ->middleware('permission:reports.export');
```

### Controller boundary

Use `$this->authorize()` for a specific model operation. This is where you have the concrete task, invoice, account, or other resource to check.

The default `permission` checker treats `reports.export` as a Gate ability, so define that Gate before using the route. If the application stores permissions in normalized database tables or an external service, bind a custom `PixelFix\Framework\Auth\Contracts\PermissionChecker` implementation. The checker must return `true` only for a grant. These middleware checks do not create the role/permission schema or assignment workflows.

### Twig view

You may conditionally display controls based on information passed by the controller, so the interface is clearer. But hiding a button is not authorization. A client can send an HTTP request without clicking a button. The server must independently enforce the Gate, Policy, or other rule.

## Part 5: Test allowed and denied behavior

Do not test only the happy path. For every protected action, include at least:

- A user who should be allowed.
- A signed-in user who should be denied.
- A guest when authentication is required.
- A user attempting to access another user's record.
- A user attempting to submit an unauthorized ownership or role value.

Use PixelFix's test runner and `TestCase`, not PHPUnit-specific annotations or helpers:

```powershell
php tests/run.php --filter=Policy
php tests/run.php --dir=tests/Integration/Auth
```

These examples assume the test names/directories in your project match. The first filters discovered tests by the supplied text; the second runs tests under the chosen directory. Add application-specific tests for your own routes and policy decisions.

## When you need more than one role per user

A single `users.role` string is easy to understand but has limits: each user can have one role, role names are application conventions, and permissions are not separately managed as data. A multi-role permission system typically has tables such as:

- `roles` — named roles such as `admin` or `editor`;
- `permissions` — abilities such as `tasks.create` or `reports.export`;
- `role_user` — the many-to-many relationship between users and roles;
- `permission_role` — the many-to-many relationship between roles and permissions.

PixelFix's model relationships support `belongsToMany()` and pivot operations such as `attach()`, `detach()`, and `sync()`, so an application can implement these tables and models. However, the schema, role-management UI, permission assignment, effective-permission rules, and policy conventions are application code; PixelFix does not provide them as a turnkey RBAC module. Design uniqueness constraints on pivot pairs and perform multi-step updates in a database transaction.

For a smaller system, a role column plus Gates/Policies may be enough. For a larger organization with multiple roles, direct user permissions, teams, tenant boundaries, or audit requirements, design the data model before building the interface.

## Troubleshooting

| Symptom | Likely cause | What to check |
|---|---|---|
| A guest reaches a protected action | The route/action has no `auth` check, or a different guard is configured | Inspect the route middleware and configured default guard. |
| Every user can update every task | The generated policy still returns `true`, the controller never calls authorization, or the query does not scope ownership | Review the policy and action flow. |
| Administrators are never recognized | `role` is absent, null, differently cased, or never assigned | Check the migration, actual stored value, and Gate callback. |
| A hidden link still allows the action by URL | Only the interface was restricted | Enforce the rule on the server. |
| `TaskPolicy` is not found | Class name/namespace or discovery/registration does not match conventions | Check `App\Policies\TaskPolicy` and policy registry configuration. |

## What to read next

Read [Gates](../authorization/gates.md), [Policies](../authorization/policies.md), [Authentication](../authentication/overview.md), [Migrations](../database/migrations.md), and [Testing Feature Workflows](testing-real-workflows.md). The [Capability Matrix](../reference/capability-matrix.md) explains what PixelFix provides directly and what must be implemented by the application.
