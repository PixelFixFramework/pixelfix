# Architecture Overview

PixelFix is organized as a layered application framework. The application provides domain code while the framework supplies the runtime, infrastructure, and extension points that make the application executable.

## High-level architecture

```text
Application
    │
    ▼
bootstrap/app.php
    │
    ▼
Application
    │
    ├── Bootstrap Manager
    │       ├── Environment
    │       ├── Configuration
    │       ├── Core bindings
    │       ├── Service providers
    │       └── Console
    │
    ├── Container
    │
    ├── HTTP Kernel
    │       ├── Request
    │       ├── Routing
    │       ├── Middleware
    │       ├── Controllers
    │       └── Responses
    │
    ├── View system
    │       └── Twig
    │
    ├── Database
    │       ├── Connections
    │       ├── Query Builder
    │       ├── Models / ORM
    │       ├── Schema
    │       └── Migrations
    │
    └── Application services
            ├── Authentication
            ├── Authorization
            ├── Sessions
            ├── Storage
            ├── Logging
            └── Serialization / API Resources
```

## Application object

`PixelFix\Framework\Core\Application` is the central framework object.

It owns the application base path, the dependency-injection container, the bootstrap manager, the runtime manager, and the provider repository/manifest.

The application can:

- register container bindings;
- register and load service providers;
- execute the bootstrapper pipeline;
- boot providers;
- resolve services from the container;
- expose application paths and environment information;
- reset runtime state for a new execution context.

## Dependency injection

The framework uses a service container for object construction and shared services. The `Application` exposes methods such as:

```php
$app->bind(...);
$app->singleton(...);
$app->scoped(...);
$app->instance(...);
$app->make(...);
```

Framework and application services can therefore be registered and resolved without hard-coding their construction into every consumer.

## Service providers

Service providers are responsible for registering and booting groups of services.

During application bootstrap, PixelFix combines framework providers, discovered application providers, and explicitly configured providers. The resulting provider list is loaded into the application and then booted.

This allows framework subsystems such as routing, database access, sessions, views, storage, logging, HTTP, and ORM services to be initialized consistently.

## HTTP pipeline

The HTTP side of PixelFix uses a kernel, router, middleware resolver, route executor, and response abstractions.

At a conceptual level:

```text
Request
  ↓
Kernel
  ↓
Router
  ↓
Route middleware
  ↓
Route executor
  ↓
Controller / handler
  ↓
Response
```

The kernel can also apply global middleware and middleware priority rules.

## Database architecture

Database support is split into connection management, query execution, query building, schema operations, and ORM models/relationships.

This separation allows application code to use the higher-level model API when appropriate while retaining lower-level query and connection APIs for more specialized work.

## Console architecture

The console is exposed through `ConsoleKernel` and `Command` classes. Commands can be framework-provided or application-provided.

Generators are a specialized part of the console subsystem and are organized as a pipeline rather than as one monolithic file-writing operation.

The current generator architecture separates definition, discovery, validation, planning, generation, workflow, and display responsibilities.

## Presentation architecture

PixelFix uses Twig for server-rendered views. The view subsystem provides the framework integration layer around Twig rather than requiring controllers to construct Twig internals directly.

The Task Manager application demonstrates layouts, components, error views, and page templates under `resources/views`.

## Extension boundary

Application developers normally interact with the framework through:

- application classes and base classes;
- routing APIs;
- request and response APIs;
- model and query APIs;
- validation APIs;
- authentication and authorization APIs;
- service providers;
- console commands and generators;
- views and resources;
- testing utilities.

Internal compiler, discovery, planning, resolution, and generation infrastructure is documented separately where it is relevant to framework contributors.
