# Example Application Authorization: Decide Who May Do What

Authentication and authorization answer different questions. **Authentication** establishes which user is signed in. **Authorization** decides whether that user is allowed to perform a specific action. The example application uses a gate for one application-wide decision and a policy for actions on records.

## The admin gate

The application's `AuthServiceProvider` defines an `access-admin` gate:

```php
Gate::define('access-admin', function ($user): bool {
    return $user->role === 'admin';
});
```

The callback receives the authenticated user. It returns `true` when the user has the required role and `false` otherwise. The `/admin-test` route calls `Gate::authorize('access-admin')`; if the decision is denied, PixelFix raises an authorization failure instead of returning the protected response.

**Important limitation in the supplied demo:** the current `User` model and `users` migration do not define a `role` attribute/column. As supplied, this example is an illustration of gate wiring, not a ready-to-use role system. To make it functional, add a `role` column through a migration and decide how roles are assigned securely, or change the gate to check an attribute that your application actually stores. Do not allow a registration form to choose its own administrator role.

A gate is useful for a decision that is not naturally tied to one model instance, such as “may access the admin area?”

## The `RecordPolicy`

A policy groups permissions for one model. `PolicyServiceProvider` registers `RecordPolicy` for `record`, so PixelFix can resolve abilities such as `view`, `update`, and `delete` for a record.

The policy compares the record owner with the authenticated user. For example:

```php
public function update(User $user, Record $record): bool
{
    return (int) $record->user_id
        === (int) $user->getAuthIdentifier();
}
```

The method returns a boolean decision; it does not update the record. It returns `true` only when the current user owns that record.

The policy also has class-level abilities such as `viewAny` and `create`. They answer questions about the resource type rather than one existing record record.

## Calling authorization from a controller

For a new record, authorize the model class:

```php
$this->authorize('create', Record::class);
```

For an existing record, pass the actual model:

```php
$this->authorize('update', $recordModel);
```

The first asks whether the user can create a record in general. The second asks whether the user can update this particular record. Passing the class where a record is required—or passing an unrelated record—can result in the wrong authorization decision or an error.

## What happens when access is denied?

`authorize()` stops the current operation when the policy denies access. The protected database write or response must not continue. Handle the framework's authorization response through the normal exception/error handling path; do not catch and ignore an authorization failure simply to let the action proceed.

A controller should generally follow this order:

1. Find the requested record and handle the case where it does not exist.
2. Authorize the intended action against the record.
3. Validate submitted input.
4. Perform the change only after the preceding checks succeed.

The exact order for validation and authorization may depend on how a Form Request is resolved, but every write must be protected before persistence.

## Common security mistake

Do not assume a route is safe merely because it requires login. An authenticated user may still try to change `/records/12` to `/records/13`. Authentication restricts access to signed-in users; the policy checks whether the signed-in user owns record 13.

See [Gates](../authorization/gates.md), [Policies](../authorization/policies.md), and [Authentication](authentication.md) for the complete framework APIs.
