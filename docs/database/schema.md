# Database Schema

PixelFix migrations define schema changes through `Schema` and `Blueprint`.

## Creating a table

```php
Schema::create(
    'tasks',
    function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->timestamps();
    }
);
```

## Common column helpers

The current `Blueprint` API includes helpers such as:

```php
$table->id();
$table->string('name');
$table->text('description');
$table->integer('priority');
$table->boolean('active');
$table->dateTime('due_date');
$table->foreignId('user_id')->constrained();
$table->timestamps();
$table->softDeletes();
$table->rememberToken();
```

It also supports indexes, unique constraints, foreign keys, column alterations, and engine/charset/collation configuration.

## Foreign keys

The Task Manager declares its task owner with:

```php
$table->foreignId(
    'user_id'
)->constrained();
```

This expresses the database relationship between a task and a user at the schema level.

## Reversible migrations

Each migration should implement both `up()` and `down()`:

```php
public function up(): void
{
    // Apply change.
}

public function down(): void
{
    // Reverse change.
}
```

Use `migrate:rollback`, `migrate:reset`, or other migration commands documented in the CLI reference to reverse or rebuild schema state during development.
