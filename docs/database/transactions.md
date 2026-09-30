# Database Transactions

PixelFix provides transaction support at the connection and query-builder layers.

## Query callback

A query builder can execute a callback inside a transaction:

```php
Task::query()->transaction(function () {
    // database operations
});
```

For broader application-level work, obtain the connection and use its transaction API directly.

## Connection transactions

`Connection::transaction()` accepts a callback and an optional attempt count:

```php
$result = db()
    ->connection()
    ->transaction(
        function () {
            // write operations

            return true;
        },
        3
    );
```

The default maximum attempt count is `3`.

## Retry behavior

When the callback throws, PixelFix rolls the transaction back. It retries only for the configured deadlock/serialization error codes currently recognized by the connection layer:

```text
1213
1205
40001
40P01
```

A retry uses a small increasing delay before starting the next attempt. Other exceptions are re-thrown immediately after rollback.

## Nested transactions

PixelFix tracks transaction nesting with `transactionLevel()`.

At the root level the connection starts a PDO transaction. At nested levels, savepoints are used when the active driver reports savepoint support.

```php
$connection->beginTransaction();

$connection->beginTransaction();

// nested work

$connection->rollBack();
$connection->commit();
```

The exact database behavior depends on whether the active driver supports savepoints.

## Before and after commit hooks

The connection supports:

```php
$connection->beforeCommit(function () {
    // work immediately before the root commit
});

$connection->afterCommit(function () {
    // work after a successful root commit
});
```

The hooks are associated with the connection's root commit. Rollback clears pending commit callbacks.

## Locking

The connection exposes explicit locking helpers, including:

```text
selectForUpdate()
selectForShare()
selectForUpdateSkipLocked()
selectForUpdateNoWait()
acquireLock()
releaseLock()
withLock()
```

The query builder also exposes:

```text
lockForUpdate()
sharedLock()
skipLocked()
noWait()
```

The availability of a particular lock mode is driver-dependent. Capability methods such as `supportsForUpdate()`, `supportsSkipLocked()`, and `supportsNoWait()` exist for inspection.

## Safe transaction design

A transaction should contain the smallest coherent set of operations that must succeed or fail together:

```php
$connection->transaction(function () use ($userData, $taskData) {
    $user = User::create($userData);

    Task::create([
        ...$taskData,
        'user_id' => $user->id,
    ]);
});
```

Keep external side effects outside the transaction unless they are deliberately coordinated with the commit boundary.
