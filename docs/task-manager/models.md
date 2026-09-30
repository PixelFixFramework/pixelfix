# Task Manager Models

The reference application has two primary models: `User` and `Task`.

## User

`User` extends PixelFix's base `Model`, uses `SoftDeletes`, and implements the framework's `Authenticatable` contract.

Its fillable fields are:

```text
name
email
password
remember_token
```

Sensitive authentication fields are hidden from normal serialization:

```text
password
remember_token
```

## Task

`Task` extends the base model and uses `SoftDeletes`.

Its fillable fields are:

```text
user_id
title
description
status
due_date
```

The `due_date`, deletion timestamp, and model timestamps are cast to `datetime`.

## Relationship

A task belongs to a user:

```php
public function user(): BelongsTo
{
    return $this->belongsTo(
        User::class,
        'user_id'
    );
}
```

This relationship is reflected in both the ORM model and the database foreign key.

## Ownership

The application's `TaskPolicy` uses `user_id` to determine whether the authenticated user may view, update, delete, restore, or force-delete a task.
