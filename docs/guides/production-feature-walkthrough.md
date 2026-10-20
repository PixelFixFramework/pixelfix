# Build a Feature the PixelFix Way: From Requirement to Tested Behavior

This guide shows how an experienced developer turns a feature request into a maintainable PixelFix implementation. The running example is a user-owned task feature, but the same reasoning applies to invoices, reports, inventory items, projects, and other resources.

## 1. Write the behavior before writing files

A vague requirement such as “users can manage tasks” is not yet a design. Define the visible behaviors and their constraints:

- a signed-in user can see only their own tasks;
- a task must have a non-empty title;
- a task is created with its owner set from the authenticated user;
- users cannot update another user's task by changing the URL identifier;
- delete behavior is explicit (soft delete, if the model uses the trait);
- the list is paginated;
- failed validation gives useful feedback;
- API callers receive JSON while browser pages render HTML;
- denied or invalid requests do not write data.

These statements become the acceptance criteria and test cases. They also separate validation (“is the title acceptable?”) from authorization (“may this user update this task?”).

## 2. Use the generator for structure, not business logic

From the application root, use the public generators where they fit:

```powershell
php pixel make:model Task --all
php pixel make:request StoreTaskRequest --model=Task
php pixel make:request UpdateTaskRequest --model=Task
php pixel make:controller TaskController --resource --model=Task
php pixel make:policy TaskPolicy --model=Task
php pixel make:factory TaskFactory --model=Task
php pixel make:seeder TaskSeeder --model=Task
```

Review the command help if a generator option differs in your installed version. Generators establish files, namespaces, relationships, and starter methods. They do **not** make the feature secure or complete automatically. Inspect every generated file, especially request `authorize()` methods and policy methods that may return permissive values.

## 3. Design the schema first

A typical task table might include:

- `id` — primary key;
- `user_id` — task owner;
- `title` — required task title;
- `description` — optional detail;
- `status` — an application-defined state;
- `created_at` and `updated_at` — framework-managed timestamps when enabled.

Use a migration to create or alter the table, a foreign-key constraint where appropriate, and indexes that support the queries the application will execute. Keep status values constrained in validation and application logic; a string column does not, by itself, enforce a finite set of statuses.

Do not use a migration reset or fresh operation on a database that contains important data. Read [Migrations](../database/migrations.md) and [Schema](../database/schema.md) before making destructive schema changes.

## 4. Make the model represent the data rules

Confirm the model's table name, timestamp behavior, fillable/hidden attributes, casts, and relationships. A common ownership relationship is:

```php
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

Use the actual relation class imports required by your model. The user-to-task relationship can be `hasMany(Task::class)` when that relationship is useful for queries. A model relationship gives the ORM a way to query related records; it does not automatically authorize access.

If tasks should be recoverable, add the `SoftDeletes` trait and a nullable `deleted_at` column. Decide separately who may restore or permanently delete records. See [Soft Deletes](../database/soft-deletes.md).

## 5. Validate the fields the user can submit

A `StoreTaskRequest` should validate fields such as `title`, `description`, and allowed `status`. The `validated()` payload is the safe input boundary for the action. Keep fields such as `user_id`, `is_admin`, or approval status out of ordinary user-controlled input.

The generic Form Request stub's `authorize()` method returns `true`; replace it if the request itself needs an authorization condition, or enforce the required Gate/Policy before the write. Validation and authorization are separate checks, and both are needed when the feature requires them.

For updates, also distinguish fields that can be changed by a normal user from fields reserved for an administrator or workflow transition. Do not re-use a broad create rule for every operation without reviewing the implications.

## 6. Implement the controller as an application workflow

A robust controller action generally follows this sequence:

1. Resolve the route parameter or model and handle a missing record.
2. Authenticate and authorize the requested operation.
3. Validate submitted values.
4. Set server-owned fields such as the owner ID.
5. Perform the database operation.
6. Return the appropriate view, redirect, or JSON response.

Keep the controller understandable. If a workflow becomes large, repeated, or requires multiple collaborators, move the business operation into an application service that can be tested directly. Do not hide a large transaction or cross-system process inside a Twig template or a policy callback.

## 7. Keep queries scoped and bounded

For a personal task list:

```php
$tasks = Task::query()
    ->where('user_id', '=', auth()->id())
    ->orderBy('created_at', 'desc')
    ->paginate(20);
```

Scope the query before retrieving data. Then use a policy for record-level view/update/delete decisions. This avoids returning other users' rows and avoids loading an unbounded table into memory.

For detail and update actions, test the case where a user guesses another task ID. Do not assume unguessable identifiers replace authorization.

## 8. Build the UI by composing components

`MakeViewCommand` creates a generic Twig view. It does not generate a specialized login/register view and it does not import components referenced in that view. Developers create a generic view at the desired destination, import any bundled reusable components that are required, then compose the page.

A route view typically extends a layout and includes page components. Repeated buttons, form fields, feedback messages, headers, and navigation belong in reusable components where the application can share them. UI components only render markup; they do not create authentication handlers, validate server input, save a record, or enforce authorization by themselves.

See [Views](../views/overview.md), [Templates and Components](../views/templates.md), and the [Component Library](../components/form/button.md).

## 9. Choose the response appropriate to the caller

For a browser form, successful writes often redirect to a named route and display flash feedback. Validation errors should be shown beside the relevant fields and old values restored where appropriate.

For an API, return an explicit JSON response or a resource and a status code. Do not return a Twig page to a mobile client expecting JSON. Use resources to select public fields and pagination to bound large responses.

The route's location does not automatically determine its authentication strategy or JSON response format; configure middleware and return values deliberately.

## 10. Test the acceptance criteria

For each acceptance criterion, add a test proving the behavior. Important negative cases include:

- invalid title is rejected and no row is saved;
- unauthenticated request cannot perform the action;
- user B cannot view/update/delete user A's task;
- changing a submitted `user_id` cannot transfer ownership;
- a missing task gives the expected not-found behavior;
- pagination returns only the requested page;
- JSON resources omit password/token/private fields;
- a failed database operation does not leave a partial multi-row write.

Use the test runner included with PixelFix. Database tests need a functioning database driver and should not target production data. See [Testing Real Workflows](testing-real-workflows.md).

## 11. Review the feature before calling it done

Ask these questions:

- Does the migration support both the new and existing data cases?
- Does the model expose only intended fields to mass assignment and serialization?
- Are query filters, ordering and pagination appropriate for real data volume?
- Are foreign keys and uniqueness constraints enforcing data integrity?
- Can another user change the identifier and access somebody else's row?
- Do request and policy stubs still have permissive defaults?
- Do all failure paths return appropriate HTML or JSON?
- Are exceptions logged without revealing secrets to the client?
- Do tests prove both allowed and denied behaviors?
- Is the behavior documented with an example and an expected result?

Related reading: the [Task Manager End-to-End Build](../task-manager/end-to-end-build.md), [Authorization from Zero](authorization-from-zero.md), [Performance and Scale](performance-and-scale.md), and [Production Readiness](production-readiness.md).
