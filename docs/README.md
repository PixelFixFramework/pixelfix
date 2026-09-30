# PixelFix Documentation

PixelFix is a PHP application framework for building web applications with an MVC-oriented architecture and integrated developer tooling.

## Start here

[Introduction](getting-started/introduction.md) → [Requirements](getting-started/requirements.md) → [Installation](getting-started/installation.md) → [Application Structure](getting-started/application-structure.md)

## Architecture

- [Architecture Overview](architecture/overview.md)
- [Application Lifecycle](architecture/application-lifecycle.md)
- [Public API and Internal Boundaries](architecture/public-api.md)
- [Dependency Injection](architecture/dependency-injection.md)
- [Service Providers](architecture/service-providers.md)

## HTTP

- [Routing](http/routing.md)
- [Controllers](http/controllers.md)
- [Requests](http/requests.md)
- [Responses](http/responses.md)
- [Response Reference](http/response-reference.md)
- [Middleware](http/middleware.md)
- [CSRF Protection](http/csrf.md)
- [Route Model Binding](http/route-model-binding.md)
- [Route Inspection and Caching](http/route-cache.md)
- [Middleware Reference](http/middleware-reference.md)

## Validation

- [Validation Overview](validation/overview.md)
- [Form Requests](validation/requests.md)
- [Validation Rules](validation/rules.md)
- [Validation Rule Reference](validation/rule-reference.md)
- [Custom Rules](validation/custom-rules.md)

## Views

- [Views Overview](views/overview.md)
- [Twig Integration](views/twig.md)
- [Templates and Components](views/templates.md)
- [Layouts](views/layouts.md)

## Database

- [Database Overview](database/overview.md)
- [Connections](database/connections.md)
- [Query Builder](database/query-builder.md)
- [Query Builder Reference](database/query-builder-reference.md)
- [Models](database/models.md)
- [Model Reference](database/model-reference.md)
- [Relationships](database/relationships.md)
- [Migrations](database/migrations.md)
- [Schema](database/schema.md)
- [Scopes](database/scopes.md)
- [Soft Deletes](database/soft-deletes.md)
- [Transactions](database/transactions.md)
- [Upserts](database/upserts.md)
- [Connection Reference](database/connections-reference.md)
- [Relationships Reference](database/relationships-reference.md)
- [ORM Lifecycle and State](database/orm-lifecycle.md)
- [Model Events and Observers](database/model-events-observers.md)
- [Factories](database/factories.md)
- [Seeders](database/seeders.md)

## Authentication and authorization

- [Authentication Overview](authentication/overview.md)
- [Guards](authentication/guards.md)
- [User Providers](authentication/providers.md)
- [Token Authentication](authentication/tokens.md)
- [Password Reset Infrastructure](authentication/password-reset.md)
- [Authentication Reference](authentication/auth-reference.md)
- [Authorization Overview](authorization/overview.md)
- [Gates](authorization/gates.md)
- [Policies](authorization/policies.md)
- [Policy Reference](authorization/policy-reference.md)

## API and application services

- [API Resources](api/resources.md)
- [Pagination](api/pagination.md)
- [Serialization](api/serialization.md)
- [Filesystem](application/filesystem.md)
- [Sessions](application/sessions.md)
- [Logging](application/logging.md)
- [Exception Handling](application/exceptions.md)
- [Helper Reference](reference/helpers.md)
- [Configuration Reference](reference/configuration.md)
- [Environment Reference](reference/environment.md)
- [Application Conventions](reference/conventions.md)
- [Release and Publishing](reference/releasing.md)
- [Troubleshooting](reference/troubleshooting.md)
- [Routing API Reference](http/routing-reference.md)

## Console and generators

- [Console Overview](console/overview.md)
- [CLI Reference](reference/cli.md)
- [Console Command Reference](console/command-reference.md)
- [Generators](console/generators.md)
- [Generator Architecture](console/generator-architecture.md)
- [Custom Commands](console/custom-commands.md)
- [Stubs](console/stubs.md)

## Testing

- [Testing Overview](testing/overview.md)
- [Test Runner](testing/test-runner.md)
- [Unit Testing](testing/unit-tests.md)
- [Integration Testing](testing/integration-tests.md)
- [Feature Testing](testing/feature-tests.md)
- [Database Testing](testing/database-testing.md)

## Task Manager

The Task Manager is the living reference application used throughout the documentation.

- [Introduction](task-manager/introduction.md)
- [Quick Start](task-manager/quick-start.md)
- [Feature Map](task-manager/features.md)
- [End-to-End Build](task-manager/end-to-end-build.md)
- [Complete Tutorial](task-manager/tutorial.md)
- [Building Features](task-manager/building-features.md)
- [Routing](task-manager/routing.md)
- [Controllers](task-manager/controllers.md)
- [Validation](task-manager/validation.md)
- [Views](task-manager/views.md)
- [Authentication](task-manager/authentication.md)
- [Authorization](task-manager/authorization.md)
- [Models](task-manager/models.md)
- [Database](task-manager/database.md)
- [Testing](task-manager/testing.md)
- [Trace a Task Manager Request](task-manager/trace-a-request.md)

## Documentation source of truth

When documentation conflicts with an older example, conversation, or generated artifact, the current PixelFix framework source code, its tests, and the current Task Manager implementation take precedence.
