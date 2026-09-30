# Database Connections

Database connections are configured under the application's `database.connections` configuration and selected with `database.default`.

## Example configuration

```php
'database' => [
    'default' => env('DB_CONNECTION', 'mysql'),

    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('MYSQL_HOST', '127.0.0.1'),
            'port' => env('MYSQL_PORT', 3306),
            'database' => env('MYSQL_DATABASE', ''),
            'user' => env('MYSQL_USER', ''),
            'password' => env('MYSQL_PASSWORD', ''),
        ],
    ],
],
```

## Connection capabilities

The connection layer tracks driver capabilities for features such as:

```php
$connection->supportsSavepoints();
$connection->supportsAdvisoryLocks();
$connection->supportsForUpdate();
$connection->supportsForShare();
$connection->supportsSkipLocked();
$connection->supportsNoWait();
```

It also exposes transaction state and connection metadata.

## Transactions

Use the connection or database manager transaction wrapper:

```php
return db()->transaction(function () {
    // database work
});
```

The connection supports nested transaction levels where the underlying driver supports the required savepoint behavior.

## Raw SQL

When the Query Builder is not sufficient, execute a statement with bindings:

```php
db()->statement(
    'UPDATE tasks SET status = ? WHERE id = ?',
    ['completed', $id]
);
```

Use parameter bindings instead of interpolating untrusted input into SQL strings.

## Connection inspection

The connection exposes runtime information such as:

```php
$connection->driver();
$connection->databaseName();
$connection->serverVersion();
$connection->healthCheck();
$connection->metadata();
$connection->diagnostics();
```

These APIs are primarily useful for diagnostics and framework-level tooling.
