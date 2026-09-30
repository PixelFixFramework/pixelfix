# ORM Lifecycle and State

PixelFix models maintain more than database attributes. A model tracks whether it represents an existing row, its original attributes, relation state, and recent changes.

## New versus existing models

A model created from scratch is not yet persisted. After a successful insert, PixelFix marks it as existing and synchronizes its original state.

You can inspect this with:

```php
$task->exists();
```

The model also provides `markAsExisting()` for framework/test scenarios that need to establish existing-row state explicitly.

## Dirty tracking

After changing attributes:

```php
$task->status = 'completed';

$task->isDirty();
$task->getDirty();
```

`getDirty()` returns attributes whose current values differ from the original values known to the model.

After successful persistence, the model synchronizes its original state. The recent change set can be inspected through:

```php
$task->getChanges();
$task->wasChanged('status');
```

## Fresh and refresh

```php
$fresh = $task->fresh();
$task->refresh();
```

`fresh()` returns a newly loaded instance. `refresh()` reloads the current instance.

## Attribute assignment

Normal assignment is subject to the model's mass-assignment configuration when using `fill()`/`create()` workflows.

```php
$task->fill([
    'title' => 'Updated title',
]);
```

`forceFill()` bypasses the normal fillable filtering and should only be used with trusted data.

## Serialization

Models support:

```php
$task->toArray();
$task->toJson();
json_encode($task);
```

Hidden attributes are excluded from serialized output. This is particularly important for authentication models.

## Timestamp behavior

When timestamping is enabled, the model sets `created_at` during inserts and `updated_at` during persistence. The exact column names are model configuration.

## Lifecycle callbacks

Model events surround inserts, updates, deletes, and restores. See [Model Events and Observers](model-events-observers.md) for exact ordering and cancellation behavior.
