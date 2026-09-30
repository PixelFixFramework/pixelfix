# Query Builder Reference

`PixelFix\\Framework\\Database\\Query\\QueryBuilder` provides fluent SQL query construction and execution. Model queries are normally obtained through `Model::query()`, while table-oriented queries can use `table()` or `forTable()`.

## Starting a query

```php
$users = User::query()->get();

$tasks = Task::query()
    ->where('status', 'pending')
    ->orderBy('created_at', 'desc')
    ->get();
```

For a table without a model:

```php
$rows = QueryBuilder::forTable('users')->get();
```

## Selecting

```php
$query->select(['id', 'name']);
$query->addSelect('email');
$query->distinct();
```

Raw SQL expressions are available through:

```php
$query->select([
    QueryBuilder::raw('COUNT(*) AS total'),
]);
```

Use raw expressions only when the SQL is trusted and intentional.

## Filtering

The current builder includes:

```text
where
orWhere
whereNull
whereNotNull
orWhereNull
orWhereNotNull
whereIn
orWhereIn
whereRaw
orWhereRaw
whereExists
whereNotExists
search
```

Examples:

```php
Task::query()
    ->where('user_id', $user->id)
    ->whereIn('status', ['pending', 'in_progress'])
    ->whereNull('deleted_at')
    ->get();
```

## Ordering and limiting

```php
$query->orderBy('created_at', 'desc');
$query->orderByDesc('created_at');
$query->orderByAsc('title');
$query->orderByRaw('created_at DESC');
$query->limit(20);
$query->offset(40);
```

## Grouping and aggregation

```php
$query
    ->select(['status'])
    ->select(QueryBuilder::raw('COUNT(*) AS total'))
    ->groupBy('status')
    ->having('total', '>', 5)
    ->get();
```

The builder also provides:

```text
count()
max()
min()
avg()
sum()
```

## Retrieving records

```php
$query->get();
$query->first();
$query->firstOrFail();
$query->sole();
$query->find($id);
$query->findOrFail($id);
$query->exists();
$query->doesntExist();
$query->value('name');
$query->pluck('email');
```

Model-backed queries hydrate model instances. Table-oriented queries return generic row objects.

## Inserts and updates

```php
$query->insert([
    'name' => 'Alice',
]);

$id = $query->insertGetId([
    'name' => 'Alice',
]);

$query->where('id', $id)->update([
    'name' => 'Updated',
]);
```

The builder also provides `updateOrInsert()` and `upsert()` for database-specific conflict handling generated through the active SQL grammar.

## Incrementing values

```php
$query->where('id', $id)->increment('attempts');
$query->where('id', $id)->increment('attempts', 3);
$query->where('id', $id)->decrement('attempts');
```

## Deletion and truncation

```php
$query->where('id', $id)->delete();
$query->truncate();
```

`truncate()` is a destructive table-level operation and should be used carefully, especially outside development/test environments.

## Pagination and large result sets

The builder supports:

```text
paginate()
chunk()
chunkById()
cursor()
lazy()
```

Use `chunk()`/`chunkById()` when processing records in batches and `cursor()`/`lazy()` when the application should avoid loading the complete result set into memory at once.

## Eager loading

Model-backed queries can request relations up front:

```php
Task::query()
    ->with('user')
    ->get();
```

The relation loader handles the eager-loading plan and attaches the related models to the hydrated parents.

## Row locking

The current builder exposes:

```text
lockForUpdate()
sharedLock()
skipLocked()
noWait()
lockMode()
usesSkipLocked()
usesNoWait()
```

These features are translated by the active SQL grammar where supported by the target database.

## Transactions

The builder exposes a transaction callback:

```php
$query->transaction(function () {
    // database work
});
```

For application-wide transaction code, prefer the database services already registered by the framework so transaction boundaries remain clear.

## SQL inspection

During development, the builder exposes:

```php
$query->toSql();
$query->rawSql();
$query->dump();
$query->dd();
```

`toSql()` returns the parameterized SQL representation; `rawSql()` expands the current bindings for inspection.

## Global scopes

Model queries can carry registered global scopes. The builder provides:

```php
$query->withoutGlobalScope('scope-name');
$query->withoutGlobalScopes();
```

This is especially relevant to soft deletes, which are implemented as a global scope.
