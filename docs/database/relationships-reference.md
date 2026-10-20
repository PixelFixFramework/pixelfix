# Relationship Reference: Methods and Return Values

A model relationship describes how records in two tables are connected. Defining a relationship on a model does not automatically mean the related rows have already been queried. The methods below make the difference between defining a relation, retrieving results, checking whether anything exists, and changing the database explicit.

## `belongsTo`: this row stores the foreign key

Use `belongsTo` when the current model contains the foreign key. A task stores `user_id`, so a task belongs to a user:

```php
<?php

namespace App\Models;

use PixelFix\Framework\Database\Models\Model;
use PixelFix\Framework\Database\Relations\BelongsTo;

class Task extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
```

- `get()` / `getResults()` queries for the related model and returns a `Model` or `null` if no user is related.
- `exists()` returns `true` if a related row can be found, otherwise `false`.
- `associate($user)` puts the related user's key into the task's foreign-key attribute and returns the parent task model. Save the task to persist that change.
- `dissociate()` clears the foreign-key value and returns the parent task model; save it to persist the change. Only use this when the database column allows null.

Example:

```php
$task = Task::find($id);
if ($task === null) {
    throw new RuntimeException('Task not found.');
}

$user = $task->user()->get(); // User model or null
```

## `hasOne`: one related row points back to this row

Use `hasOne` when the foreign key is on the related table, such as `profiles.user_id`. This method belongs inside the `User` model class:

```php
public function profile(): HasOne
{
    return $this->hasOne(Profile::class);
}
```

`get()` / `getResults()` and `first()` return one related model or `null`. `exists()` returns a boolean. `save($profile)` sets the relation's foreign key on the supplied model, saves it, and returns the saved model. `create($attributes)` builds and saves the related model with the correct foreign key and returns the new model.

## `hasMany`: one parent can have multiple rows

Use `hasMany` when each related record stores the parent key, such as `tasks.user_id`. This method belongs inside the `User` model class:

```php
public function tasks(): HasMany
{
    return $this->hasMany(Task::class, 'user_id');
}
```

- `get()` / `getResults()` return a `Collection` containing the related models; an empty collection means no matching rows.
- `first()` returns the first matching model or `null`.
- `exists()` returns a boolean.
- `count()` returns the number of related rows.
- `save($model)` assigns the foreign key, saves the model, and returns it.
- `saveMany($models)` saves each supplied model and returns a `Collection` of saved models.
- `create($attributes)` creates one related model with the parent key set and returns the new model.
- `createMany($records)` creates several related models and returns a `Collection` of them.

Example:

```php
$user = User::find($id);
if ($user === null) {
    throw new RuntimeException('User not found.');
}

$tasks = $user->tasks()->get();

foreach ($tasks as $task) {
    echo $task->title;
}
```

Always handle the possibility that the parent user was not found before calling `tasks()`.

## `belongsToMany`: records are connected through a pivot table

Use this for a many-to-many relationship, such as users and roles through a `role_user` pivot table. This method belongs inside the `User` model class:

```php
public function roles(): BelongsToMany
{
    return $this->belongsToMany(Role::class, 'role_user');
}
```

- `get()` / `getResults()` return a `Collection` of related models.
- `exists()` returns a boolean and `count()` returns the number of connected rows.
- `attach($ids)` adds pivot rows for one or more related IDs/models and returns a boolean indicating success.
- `detach($ids)` removes pivot rows for the selected IDs; omitting the argument removes all related pivot rows for that parent. It returns a boolean.
- `sync($ids)` makes the pivot links match the supplied IDs and returns a result array describing the operation. It is not the same as `attach`: it may remove links that were not included.
- `withPivot($columns)` configures extra pivot-table columns to be included when retrieving related records and returns the relationship object for chaining.

Only use `sync()` when you mean “these are the complete set of related IDs now.” Use `attach()` when you mean “add this relationship but retain the others.”

## Avoiding repeated database queries

Eager loading fetches related records for a collection of parent models more efficiently than querying inside a loop:

```php
$tasks = Task::query()
    ->with('user')
    ->get();
```

The relation name passed to `with()` must match a relationship method on the model. Eager loading changes when related data is fetched; it does not bypass authorization or guarantee that the current user may see every related record.

See [Relationships](relationships.md) for the introductory guide and [Models](models.md) for querying model records.
