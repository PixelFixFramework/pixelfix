# Seeders

A seeder fills a database with known or generated records. Developers use seeders for sample data, development accounts, lookup tables, and repeatable local setup. A seeder is not a migration: a migration changes the schema, while a seeder inserts or updates data.

## Create a seeder

```powershell
php pixel make:seeder TaskSeeder --model=Task
```

Application seeders normally live in `database/seeders/` under the `Database\Seeders` namespace.

## Write the seeder

```php
use PixelFix\Framework\Database\Seeders\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        TaskFactory::new()->count(10)->create();
    }
}
```

`run()` contains the data-population work. In this example it asks the factory to create ten tasks. If tasks require a valid `user_id`, ensure a user exists and associate each generated task with that user.

## Call other seeders

A root seeder can coordinate several seeders:

```php
public function run(): void
{
    $this->call([
        UserSeeder::class,
        TaskSeeder::class,
    ]);
}
```

The list order is meaningful when one seeder depends on data created by another. In the Task Manager, users are seeded before tasks because a task belongs to a user.

## Seeder plans

A seeder may provide a `plan()` method that describes the expected work, such as its description, factory, and record count. The framework can use that metadata when displaying a seeding plan. The `run()` method remains the method that performs the actual work.

## Run or inspect seeders

```powershell
php pixel db:seed
php pixel db:seed --class="Database\Seeders\TaskSeeder"
php pixel db:seed --list
php pixel db:seed --dry-run
```

The default command runs the application's configured/root seeder. `--class` selects a specific seeder class; `--list` shows available seeders; `--dry-run` previews the action without writing seeded records. Verify the command's help for the exact class/name formats accepted by the installed version.

## Avoid unsafe production seed data

Seeders are executable code. Do not blindly run development seeders against production: they may create test accounts, overwrite known values, or generate large batches. Separate stable reference data from disposable demo data and review a seeder before executing it on a database containing valuable records.
