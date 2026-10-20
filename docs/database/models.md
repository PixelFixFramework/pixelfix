# Models

PixelFix models are application classes that extend `PixelFix\Framework\Database\Models\Model`.

## Creating a model

Generate a model with:

```bash
php pixel make:model Task
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

## Return model data from an API

A model collection can be returned as JSON from a route:

```php
use App\Models\User;
use PixelFix\Framework\Routing\Route;

Route::get('/users', function () {
    return response()->json(User::all());
});
```

The response factory serializes the collection to a JSON list. That is convenient for an internal endpoint, but be careful about which model fields are exposed. For a public API with a stable field list, use an API resource that explicitly builds the response. See [Returning JSON from a Route or Controller](../http/json-responses.md) and [API Resources](../api/resources.md).

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

Soft deletes hide records from ordinary queries without immediately removing the rows from the database. To enable them, import and use the trait and add a nullable `deleted_at` column to the table migration:

```php
use PixelFix\Framework\Database\Traits\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
}
```

Calling `$task->delete()` sets the deletion timestamp. `Task::all()` and other ordinary model queries then omit that row. The row remains available for a recycle-bin, restore, or retention workflow.

The retrieval helpers return query builders, so follow them with `get()`, `find()`, or another query operation:

```php
$activeTasks = Task::query()->get();
$activeAndDeleted = Task::withTrashed()->get();
$deletedOnly = Task::onlyTrashed()->get();
```

- `withTrashed()` removes the soft-delete scope, so matching active **and** deleted records can be queried.
- `onlyTrashed()` removes the scope and adds a condition requiring `deleted_at` to be non-null, so only deleted records are returned.
- `Task::restoreById($id)` finds a record including deleted records, then attempts to restore it. It returns `true` or `false`, not the model instance.
- `$task->restore()` clears `deleted_at`. The record becomes visible to normal queries again; the method returns a boolean success result.
- `$task->forceDelete()` permanently removes the database row. This cannot be undone with `restore()`.

These methods are not interchangeable: `withTrashed()` and `onlyTrashed()` prepare queries, while `restoreById()`, `restore()`, and `forceDelete()` perform actions. Read [Soft Deletes](soft-deletes.md) for the required migration, complete examples, return values, and safety considerations.

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
