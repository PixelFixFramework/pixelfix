# Database Schema

A database schema is the structure of your database: tables, columns, indexes, and relationships between records. In PixelFix, schema changes belong in migrations so that the application can apply them consistently in development, testing, and production.

## Create a table

A migration can use the schema facade and a table blueprint:

```php
Schema::create('tasks', function ($table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->timestamps();
});
```

This defines a `tasks` table with an auto-generated primary key, a required string title, an optional description, and created/updated timestamps. The callback describes the structure; the migration command applies it to the configured database.

## Common column helpers

- `id()` adds an auto-incrementing primary key suitable for a record identifier.
- `string('name')` adds a string/varchar column.
- `text('description')` stores longer text; `nullable()` allows the field to be `NULL` when no value is available.
- `integer()`, `boolean()`, and `dateTime()` add columns with corresponding data types.
- `timestamps()` adds `created_at` and `updated_at` columns.
- `softDeletes()` adds a nullable `deleted_at` column used by the ORM's soft-delete behavior.
- `foreignId('user_id')->constrained()` declares a foreign-key-style relationship to the referenced table using the framework's conventions.

Choose nullable columns deliberately. A non-null column must have a value during insertion unless the database supplies a default.

## Foreign keys

A task often belongs to a user. The schema expresses the stored reference using:

```php
$table->foreignId('user_id')->constrained();
```

The `user_id` column records the owner; the Task model's `belongsTo(User::class, 'user_id')` method exposes that relationship to PHP. The database constraint protects referential integrity while the model relationship makes it convenient to navigate related records.

## Indexes and uniqueness

Indexes help the database find rows efficiently. Unique indexes also prevent duplicate values, such as two accounts with the same email address. Add a unique constraint for rules that must hold even if two requests arrive simultaneously; validation alone cannot prevent every concurrent duplicate insertion.

## Reversible migrations

Each migration should define both `up()` and `down()`:

```php
public function up(): void
{
    // Apply the schema change.
}

public function down(): void
{
    // Reverse the schema change.
}
```

`up()` performs the change; `down()` describes how to reverse it. Review the rollback before running a command that reverses migration history, especially when data could be lost.
