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


## A first database workflow

A safe workflow for a new table is:

1. Describe the table in a migration.
2. Apply the migration to a local development database.
3. Create a model that represents a row from that table.
4. Use the model or Query Builder to read and write records.
5. Add validation before accepting browser input.
6. Add authorization before reading or changing records belonging to a user.
7. Write tests for important database behavior.

A model is not a substitute for a migration: defining a PHP class does not create the table. Likewise, a migration does not automatically add application validation or user permissions. Those are separate responsibilities.

## Choosing between model and Query Builder

Use a model when rows represent application concepts with relationships, casts, scopes, or lifecycle behavior. Use the Query Builder when you need a direct table query or a focused aggregate. Both approaches use configured database connections, so connection and PDO-driver configuration must be correct before either can execute SQL.
