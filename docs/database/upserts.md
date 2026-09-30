# Upserts

PixelFix's Query Builder provides `upsert()` for insert-or-update operations based on one or more unique columns.

## Basic usage

```php
Task::query()->upsert(
    [
        [
            'user_id' => 1,
            'title' => 'Document PixelFix',
            'status' => 'pending',
        ],
        [
            'user_id' => 2,
            'title' => 'Review tests',
            'status' => 'completed',
        ],
    ],
    ['user_id', 'title']
);
```

The signature is:

```php
upsert(
    array $records,
    array|string $uniqueBy,
    ?array $updateColumns = null
): int
```

## Unique columns

`$uniqueBy` identifies the conflict key used by the target grammar. It may be a single string or an array:

```php
'email'
```

or:

```php
['tenant_id', 'email']
```

The builder rejects an empty unique-column list.

## Update columns

When `$updateColumns` is omitted, PixelFix updates all record columns except the unique columns.

To control the update set explicitly:

```php
Task::query()->upsert(
    $records,
    ['user_id', 'external_id'],
    ['title', 'status', 'updated_at']
);
```

## Record shape

Every record must be a non-empty array, and every record must contain the same columns as the first record. The builder validates this before compiling SQL.

An empty record set returns `0` without issuing a query.

## Database grammar

The active SQL grammar compiles the operation for the connection's database engine. PixelFix currently includes dedicated upsert compilation for MySQL, PostgreSQL, SQL Server, SQLite, and the shared SQL grammar infrastructure.

Applications should therefore call `upsert()` rather than embedding database-specific conflict SQL when the operation is expressible through the builder API.

## What `upsert()` returns

The method returns the number reported by the connection's affecting-statement operation. Do not interpret that value as a universal "number of inserted rows" across every database driver; it follows the underlying database driver's affected-row semantics.

## `updateOrInsert()` versus `upsert()`

Use `updateOrInsert()` for a single attribute match followed by an update or insert decision:

```php
Task::query()->updateOrInsert(
    ['external_id' => 'A-100'],
    ['status' => 'completed']
);
```

Use `upsert()` when submitting multiple records or when the database should perform a native conflict-aware operation in one statement.
