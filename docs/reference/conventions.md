# Application Conventions

PixelFix works best when applications follow the conventions used by the generator and the Task Manager reference application.

## Directory conventions

Use application-owned code under:

```text
app/
├── Http/Controllers
├── Http/Requests
├── Models
├── Policies
└── Providers
```

Keep database-owned artifacts under:

```text
database/
├── factories
├── migrations
└── seeders
```

Place Twig templates under:

```text
resources/views
```

Define routes under:

```text
routes/web.php
routes/api.php
routes/console.php
```

## Naming

Generated classes are PSR-4 classes whose names correspond to their artifact type:

```text
TaskController
StoreTaskRequest
TaskPolicy
TaskFactory
TaskSeeder
CreateTasksTable
```

The exact generated filename and namespace follow the current generator conventions.

## Models

A model normally declares at least:

```php
protected static string $table = 'tasks';
```

and often a `$fillable` list:

```php
protected static array $fillable = [
    'title',
    'status',
];
```

Keep sensitive fields in `$hidden` when they may be serialized.

## Controllers

Controllers should coordinate a request rather than contain every business rule.

A common flow is:

```text
authorize
→ read validated input
→ perform application/database work
→ return a response
```

The Task Manager follows this structure closely.

## Form requests

Put input validation and request-specific authorization in `app/Http/Requests`.

Controllers can then use:

```php
$data = $request->validated();
```

rather than repeatedly reading and validating raw input.

## Policies

Put model authorization rules in policies when access depends on the authenticated user and a model instance.

For example:

```text
TaskPolicy::view
TaskPolicy::update
TaskPolicy::delete
```

This keeps controllers focused on orchestration.

## Database safety

Prefer the ORM/query builder over hand-written SQL where the framework API expresses the operation clearly.

Use raw SQL only for deliberate cases and keep raw expressions narrowly scoped.

The query builder also rejects unsafe unqualified deletes when no `where` clause is present. Treat that guard as a safety feature rather than bypassing it casually.

## HTTP verbs

Use the HTTP verb that matches the operation:

```text
GET     read/display
POST    create
PUT     replace/update
PATCH   partial update
DELETE  remove
```

The Task Manager's task routes follow this pattern.

## Views

Use Twig templates for presentation and reusable components. Pass explicit data from controllers:

```php
return view('tasks/show', [
    'task' => $task,
]);
```

Avoid putting database queries inside templates.

## Configuration

Read environment-backed values through the configuration layer rather than scattering `getenv()` calls throughout application classes.

Use:

```php
config('app.name');
env('APP_ENV', 'production');
```

## Documentation convention

When writing application documentation, distinguish clearly between:

```text
Framework behavior
Application configuration
Application-specific behavior
```

The Task Manager documentation uses this distinction throughout.
