# Example Application Models: What the Models Represent

A **model** is the PHP class your application uses to work with a type of database record. In the Example Application, a `User` represents one row in `users`, and a `record` represents one row in `records`. PixelFix's base `Model` provides database operations; the application model adds the rules specific to that kind of record.

## The `User` model

The example application’s `app/Models/User.php` extends `PixelFix\Framework\Database\Models\Model`. It also uses the `SoftDeletes` trait and PixelFix's `Authenticatable` trait, and implements the framework's `Authenticatable` contract. Those additions let the model participate in sign-in and soft deletion.

The following shortened class example shows where `$fillable` and `$hidden` belong. In your project, keep the model's other methods, table configuration, casts, and traits as required by the application:

```php
<?php

namespace App\Models;

use PixelFix\Framework\Database\Models\Model;

class User extends Model
{
    protected static array $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
    ];

    protected static array $hidden = [
        'password',
        'remember_token',
    ];
}
```

`$fillable` controls which attributes may be assigned through mass-assignment operations such as `User::create($data)`. It is not a replacement for validation: validate request data first, and never let the request decide privileged fields without an explicit rule.

`$hidden` excludes sensitive attributes during normal model serialization. This matters if you return a model as JSON: the password hash and remember token should not be exposed in API output. The full Example Application `User` also implements PixelFix's authentication contract and uses the authentication and soft-delete traits described above.

## The `record` model

The record model stores `user_id`, `title`, `description`, `status`, and `due_date`. It casts date columns such as `due_date`, `deleted_at`, `created_at`, and `updated_at` to date-time values so application code can work with them consistently.

The `user_id` attribute identifies the owner. The controller assigns it from the authenticated user after validation; a browser form must not be trusted to choose the owner.

## Defining and using the relationship

A record belongs to one user. The following is a minimal complete example of the relationship's placement in `app/Models/record.php`. The full application model also declares its table, fillable attributes, casts, and soft-delete trait:

```php
<?php

namespace App\Models;

use PixelFix\Framework\Database\Models\Model;
use PixelFix\Framework\Database\Relations\BelongsTo;

class Record extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
```

This method defines the relationship; it does not itself fetch the user. The relationship can be used by the ORM to retrieve the user for a particular record. See [Relationship Types](../database/relationships.md) for the four relationship types and their query behavior.

## Common model operations

```php
// Find one record by its primary key; null means not found.
$record = Record::find($id);

// Retrieve all records visible to the model's normal query scope.
$records = Record::all();

// Create a record from attributes allowed by $fillable.
$record = Record::create([
    'user_id' => $user->id,
    'title' => 'Prepare report',
    'status' => 'pending',
]);
```

These examples assume `Record` is imported with `use App\Models\Record;`, a database connection is configured, and the migrations have been run. `Record::all()` returns a collection, not a single record. Use `find()` when you expect one record and handle the possibility that it is missing.

## Ownership is not the same as finding a record

`Record::find($id)` answers “does a record with this identifier exist?” It does not answer “is the current user allowed to see it?” The example application uses `RecordPolicy` to authorize view, update, delete, restore, and force-delete operations. Keep authorization checks even when you know the record exists.

## Soft deletion

Both `User` and `record` use `SoftDeletes`. Calling `delete()` normally records a deletion timestamp instead of removing the row. Normal queries hide the deleted record. See [Soft Deletes](../database/soft-deletes.md) for examples of viewing, restoring, or permanently removing deleted records.

## Where to look next

- [Migrations](../database/migrations.md) define the database columns.
- [Factories](../database/factories.md) create realistic sample records.
- [Validation](validation.md) explains why controller input must be validated.
- [Authorization](authorization.md) explains how the application protects each record.
