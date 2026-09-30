# Models

PixelFix models are application classes that extend `PixelFix\\Framework\\Database\\Models\\Model`.

## Creating a model

Generate a model with:

```bash
php pixelfix make:model Task
```

The model convention is `app/Models`.

A model typically specifies its table and mass-assignable fields:

```php
class Task extends Model
{
    protected static string $table = 'tasks';

    protected static array $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'due_date',
    ];
}
```

## Creating records

```php
$task = Task::create([
    'title' => 'Write documentation',
    'status' => 'pending',
]);
```

The model's `$fillable` configuration controls the default mass-assignment boundary.

For explicit persistence of an existing model:

```php
$task->status = 'completed';
$task->save();
```

## Querying models

```php
$tasks = Task::all();
```

```php
$task = Task::find($id);
```

```php
$task = Task::findOrFail($id);
```

```php
$tasks = Task::where(
    'user_id',
    $user->id
)->get();
```

Static calls are forwarded into the model's Query Builder.

## Attribute casting

Models can define `$casts`:

```php
protected static array $casts = [
    'due_date' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];
```

The current framework supports date/time casting and other scalar conversions through its model metadata and hydration logic.

## Timestamps

Timestamps are enabled by default and use:

```text
created_at
updated_at
```

The model can disable timestamps or customize the configured timestamp column names.

## Hidden and visible attributes

Models can control serialization through:

```php
protected static array $hidden = [
    'password',
    'remember_token',
];
```

A `$visible` list can also be used when an allow-list representation is more appropriate.

## Soft deletes

Use the framework `SoftDeletes` trait:

```php
use PixelFix\Framework\Database\Traits\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
}
```

The default deleted timestamp column is `deleted_at`.

Soft-deleted records are excluded from normal queries by the soft-delete global scope. The model API provides:

```php
Task::withTrashed();
Task::onlyTrashed();
Task::restoreById($id);
$task->restore();
$task->forceDelete();
```

## Dirty tracking

Models track original and changed attributes. Useful APIs include:

```php
$task->isDirty();
$task->getDirty();
$task->getChanges();
$task->wasChanged('status');
```

## Model lifecycle events and observers

Model lifecycle events include:

```text
creating
created
updating
updated
saving
saved
deleting
deleted
restoring
restored
```

Models can register lifecycle callbacks and observer objects through the model event facilities.

## Route keys

Models provide route-key support:

```php
$task->getRouteKey();
Task::getRouteKeyName();
```

A model can define a custom route key when URL binding should use something other than the primary key.

## Factories

Models can resolve their convention-based factory through:

```php
Task::factory();
```

See the factory documentation for generating records and related models.

## Full API reference

For the broader model method surface—including relationships, lifecycle events, dirty tracking, route binding, factories, and serialization—see [Model API Reference](model-reference.md).
