# Query Builder

`PixelFix\Framework\Database\Query\QueryBuilder` provides a fluent database API for reads, writes, aggregation, locking, pagination, transactions, and raw SQL inspection.

## Starting a query

Use the database helper for table-oriented queries:

```php
$query = db()->table('tasks');
```

Or start from a model:

```php
$query = Task::query();
```

## Selects and distinct results

```php
$rows = db()->table('tasks')
    ->select(['id', 'title', 'status'])
    ->distinct()
    ->get();
```

The builder supports `select()` and `addSelect()` for projection.

## Filtering

The main `where()` method supports a column/operator/value form, a short equality form, arrays of equality conditions, and nested closures.

```php
Task::query()
    ->where('status', 'pending')
    ->get();
```

```php
Task::query()
    ->where('status', '!=', 'completed')
    ->get();
```

```php
Task::query()
    ->where([
        'status' => 'pending',
        'user_id' => $user->id,
    ])
    ->get();
```

For grouped conditions:

```php
Task::query()
    ->where(function ($query) {
        $query->where('status', 'pending')
            ->orWhere('status', 'in_progress');
    })
    ->get();
```

Null checks and membership are available through:

```php
->whereNull('deleted_at')
->whereNotNull('due_date')
->whereIn('status', ['pending', 'in_progress'])
->orWhereIn('status', ['completed'])
```

The builder also supports `whereRaw()`, `orWhereRaw()`, `whereExists()`, `whereNotExists()`, and `search()`.

## Joins

The builder provides `join()`, `leftJoin()`, and `rightJoin()` for relational queries.

```php
$tasks = db()
    ->table('tasks')
    ->join(
        'users',
        'users.id',
        '=',
        'tasks.user_id'
    )
    ->select([
        'tasks.id',
        'tasks.title',
        'users.name',
    ])
    ->get();
```

## Grouping, ordering, limit, and offset

```php
$query
    ->groupBy('status')
    ->having('COUNT(*)', '>', 1)
    ->orderBy('created_at', 'desc')
    ->limit(25)
    ->offset(50);
```

Convenience methods `orderByAsc()` and `orderByDesc()` are available.

## Reading results

The builder supports:

```php
get()
first()
firstOrFail()
sole()
find($id)
findOrFail($id)
exists()
doesntExist()
value($column)
pluck($column)
```

It also provides `cursor()`, `chunk()`, `chunkById()`, and `lazy()` for processing larger datasets incrementally.

## Aggregates

```php
$query->count();
$query->sum('amount');
$query->avg('amount');
$query->min('amount');
$query->max('amount');
```

## Inserts and updates

```php
db()->table('tasks')->insert([
    'title' => 'Write documentation',
    'status' => 'pending',
]);
```

```php
$id = db()->table('tasks')->insertGetId([
    'title' => 'Write documentation',
]);
```

Updates respect the builder's current constraints:

```php
db()->table('tasks')
    ->where('id', $id)
    ->update([
        'status' => 'completed',
    ]);
```

`updateOrInsert()` combines a lookup condition with insert/update behavior.

## Upserts

```php
db()->table('tasks')->upsert(
    $records,
    ['external_id'],
    ['title', 'status', 'updated_at']
);
```

The SQL is delegated to the active grammar, so database-specific conflict syntax can differ while the builder API remains stable.

## Deleting rows

```php
db()->table('tasks')
    ->where('id', $id)
    ->delete();
```

Use model `delete()` when model lifecycle events, relationships, or soft deletes are part of the domain behavior.

## Transactions

For multiple operations that must succeed or fail together:

```php
db()->transaction(function () {
    // Database operations.
});
```

The builder also exposes transaction support, but the database-manager entry point is usually clearer for application-level transaction boundaries.

## Locks

The builder supports:

```php
->lockForUpdate()
->sharedLock()
->skipLocked()
->noWait()
```

The active database driver must support the selected locking mode.

## SQL inspection

For debugging and query inspection:

```php
$query->toSql();
$query->rawSql();
$query->dump();
```

Use raw SQL deliberately. Prefer parameterized builder APIs for values so the framework can manage bindings safely.
