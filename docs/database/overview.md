# Database

PixelFix provides a database layer built around connections, a fluent Query Builder, an Active Record-style ORM model, schema definitions, migrations, factories, seeders, relationships, and pagination.

## Main database layers

```text
Application
    ↓
Model / ORM
    ↓
Query Builder
    ↓
Connection
    ↓
PDO / database driver
```

The framework also provides a database manager for obtaining query builders, executing statements, transactions, and MongoDB collections when the MongoDB connection is in use.

## Supported SQL drivers

The `Connection` class currently recognizes these PDO drivers:

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

Driver aliases such as `mariadb`, `postgres`, `postgresql`, `mssql`, `sqlserver`, `sqlite3`, `oracle`, `db2`, `firebirdsql`, and `sybase` are normalized to their supported driver names.

PixelFix also contains a separate MongoDB connection implementation when the MongoDB PHP package is installed and configured.

## Database helper

The global `db()` helper resolves the framework `DatabaseManager`:

```php
$db = db();
```

Common operations include:

```php
$db->table('tasks');
$db->query();
$db->select($sql, $bindings);
$db->selectOne($sql, $bindings);
$db->scalar($sql, $bindings);
$db->statement($sql, $bindings);
$db->transaction($callback);
```

## Query Builder vs ORM

Use the Query Builder when you need direct table-oriented queries:

```php
$tasks = db()
    ->table('tasks')
    ->where('status', 'pending')
    ->get();
```

Use the ORM when the application wants model behavior, relationships, casts, model lifecycle callbacks, scopes, authorization targets, or model factories:

```php
$tasks = Task::query()
    ->where('status', 'pending')
    ->get();
```

Both approaches ultimately use the framework's database connection and SQL grammar layer.
