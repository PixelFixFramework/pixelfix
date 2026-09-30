# Migrations

Migrations describe database schema changes as versioned application code.

## Creating a migration

Use:

```bash
php pixelfix make:migration create_tasks_table
```

Migrations are stored under:

```text
database/migrations
```

and use the `Database\\Migrations` namespace convention for named migration classes. The generated application also uses anonymous migration classes in its current migrations.

## Migration class

A migration extends the framework base class:

```php
use PixelFix\Framework\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Apply change.
    }

    public function down(): void
    {
        // Reverse change.
    }
};
```

`up()` applies the change; `down()` reverses it.

## Schema definitions

Create a table with `Schema::create()`:

```php
use PixelFix\Framework\Database\Schema\Blueprint;
use PixelFix\Framework\Database\Schema\Schema;

Schema::create(
    'tasks',
    function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->timestamps();
    }
);
```

The Blueprint API supports common column types including:

```text
id
string
text
longText
integer
unsignedBigInteger
boolean
dateTime
foreignId
```

It also provides timestamps, soft deletes, remember-token columns, indexes, unique constraints, foreign keys, column alterations, and table-specific options.

## Foreign keys

The Task Manager uses:

```php
$table->foreignId(
    'user_id'
)->constrained();
```

This expresses the relationship between a task and its owning user in the database schema.

## Reversing a migration

A migration's `down()` method should remove or reverse everything introduced by `up()`:

```php
Schema::dropIfExists('tasks');
```

## Transactions

Migrations expose a `withinTransaction()` setting and protected helpers for enabling or disabling migration transactions:

```php
$this->useTransactions();
```

Whether transactional behavior is appropriate depends on the database driver's DDL capabilities.

## Migration commands

```bash
php pixelfix migrate
php pixelfix migrate:status
php pixelfix migrate:rollback
php pixelfix migrate:reset
php pixelfix migrate:refresh
php pixelfix migrate:fresh
```

All migration commands include `--force|-f` where supported by the current command and the migrate command also exposes `--dry-run|-d`.

`migrate:rollback` can receive a specific migration and supports `--reverse|-r`.

`migrate:status` can inspect a specific migration.

`migrate:fresh` drops all tables and runs the migrations again; use it only where rebuilding the database is acceptable.
