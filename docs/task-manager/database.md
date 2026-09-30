# Task Manager: Database

The Task Manager uses a relational SQLite database in its reference project and contains users and tasks as the primary domain tables.

## Users table

The users migration creates:

```text
id
name
email
password
remember_token
deleted_at
created_at
updated_at
```

The email field is unique.

## Tasks table

The task migration creates:

```text
id
user_id
title
description
status
due_date
deleted_at
created_at
updated_at
```

The `user_id` column is a foreign key to the owning user.

## Task model

`Task` extends the framework `Model`, uses `SoftDeletes`, and declares its fillable fields and date-time casts.

It defines:

```php
public function user(): BelongsTo
{
    return $this->belongsTo(
        User::class,
        'user_id'
    );
}
```

## User model

`User` also uses soft deletes. In addition to normal model behavior, it implements PixelFix authentication through the framework authenticatable contract and trait.

Its password and remember token are hidden from serialized output.

## Seeding

`DatabaseSeeder` calls:

```text
UserSeeder
TaskSeeder
```

`UserSeeder` creates 10 users through `UserFactory`.

`TaskSeeder` locates the first user and creates 10 tasks through `TaskFactory`, assigning that user's identifier to `user_id`.

## Generating the database layer

The intended developer workflow is:

```bash
php pixelfix make:model Task --all
```

This can generate the model and related artifact definitions used by the generator system. Migrations, factories, seeders, and other generated artifacts can also be created individually with their respective make commands.
