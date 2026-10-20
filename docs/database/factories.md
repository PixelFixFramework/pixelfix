# Factories

A factory describes how to create model attributes for realistic test and development data. It keeps sample-data rules out of controllers and makes it easier to create many related records in a repeatable way.

## Create a factory

```powershell
php pixel make:factory TaskFactory --model=Task
```

Factory classes normally live in `database/factories/` under the `Database\Factories` namespace.

## Define the data

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

`model()` tells the factory which model to create. `definition()` returns the default attribute values. The Faker helper generates plausible text or other values so every test does not need to hard-code a title.

## Build records or just attributes

To create ten tasks in the database:

```php
$tasks = TaskFactory::new()
    ->count(10)
    ->create();
```

`create()` persists records and returns the created model(s). For an in-memory model without writing to the database:

```php
$task = TaskFactory::new()->makeOne();
```

Use `makeOne()` when a unit test needs a model-shaped object but should not require a database. Use `create()` when the test is about persistence or a database-backed workflow.

Other factory methods include `raw()` for attributes, `makeMany()` for in-memory models, and `createMany()` for persisted records. The returned value differs by method, so choose based on whether you need an array of attributes, one model, a collection of models, or rows saved to the database.

## Change one or more fields with a state

```php
$completedTaskFactory = TaskFactory::new()
    ->state(['status' => 'completed']);
```

A state overlays values on top of the default definition. This lets a test create a completed task without duplicating the title and other common fields. A sequence can rotate through several states across a batch.

## Create related records

Factories support related-model helpers such as `has()` and `for()`:

```php
UserFactory::new()
    ->has(TaskFactory::new()->count(3))
    ->create();
```

This expresses the intent “create a user with three tasks.” Related factories are particularly useful when a database schema requires a valid owner foreign key.

## Callbacks

`afterMaking()` runs after a model has been built in memory; `afterCreating()` runs after it has been persisted. Use these callbacks for related setup that must happen at the corresponding stage, not as a place for unrelated application business logic.

## Task Manager example

The Task Manager's task factory produces plausible titles and statuses. Its task seeder first ensures a user exists, then creates tasks associated with that user. The ordering matters because a task's `user_id` represents ownership.
