# Database Connection Reference

A database connection is the configured path between PixelFix and the database server or file. Most application code should use models and the query builder; the connection API is for lower-level SQL, transaction control, and diagnostics.

## Connection state and identity

```php
$connection->connectionName();
$connection->databaseName();
$connection->driver();
$connection->connected();
$connection->transactionLevel();
$connection->inTransaction();
```

- `connectionName()` returns the configured connection's name.
- `databaseName()` returns the database name or file identifier used by that connection.
- `driver()` returns the normalized driver name (for example, `mysql`, `pgsql`, or `sqlite`).
- `connected()` tells you whether a PDO connection has been established.
- `transactionLevel()` reports the current nesting level tracked by PixelFix.
- `inTransaction()` tells you whether the connection currently reports an active transaction.

These methods inspect the connection; they do not reconnect or migrate your database.

## Health and diagnostics

```php
$connection->healthCheck();     // bool
$connection->serverVersion();   // string
$connection->metadata();        // array
$connection->diagnostics();     // array
```

`healthCheck()` performs a connection health probe and returns a boolean result. `serverVersion()` returns the database server/version string when it can be obtained. `metadata()` and `diagnostics()` return structured arrays intended for inspection and troubleshooting. Do not show raw connection details or credentials to untrusted users; keep diagnostics in logs available to administrators.

## Executing SQL

The connection accepts SQL and bindings separately. Use parameter bindings for values rather than concatenating user input into the SQL string:

```php
$rows = $connection->select(
    'SELECT id, email FROM users WHERE email = ?',
    [$email]
);
```

`select()` returns an array of row objects. Each object represents one matching row; an empty array means no rows matched. The related methods serve different purposes:

- `selectOne($sql, $bindings)` returns one row object or `null` when no row matches.
- `scalar($sql, $bindings)` returns the first column of the first row (or `null` if there is no row), useful for a single value.
- `statement($sql, $bindings)` executes a statement and reports success as a boolean.
- `affectingStatement($sql, $bindings)` executes a write statement and returns the affected-row count.
- `execute($sql, $bindings)` returns the executed `PDOStatement`, useful when you need to inspect the statement object directly.

Prefer the model/query-builder APIs for normal CRUD work because they centralize model conventions, scopes, casts, and soft-delete behavior. Direct SQL does not automatically provide those higher-level behaviors.

## Transactions

Use a transaction when several database writes must succeed or fail as one unit:

```php
$result = $connection->transaction(function () use ($connection) {
    $connection->statement(
        'UPDATE accounts SET balance = balance - ? WHERE id = ?',
        [10, 1]
    );

    $connection->statement(
        'UPDATE accounts SET balance = balance + ? WHERE id = ?',
        [10, 2]
    );

    return true;
});
```

The transaction wrapper commits if the callback completes normally and rolls back when it throws. Use bound values, validate inputs first, and confirm that both target accounts exist before making a real transfer. See [Database Transactions](transactions.md) for nested transactions and retry behavior.

## Driver capability checks

The connection exposes `supportsSavepoints()`, `supportsAdvisoryLocks()`, `supportsForUpdate()`, `supportsForShare()`, `supportsSkipLocked()`, and `supportsNoWait()`. These methods return booleans. Check a capability before depending on a driver-specific lock feature; not every database supports the same locking syntax.

The recognized driver names and aliases are a normalization list, not a promise that a PDO driver is installed in the current PHP environment. If connection creation fails, check `PDO::getAvailableDrivers()` for the PHP executable running the application.
