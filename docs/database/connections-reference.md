# Connection Reference

`PixelFix\\Framework\\Database\\Connection\\Connection` provides the framework's PDO-based database connection abstraction.

## Supported drivers

The connection layer currently recognizes these normalized drivers:

```text
mysql
pgsql
sqlite
sqlsrv
dblib
oci
firebird
ibm
informix
cubrid
odbc
```

It also normalizes aliases such as:

```text
mariadb      → mysql
postgres     → pgsql
postgresql   → pgsql
mssql        → sqlsrv
sqlserver    → sqlsrv
sqlazure     → sqlsrv
sqlite3      → sqlite
oracle       → oci
db2          → ibm
firebirdsql  → firebird
sybase       → dblib
```

## Connection inspection

The connection exposes:

```php
$connection->connectionName();
$connection->databaseName();
$connection->driver();
$connection->connected();
$connection->transactionLevel();
$connection->inTransaction();
```

Diagnostics and capability inspection are available through:

```php
$connection->metadata();
$connection->diagnostics();
$connection->healthCheck();
$connection->serverVersion();
```

## Direct SQL

For lower-level database work:

```php
$connection->select($sql, $bindings);
$connection->selectOne($sql, $bindings);
$connection->scalar($sql, $bindings);
$connection->statement($sql, $bindings);
$connection->affectingStatement($sql, $bindings);
$connection->execute($sql, $bindings);
```

Bindings are passed separately from SQL wherever possible.

## Transactions

Use:

```php
$connection->transaction(function () {
    // work
});
```

See [Database Transactions](transactions.md) for nesting, savepoints, retries, and commit hooks.

## Lock capability

The connection provides capability methods for code that needs to know whether a driver supports a lock feature:

```text
supportsSavepoints()
supportsAdvisoryLocks()
supportsForUpdate()
supportsForShare()
supportsSkipLocked()
supportsNoWait()
```

These checks are preferable to assuming all databases expose identical locking semantics.
