# Factories

Factories generate model instances and database records for development, tests, and seed data.

## Creating a factory

Generate one with:

```bash
php pixelfix make:factory TaskFactory
```

The convention is:

```text
database/factories
Database\\Factories
```

## Defining a factory

A factory declares the model it creates and a default attribute definition:

```php
class TaskFactory extends Factory
{
    protected function model(): string
    {
        return Task::class;
    }

    protected function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'status' => 'pending',
        ];
    }
}
```

## Creating records

```php
TaskFactory::new()
    ->count(10)
    ->create();
```

For an in-memory model without persistence:

```php
$task = TaskFactory::new()->makeOne();
```

The factory also provides `makeMany()`, `createMany()`, `raw()`, and corresponding single-record methods.

## States

Use `state()` to modify the base definition:

```php
$completed = TaskFactory::new()
    ->state([
        'status' => 'completed',
    ]);
```

A state can also be a callback receiving the resolved attributes and factory.

## Sequences

Use `sequence()` for rotating attribute states:

```php
TaskFactory::new()
    ->sequence(
        ['status' => 'pending'],
        ['status' => 'completed']
    )
    ->count(4)
    ->create();
```

The sequence cycles through its state definitions.

## Relationships

Factories can create related models with `has()` and associate a parent with `for()`:

```php
UserFactory::new()
    ->has(
        TaskFactory::new()->count(3)
    )
    ->create();
```

For a child factory:

```php
TaskFactory::new()
    ->for(
        UserFactory::new(),
        'user'
    )
    ->create();
```

Nested factories can also be supplied directly inside attribute arrays where supported by the factory resolver.

## Callbacks

Factories support lifecycle callbacks:

```php
->afterMaking(function ($model, $factory) {
    // ...
})
```

```php
->afterCreating(function ($model, $factory) {
    // ...
})
```

## Task Manager example

`TaskFactory` defines realistic titles, descriptions, statuses, and due dates. `UserFactory` creates users with hashed passwords. `TaskSeeder` uses `TaskFactory::new()->count(10)->create()` after locating an existing user so that generated tasks have an owner.
