# Application Walkthrough

This walkthrough uses a small example application to demonstrate PixelFix in a complete working context.

Rather than presenting each framework feature only through isolated snippets, the example shows how multiple framework services can cooperate in a real application.

## Application structure

A typical implementation may contain:

```text
app/
├── Http/
│   ├── Controllers/
│   └── Requests/
├── Models/
├── Policies/
└── Providers/

database/
├── factories/
├── migrations/
└── seeders/

resources/views/
routes/
tests/
```

## Main domain objects

The illustrative data model centers on two classes:

```text
User
Record
```

Users authenticate into the application, while records belong to users and are managed through the record controller and record policy.

## HTTP features demonstrated

The illustrative implementation defines browser routes for:

- the welcome page;
- registration;
- login and logout;
- record listing;
- record creation;
- record display;
- record editing;
- record updating;
- record deletion.

The browser routes are grouped under the `web` middleware stack.

## Validation

The example uses dedicated Form Request classes rather than placing all validation logic directly in controllers.

Examples include:

```text
LoginRequest
RegisterUserRequest
StoreRecordRequest
UpdateRecordRequest
StoreUserRequest
UpdateUserRequest
```

Controllers receive the request object and can obtain validated data through the request API.

## Authentication

Authentication is configured around a session-based `web` guard and a database-backed user provider. The `User` model implements PixelFix's authenticatable contract and uses the framework's soft-delete support.

## Authorization

The example demonstrates two complementary authorization mechanisms.

### Gates

`AuthServiceProvider` defines the `access-admin` gate:

```php
Gate::define(
    'access-admin',
    function ($user): bool {
        return $user->role === 'admin';
    }
);
```

### Policies

`PolicyServiceProvider` registers:

```text
User        → UserPolicy
Record      → RecordPolicy
```

The `RecordPolicy` contains model-oriented authorization methods for viewing, creating, updating, deleting, restoring, and force-deleting records.

## Database features demonstrated

The example implementation includes:

- user and record migrations;
- `UserFactory` and `RecordFactory`;
- `DatabaseSeeder` plus dedicated user and record seeders;
- ORM-backed `User` and `Record` models;
- a configured database connection; SQLite is one supported option for local development.

## Views

The example uses Twig templates under:

```text
resources/views/
```

It includes layouts, page views, form components, navigation components, feedback components, error pages, and record-specific views.

## Documentation role

The Application Walkthrough explains the example feature by feature:

```text
Application setup
      ↓
Users and authentication
      ↓
Records and database schema
      ↓
Controllers and routes
      ↓
Validation
      ↓
Authorization
      ↓
Views
      ↓
Testing
```

Each stage will point back to the corresponding PixelFix framework guide.
