# Database Testing

PixelFix provides the `InteractsWithDatabase` trait for tests that need direct database assertions.

## Using the trait

```php
use PixelFix\Framework\Testing\TestCase;
use PixelFix\Framework\Testing\Database\InteractsWithDatabase;

class TaskTest extends TestCase
{
    use InteractsWithDatabase;

    // ...
}
```

## Database assertions

The trait provides:

```php
$this->assertDatabaseHas(
    'tasks',
    ['title' => 'Write documentation']
);

$this->assertDatabaseMissing(
    'tasks',
    ['title' => 'Unknown task']
);

$this->assertDatabaseCount('tasks', 10);
$this->assertDatabaseEmpty('tasks');
$this->assertDatabaseNotEmpty('tasks');
```

It also includes soft-delete assertions:

```php
$this->assertSoftDeleted(
    'tasks',
    ['id' => $taskId]
);

$this->assertNotSoftDeleted(
    'tasks',
    ['id' => $taskId]
);
```

## Seeding inside tests

The trait provides:

```php
$this->seed(\Database\Seeders\UserSeeder::class);
```

The seeder is resolved through the framework's `SeederRunner` and executed in the test application.

## Test design

Database assertions should verify persisted behavior rather than only re-checking the same values passed into the model. For example, after creating a task through a feature workflow, assert that the task exists in the database with the expected owner and status.
