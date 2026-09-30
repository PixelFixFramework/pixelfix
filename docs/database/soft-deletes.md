# Soft Deletes

PixelFix provides soft deletes through the `SoftDeletes` model trait.

## Enabling soft deletes

```php
class Task extends Model
{
    use SoftDeletes;
}
```

The table must also contain a nullable deleted-at column. The Task Manager migration uses:

```php
$table->dateTime('deleted_at')->nullable();
```

## Normal behavior

Normal model queries exclude soft-deleted rows through the model's global scope.

## Including deleted rows

PixelFix exposes:

```php
Task::withTrashed()->get();
Task::onlyTrashed()->get();
```

Individual models can also be restored or permanently removed:

```php
$task->restore();
$task->forceDelete();
```

The model layer also exposes corresponding static helpers such as `restoreById()`.

## Authorization consideration

Soft delete operations remain ordinary application operations and can be protected by policies. The Task Manager's policy defines `restore` and `forceDelete` explicitly.
