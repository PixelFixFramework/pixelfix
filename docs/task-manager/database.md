# Task Manager Database: Tables, Models, and Sample Data

The Task Manager uses a relational database. The `users` table stores accounts; the `tasks` table stores work items. Read the migration files when you need the authoritative schema: a migration is executable PHP that describes how the database should change.

## The `users` table

The users migration creates `id`, `name`, `email`, `password`, `remember_token`, `deleted_at`, `created_at`, and `updated_at`. `email` is unique so two user records cannot share the same email address. `deleted_at` supports soft deletion. `created_at` and `updated_at` record creation and modification times.

## The `tasks` table

The tasks migration creates `id`, `user_id`, `title`, `description`, `status`, `due_date`, `deleted_at`, `created_at`, and `updated_at`. The `user_id` column is a foreign key pointing to the owning user. `title` is a string, `description` is nullable text, `status` defaults to `pending`, and `due_date` is nullable. The task model casts date-related attributes so PHP code can work with date-time values.

## How the model maps to the table

`App\Models\Task` sets the table name to `tasks`, declares its fillable attributes, uses `SoftDeletes`, and describes the relationship to the owner:

```php
public function user(): BelongsTo
{
    return $this->belongsTo(User::class, 'user_id');
}
```

The relationship describes the database link; it does not by itself authorize access to the record. The controller/policy must still ensure that the signed-in user may see or change a particular task.

## Sample data from seeders

`DatabaseSeeder` invokes `UserSeeder` and `TaskSeeder`. The user seeder creates ten users using `UserFactory`. The task seeder finds the first user and creates ten tasks associated with that user's ID through `TaskFactory`. Seeded passwords and sample content are for local development—do not reuse demo credentials in a real deployment.

## Database setup workflow

```powershell
php pixel migrate
php pixel db:seed
```

First `migrate` creates the tables; then `db:seed` inserts sample records. If you change a migration after it has already run, editing the PHP file alone does not retroactively update the existing database. Create a new migration or use the project's documented reset workflow when it is safe to discard local data.

## Generating database artifacts

The command below asks PixelFix to generate a model and related artifacts:

```powershell
php pixel make:model Task --all
```

Use this when building a new model from scratch. For an existing Task Manager project, inspect the existing model and migrations first to avoid generating duplicate definitions. See [Models](../database/models.md), [Migrations](../database/migrations.md), [Factories](../database/factories.md), and [Seeders](../database/seeders.md).
