# Task Manager Reference Application

The Task Manager is the reference application used to demonstrate PixelFix in a complete working context.

Rather than presenting each framework feature only through isolated examples, the Task Manager shows how multiple framework services cooperate to implement a real application.

## Application structure

The current application contains:

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

The application currently centers on two models:

```text
User
Task
```

Users authenticate into the application, while tasks belong to users and are managed through the task controller and task policy.

## HTTP features demonstrated

The application defines browser routes for:

- the welcome page;
- registration;
- login and logout;
- task listing;
- task creation;
- task display;
- task editing;
- task updating;
- task deletion.

The browser routes are grouped under the `web` middleware stack.

## Validation

The application uses dedicated Form Request classes rather than placing all validation logic directly in controllers.

Examples include:

```text
LoginRequest
RegisterUserRequest
StoreTaskRequest
UpdateTaskRequest
StoreUserRequest
UpdateUserRequest
```

Controllers receive the request object and can obtain validated data through the request API.

## Authentication

Authentication is configured around a session-based `web` guard and a database-backed user provider. The `User` model implements PixelFix's authenticatable contract and uses the framework's soft-delete support.

## Authorization

The application demonstrates two complementary authorization mechanisms.

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
Task        → TaskPolicy
```

The `TaskPolicy` contains model-oriented authorization methods for viewing, creating, updating, deleting, restoring, and force-deleting tasks.

## Database features demonstrated

The application includes:

- user and task migrations;
- `UserFactory` and `TaskFactory`;
- `DatabaseSeeder` plus dedicated user and task seeders;
- ORM-backed `User` and `Task` models;
- a SQLite development database in the supplied proof-of-concept archive.

## Views

The application uses Twig templates under:

```text
resources/views/
```

It includes layouts, page views, form components, navigation components, feedback components, error pages, and task-specific views.

## Documentation role

The Task Manager documentation will progressively rebuild or explain the application feature by feature:

```text
Application setup
      ↓
Users and authentication
      ↓
Tasks and database schema
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
