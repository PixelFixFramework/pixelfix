# Seeders

Seeders populate an application database with known or generated data.

## Creating a seeder

Generate one with:

```bash
php pixelfix make:seeder TaskSeeder
```

Application seeders live under:

```text
database/seeders
Database\\Seeders
```

## Seeder class

A seeder extends the framework base class:

```php
use PixelFix\Framework\Database\Seeders\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        // Populate data.
    }
}
```

## Calling other seeders

A root seeder can orchestrate other seeders:

```php
public function run(): void
{
    $this->call([
        UserSeeder::class,
        TaskSeeder::class,
    ]);
}
```

The framework tracks seeder execution and provides planning, inspection, diagnostics, and repository support around seed runs.

## Factory-backed seeding

The most common pattern is to create records through a factory:

```php
UserFactory::new()
    ->count(10)
    ->create();
```

## Seeder plans

A seeder can expose a `plan()` method describing its intended work:

```php
public function plan(): array
{
    return [
        'description' => 'Generate demo tasks',
        'factory' => TaskFactory::class,
        'records' => 10,
    ];
}
```

The framework uses this metadata for inspection and console output.

## Database seed commands

```bash
php pixelfix db:seed
php pixelfix db:seed --class=Database\\Seeders\\TaskSeeder
php pixelfix db:seed --list
php pixelfix db:seed --dry-run
php pixelfix db:seed --fresh
```

The optional positional seeder argument can be used when the application command resolver supports the corresponding seeder name.

## Task Manager example

`DatabaseSeeder` calls `UserSeeder` and `TaskSeeder` in that order because `TaskSeeder` expects at least one user to exist. This ordering is part of the application's data setup contract.
