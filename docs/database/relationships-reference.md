# Relationship Reference

PixelFix's ORM includes four primary relationship types.

## `belongsTo`

Use when the current table stores the foreign key pointing to another model:

```php
public function user(): BelongsTo
{
    return $this->belongsTo(
        User::class,
        'user_id'
    );
}
```

A `Task` therefore belongs to a `User` through `user_id` in the Task Manager.

Useful relation operations include:

```text
get()
getResults()
eagerLoad()
exists()
associate()
dissociate()
```

## `hasOne`

Use when one related record references the current model.

```php
return $this->hasOne(Profile::class);
```

The relation supports retrieval, eager loading, existence checks, and creation/saving helpers.

## `hasMany`

Use when one parent has multiple related rows:

```php
return $this->hasMany(Task::class);
```

The relation supports:

```text
get()
getResults()
eagerLoad()
first()
exists()
count()
save()
saveMany()
create()
createMany()
```

## `belongsToMany`

Use for many-to-many relationships through a pivot table:

```php
return $this->belongsToMany(
    Role::class,
    'role_user'
);
```

The relation supports:

```text
attach()
detach()
sync()
withPivot()
exists()
count()
```

## Eager loading

Avoid repeated relation queries by requesting relations on the query:

```php
$tasks = Task::query()
    ->with('user')
    ->get();
```

Nested relation loading is supported by the framework relation loader.

## Relationship metadata

Relationship objects expose their related and foreign/local key configuration. This is useful when implementing framework extensions or debugging generated relationships.
