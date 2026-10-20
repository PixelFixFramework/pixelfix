# Performance and Scalability: Make Database Work Predictable

Performance is not achieved by one magic configuration switch. In a PixelFix application, most avoidable slowness comes from doing unnecessary database work, returning too much data, repeatedly querying related records, performing expensive work inside the HTTP request, or failing to add indexes for the queries the application actually runs.

This guide explains techniques the current framework supports and clearly distinguishes them from infrastructure that the application must provide separately.

## 1. Measure before optimizing

Start by identifying the slow endpoint or operation. Record which request is slow, whether the delay is in the database or rendering layer, and how much data it touches. Reproduce the same request with representative data; a table with ten rows rarely exposes problems that appear with hundreds of thousands.

For a query builder during local development, inspect SQL and bindings:

```php
$query = Task::query()
    ->where('status', '=', 'open')
    ->orderBy('created_at', 'desc');

$sql = $query->toSql();
$bindings = $query->bindings();
```

`toSql()` shows the SQL statement template; `bindings()` shows the values bound separately. Avoid dumping sensitive values to production output or logs. The query builder also offers `dump()` and `dd()` for development inspection; do not leave a `dd()` call in a live code path because it intentionally stops execution.

## 2. Ask the database for only the needed columns

Avoid retrieving columns the page never uses:

```php
$tasks = Task::query()
    ->select(['id', 'title', 'status', 'created_at'])
    ->where('user_id', '=', $userId)
    ->orderBy('created_at', 'desc')
    ->paginate(25);
```

This fetches the fields used by this listing and only the current page. Keep any columns required for relationships and model identifiers when selecting a subset. Selecting fewer columns can reduce data transfer and hydration costs, but it does not replace a suitable index or query plan.

## 3. Paginate user-facing lists

Use `paginate()` before retrieving rows:

```php
$tasks = Task::query()
    ->where('user_id', '=', auth()->id())
    ->orderBy('created_at', 'desc')
    ->paginate(25);
```

The database query stays bounded to a page of 25 records, while the paginator also calculates the total count for page navigation. Do not call `get()` and then slice an in-memory collection; by that point the large result set has already been fetched. Understand the trade-off: regular pagination may execute a count query in addition to the page query.

For very large data exports, use chunking or a generator rather than building one enormous in-memory array.

## 4. Avoid repeated relation queries

Suppose a page shows 100 tasks and reads `$task->user->name` for every row. If the relation is not eager loaded, code that looks simple may trigger repeated database queries. Use eager loading when the relationship is known in advance:

```php
$tasks = Task::query()
    ->with('user')
    ->where('status', '=', 'open')
    ->paginate(25);
```

The related model name in `with()` must match a relationship method defined on `Task`, for example:

```php
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

Use the relationship signature and namespace supported by the existing relationship in your model. Eager loading is not automatically beneficial for every query: load relations you actually consume, and check the number of SQL statements with real data.

## 5. Process large tables in bounded batches

For a maintenance task that updates many rows, avoid loading every model at once. `chunk()` processes offset-based batches; `chunkById()` advances by a key and is generally safer when the callback changes rows that could affect the query's filter/order.

```php
Task::query()
    ->where('status', '=', 'archived')
    ->chunkById(500, function ($tasks): void {
        foreach ($tasks as $task) {
            // Perform a small, bounded operation for this task.
        }
    });
