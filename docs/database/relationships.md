# Relationships

PixelFix models support these relationship types:

```text
BelongsTo
HasOne
HasMany
BelongsToMany
```

Relationships are defined as model methods.

## BelongsTo

A model that contains a foreign key can define:

```php
public function user(): BelongsTo
{
    return $this->belongsTo(
        User::class,
        'user_id'
    );
}
```

The relationship defaults to the related model's primary key as the owner key when it is not supplied.

## HasMany

A parent model can define a collection relationship:

```php
public function tasks(): HasMany
{
    return $this->hasMany(
        Task::class
    );
}
```

By convention, the related table uses the parent model name as the foreign-key basis unless a custom key is supplied.

## HasOne

```php
public function profile(): HasOne
{
    return $this->hasOne(
        Profile::class
    );
}
```

## BelongsToMany

Many-to-many relationships can specify the pivot table and key names explicitly:

```php
public function roles(): BelongsToMany
{
    return $this->belongsToMany(
        Role::class,
        'role_user',
        'user_id',
        'role_id'
    );
}
```

The relationship API also provides conventions for deriving default pivot and key values when they are omitted.

## Accessing relations

After a relation has been defined, the model can expose the loaded relation through normal property access:

```php
$user->tasks;
$task->user;
```

The model stores loaded relation values separately from scalar attributes and tracks whether a relation has already been loaded.

## Eager loading

The model and Query Builder support eager loading through `with()`:

```php
$tasks = Task::query()
    ->with(['user'])
    ->get();
```

This allows related records to be planned and loaded as part of the query workflow rather than repeatedly resolving a relationship in application loops.

Nested relationship paths can be supplied where supported by the relation loader.

## The Task Manager relationship

The Task Manager defines the task-to-user relationship:

```php
public function user(): BelongsTo
{
    return $this->belongsTo(
        User::class,
        'user_id'
    );
}
```

The `tasks` table therefore stores `user_id`, and the controller also uses that column as the ownership boundary for authorization and filtering.
