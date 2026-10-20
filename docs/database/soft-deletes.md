# Soft Deletes

A **soft delete** hides a row from normal queries without immediately removing that row from the database. It is useful when users may need to recover records, when an administrator must review removed data, or when the application needs an audit trail. A soft delete is not a replacement for a retention policy: the row still exists until it is permanently deleted or removed by a separate cleanup process.

## 1. Enable soft deletes on a model

Import the framework trait and add it to your model:

```php
<?php

namespace App\Models;

use PixelFix\Framework\Database\Models\Model;
use PixelFix\Framework\Database\Traits\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected static string $table = 'tasks';
}
```

The model's table must have a nullable timestamp column. In a migration, add:

```php
$table->dateTime('deleted_at')->nullable();
```

A `NULL` value means that the record has not been soft-deleted. A date/time value means the record was soft-deleted at that time. If your table does not have this column, add it through a migration before enabling the trait.

## 2. What happens when you delete a record?

```php
$task = Task::find($id);

if ($task !== null) {
    $task->delete();
}
```

For a model that uses `SoftDeletes`, `delete()` sets `deleted_at` instead of issuing a permanent deletion. It returns a boolean indicating whether the operation succeeded. A missing task should be handled before calling the instance method, as shown above.

Normal model queries apply the soft-delete global scope. That means `Task::all()`, `Task::find($id)`, and ordinary query-builder queries do not show deleted rows. If a task was deleted, `Task::find($id)` will normally return `null`, even though the row remains in the database.

## 3. Include deleted records with `withTrashed()`

Use `withTrashed()` when the operation needs to consider both active and soft-deleted rows:

```php
$allTasks = Task::withTrashed()->get();

$task = Task::withTrashed()->find($id);
```

`withTrashed()` returns a query builder; it does not fetch records on its own. Calling `get()` retrieves the matching records. Calling `find($id)` retrieves one matching record by its key, including a soft-deleted row.

Use this carefully in controllers and APIs. If you return `withTrashed()` results to a user, confirm that the user is allowed to see deleted records.

## 4. Retrieve only deleted records with `onlyTrashed()`

Use `onlyTrashed()` when building a recycle-bin or restore screen:

```php
$deletedTasks = Task::onlyTrashed()->get();
```

This query removes the normal soft-delete scope and adds a condition requiring `deleted_at` to be non-null. The returned collection contains only soft-deleted tasks. Calling `onlyTrashed()` on a model that does not use soft deletes raises a runtime exception.

## 5. Restore a record

If you already have the deleted model instance, call `restore()`:

```php
$task = Task::withTrashed()->find($id);

if ($task !== null) {
    $restored = $task->restore();
}
```

`restore()` sets `deleted_at` back to `NULL` and returns a boolean. After a successful restore, the task appears in normal queries again. If the task is already active, `restore()` returns `true` without changing the record.

If you only have the identifier, use the model's static helper:

```php
$restored = Task::restoreById($id);

if (!$restored) {
    // No matching record was restored.
}
```

`restoreById($id)` looks up the record including trashed rows and attempts the restore. It returns `false` when it cannot find a record or cannot complete the restore; it does not return the restored model.

## 6. Permanently delete a record

`forceDelete()` physically removes the row from the table:

```php
$task = Task::withTrashed()->find($id);

if ($task !== null) {
    $deletedPermanently = $task->forceDelete();
}
```

This operation cannot be undone by `restore()`. It is appropriate for an authorized purge operation, not for the ordinary Delete button in a user interface. Make sure the user is authorized and the application has the correct retention rules before permanently deleting data.

## Quick reference

| Call | What it does | What it returns |
|---|---|---|
| `$task->delete()` | Sets `deleted_at` for a soft-deleting model. | `bool` success result. |
| `Task::withTrashed()->get()` | Retrieves active and deleted tasks matching the query. | Collection of models. |
| `Task::onlyTrashed()->get()` | Retrieves only soft-deleted tasks. | Collection of models. |
| `$task->restore()` | Clears the deletion timestamp. | `bool` success result. |
| `Task::restoreById($id)` | Finds a row including deleted rows and restores it. | `bool` success result. |
| `$task->forceDelete()` | Permanently removes the row. | `bool` success result. |

Soft-delete actions can trigger model lifecycle callbacks and observers. See [Model Events and Observers](model-events-observers.md) and ensure restore/purge actions are protected by your application's [policies](../authorization/policies.md).
