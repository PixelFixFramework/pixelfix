# Public API and Internal Boundaries

PixelFix contains a large amount of framework infrastructure. Not every class under `src/` is intended to be consumed directly by an application.

This page defines the practical boundary used by the documentation.

## Application-facing APIs

Application code should normally work with these concepts:

```text
Routes
Controllers
Middleware
Requests / FormRequests
Responses
Views
Models / Query Builder
Migrations / Schema
Factories / Seeders
Authentication / Authorization
Pagination / API Resources
Filesystem / Sessions / Logging
Console commands and generators
Testing APIs
Global helpers and selected facades
```

Typical examples are:

```php
Route::get('/tasks', [TaskController::class, 'index']);

$tasks = Task::query()
    ->where('status', 'pending')
    ->get();

return view('tasks/index', [
    'tasks' => $tasks,
]);
```

## Framework-internal infrastructure

The framework also contains implementation services used to make the public APIs work. Examples include the generator discovery/planning/resolution services, route compilers and caches, hydration optimizers, relation loaders, and bootstrap coordination services.

These classes are useful when extending PixelFix itself, but application documentation should not treat them as stable application APIs unless a guide explicitly says so.

## How to recognize the boundary

The public documentation favors:

- stable entry points exposed by framework facades, helpers, base classes, and service contracts;
- application directory conventions such as `app/Http/Controllers`, `app/Models`, and `database/migrations`;
- CLI commands such as `make:model`, `migrate`, and `route:list`.

Internal documentation favors:

- implementation services that orchestrate other framework services;
- classes whose names describe a pipeline stage such as `*DiscoveryService`, `*PlanningService`, or `*ResolutionService`;
- compiler/cache objects and runtime coordination objects.

## Extending PixelFix

Framework contributors may use the internal APIs when adding framework capabilities. The generator architecture is the clearest example:

```text
Definition
    ↓
Discovery
    ↓
Validation
    ↓
Planning
    ↓
Generation
    ↓
Workflow
    ↓
Display
```

An application developer normally interacts with that pipeline through `php pixelfix make:*`, not by constructing every stage manually.

## Documentation policy

When an API is uncertain, prefer documenting the higher-level supported entry point. This keeps application code decoupled from implementation details that may change while preserving an architectural explanation for contributors.
