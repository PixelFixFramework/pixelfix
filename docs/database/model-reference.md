# Model Reference

`PixelFix\\Framework\\Database\\Models\\Model` is the framework's ORM base class. Application models normally extend it and configure their table, writable attributes, hidden attributes, casts, relationships, and optional traits.

## Basic model definition

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

## Query entry points

The model provides these common static operations:

```text
query()
all()
first()
find()
findOrFail()
create()
updateById()
deleteById()
where()
latest()
paginate()
with()
```

Examples:

```php
$task = Task::find($id);

$tasks = Task::where('status', 'completed')->get();

$task = Task::create([
    'title' => 'Write documentation',
    'status' => 'pending',
]);

Task::updateById($task->id, [
    'status' => 'completed',
]);
```

## Mass assignment

Use `$fillable` to define which attributes can be assigned by normal mass-assignment operations.

```php
protected static array $fillable = [
    'title',
    'status',
];
```

The model also exposes `fill()` and `forceFill()` for instance-level assignment.

## Attribute access

Attributes can be accessed naturally:

```php
$task->title;
$task->status = 'completed';
```

Array-style access is also implemented:

```php
$task['status'];
```

## Hidden and visible attributes

Models can restrict serialized attributes through `$hidden` and `$visible`.

```php
protected static array $hidden = [
    'password',
    'remember_token',
];
```

The Task Manager's `User` model uses this to prevent sensitive authentication fields from appearing in serialized model output.

## Attribute casting

Supported casts in the current model implementation include:

```text
int / integer
float / double / real
string
bool / boolean
array
object
json
datetime
```

Example:

```php
protected static array $casts = [
    'due_date' => 'datetime',
    'completed' => 'boolean',
];
```

Date/time casts are materialized as `DateTime` instances; array/object/json casts are serialized back to storage when necessary.

## Relationships

The model provides:

```text
belongsTo()
hasOne()
hasMany()
belongsToMany()
```

A Task Manager example is:

```php
public function user(): BelongsTo
{
    return $this->belongsTo(
        User::class,
        'user_id'
    );
}
```

Relationships can be lazily accessed from the model or eagerly loaded through `query()->with(...)`.

## Persistence lifecycle

Instance methods include:

```text
save()
delete()
restore()
forceDelete()
fresh()
refresh()
```

The model tracks original and changed attribute state with:

```text
syncOriginal()
isDirty()
getDirty()
getChanges()
wasChanged()
```

## Timestamps

Models can use automatic timestamp behavior. The model exposes `usesTimestamps()` and updates timestamp attributes during persistence when enabled.

## Soft deletes

The `SoftDeletes` trait adds:

```text
withTrashed()
onlyTrashed()
restore()
forceDelete()
```

At query time, soft deletion is represented through a global scope, so normal queries exclude records whose deleted timestamp is set.

## Route binding

Models expose route-binding helpers:

```text
getRouteKey()
getRouteKeyName()
resolveRouteBinding()
resolveRouteBindingOrFail()
```

The route key defaults to the model's primary key unless `$routeKey` is configured.

## Observers and lifecycle events

The model supports listeners for lifecycle events including:

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

Observers can be registered through `observe()`, and model event listeners can be cleared with `flushEventListeners()`.

## Factories

Models expose a factory entry point:

```php
Task::factory()->count(10)->create();
```

Factory behavior is defined by the application's factory class and its database conventions.
