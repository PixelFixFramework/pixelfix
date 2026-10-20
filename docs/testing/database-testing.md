# Database Testing

Database tests check that application behavior persists the correct information. A response can look successful while the wrong row was written, a foreign key was omitted, or a soft delete was performed incorrectly—database assertions catch those failures.

## Add the database assertion trait

```php
use PixelFix\Framework\Testing\TestCase;
use PixelFix\Framework\Testing\Database\InteractsWithDatabase;

class TaskTest extends TestCase
{
    use InteractsWithDatabase;
}
```

The trait adds assertions for checking table content. Prepare the application/database test environment before running a test and keep each test independent from data inserted by another test.

## Check that a row exists

```php
$this->assertDatabaseHas('tasks', [
    'title' => 'Write documentation',
    'status' => 'pending',
]);
```

`assertDatabaseHas()` passes when at least one row matches the table and attributes. It is useful after a create or update action to verify the persisted result, not merely the input passed to the model.

Other assertions include:

```php
$this->assertDatabaseMissing('tasks', ['id' => $missingId]);
$this->assertDatabaseCount('tasks', 10);
$this->assertDatabaseEmpty('tasks');
$this->assertDatabaseNotEmpty('tasks');
```

These check absence, exact row count, and whether a table is empty or non-empty.

## Assert soft-delete state

```php
$this->assertSoftDeleted('tasks', ['id' => $taskId]);
$this->assertNotSoftDeleted('tasks', ['id' => $taskId]);
```

These assertions examine the deletion state, which is different from asserting that a row has disappeared. With soft deletes, the row remains but its `deleted_at` column is not `NULL`.

## Seed test data

The trait can invoke a seeder:

```php
$this->seed(\Database\Seeders\UserSeeder::class);
```

Use a seeder when its data setup is part of the scenario. For a focused test, constructing only the records required by the test can make failures easier to understand and keep the test fast.

## Test design

Assert database facts that matter to the feature: the correct owner ID, status, timestamp, and presence/absence of related rows. Avoid asserting only a table-wide count when a more specific row assertion would reveal an incorrect write.
