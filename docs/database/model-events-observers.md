# Model Events and Observers

PixelFix models support lifecycle callbacks and observer objects.

## Supported model events

The current model implementation exposes:

```text
saving
saved
creating
created
updating
updated
deleting
deleted
restoring
restored
```

## Registering callbacks

A callback receives the model instance:

```php
Task::creating(function (Task $task) {
    $task->status ??= 'pending';
});
```

You can register callbacks for update, save, delete, and restore phases in the same way.

## Cancellation

A `saving`, `creating`, `updating`, `deleting`, or `restoring` callback can stop the operation by returning `false`.

```php
Task::deleting(function (Task $task) {
    if ($task->status === 'locked') {
        return false;
    }

    return true;
});
```

## Event order for inserts

A normal model insert follows this order:

```text
saving
creating
insert
created
saved
```

If a pre-persistence callback returns `false`, the database write is not performed.

## Event order for updates

A normal update follows:

```text
saving
updating
update
updated
saved
```

If no tracked attributes are dirty, `save()` returns successfully without issuing an update.

## Deletes and soft deletes

For a soft-deletable model:

```text
deleting
set deleted_at
deleted
```

A hard delete follows the same `deleting`/`deleted` callback pattern, but physically removes the row.

`restore()` uses:

```text
restoring
clear deleted_at
restored
```

`forceDelete()` performs a hard delete even when the model uses soft deletes.

## Observers

An observer is an object whose methods match event names:

```php
final class TaskObserver
{
    public function creating(Task $task): void
    {
        // ...
    }

    public function deleted(Task $task): void
    {
        // ...
    }
}
```

Register it with:

```php
Task::observe(TaskObserver::class);
```

The model instantiates a string observer class automatically. An already-created observer object can also be supplied.

Only observer methods that actually exist for an event are invoked.

## Observer cancellation

Just like callback listeners, an observer event method may return `false` from a pre-persistence event to cancel the operation:

```php
public function updating(Task $task): bool
{
    return $task->status !== 'locked';
}
```

## Clearing listeners

Tests or long-running framework processes can clear callbacks for the current model class with:

```php
Task::flushEventListeners();
```

The framework also exposes model state reset facilities used by its test/runtime infrastructure.

## When to use events

Use model events for model-local lifecycle behavior such as setting derived attributes, enforcing invariants, or triggering tightly coupled model concerns.

Keep broad application workflows in explicit services or application-layer code instead of hiding substantial business processes inside model events.