```

The callback receives one collection per batch. Keep each batch small enough for the available memory and database. For `chunkById()`, use a stable, monotonically ordered key. If changing the key or the query's eligibility conditions, examine whether records could be skipped or revisited.

Other APIs include `cursor()` and `lazy()` for generator-based iteration. These do not mean that arbitrary downstream work is free; a long-running export may still hold a database connection open and consume time. Handle exceptions, use progress logging carefully, and provide a way to stop/restart large jobs if they are operationally important.

## 6. Add indexes based on real query patterns

If every request filters tasks by `user_id` and sorts by `created_at`, investigate an index that supports those columns. A migration can add a composite index:

```php
Schema::table('tasks', function (Blueprint $table): void {
    $table->index(['user_id', 'created_at']);
});
```

This is an example pattern; the best index depends on the database engine, query predicate, sort order, selectivity, and write volume. Indexes consume storage and add work to inserts/updates. Do not add an index for every column without a reason.

Keep schema migrations as code, inspect the SQL produced by your database driver, and test the queries against representative data. An index helps only if the query planner can use it for the actual expression and ordering.

## 7. Use transactions to protect multi-step changes

When a business operation must write several related records, wrap those writes in a transaction so they commit or roll back together:

```php
$result = Task::query()->transaction(function () use ($taskData, $auditData) {
    $taskId = Task::query()->insertGetId($taskData);

    AuditEntry::create([
        ...$auditData,
        'task_id' => $taskId,
    ]);

    return $taskId;
});
```

This example is illustrative: use the transaction method on the actual query/connection context used by the application, and verify that the related model writes use the same connection. A transaction cannot make operations on unrelated external systems—such as a remote HTTP request—atomic with the database.

Keep transactions short. Do not hold locks while waiting for user input or a slow network call. If two users can update the same row concurrently, decide whether last-write-wins is acceptable or whether you need a version/checking strategy or supported row locks.

## 8. Use parameter binding; do not interpolate request data into SQL

This is safe because the value is bound:

```php
$query->where('email', '=', $email);
```

This is unsafe:

```php
$sql = "SELECT * FROM users WHERE email = '$email'";
```

Do not build SQL by concatenating raw user input. Raw query methods such as `whereRaw()` are for SQL fragments that you control; use placeholders and a separate bindings array for values. SQL identifiers (such as a requested sort column) generally cannot be treated as ordinary bound values, so validate those names against an explicit allowlist.

## 9. Treat lock methods as database-specific tools

The query builder provides methods such as `lockForUpdate()`, `sharedLock()`, `skipLocked()`, and `noWait()`. Use these only after confirming that the configured database driver and server version support the relevant locking syntax and semantics. Locks are meaningful in a transaction; they are not a substitute for a correct transaction boundary or an authorization check. Test concurrent behavior against the real target database, not only an in-memory test database.

## 10. Understand the framework's performance boundaries

PixelFix includes query-builder conveniences, eager loading, pagination, chunked iteration, transactions, route caching, and configured Twig template caching. In this source version, it does **not** include a general application data-cache store/facade, a background job queue, a scheduler, or a distributed task worker. Do not write documentation or application code that assumes `Cache::remember()`, a queue worker, or a scheduled-job subsystem exists unless your application installs or implements one.

A production system can integrate external caching and job infrastructure, but it must define invalidation, serialization, retry, timeout, failure recovery, observability, and deployment procedures. Those are design responsibilities, not automatic features of PixelFix.

## 11. A practical performance review checklist

For a slow page or API endpoint, ask:

1. Does the query retrieve only the rows and columns needed?
2. Is it scoped to the current user/tenant before retrieval?
3. Is the list paginated or processed in bounded batches?
4. Are relationship queries eager loaded only when needed?
5. Do the filter and sort columns have appropriate indexes?
6. Are repeated calculations or queries occurring inside loops?
7. Are transactions short and locks used only when justified?
8. Is SQL inspected without logging credentials or personal data?
9. Has the operation been tested against representative volume and the production database engine?
10. If background processing is needed, has the application deliberately added a queue/worker integration rather than pretending the framework already provides one?

Related reading: [Query Builder](../database/query-builder.md), [Query Builder Reference](../database/query-builder-reference.md), [Relationships](../database/relationships.md), [Pagination](../api/pagination.md), [Transactions](../database/transactions.md), and [Capability Matrix](../reference/capability-matrix.md).
