# PixelFix Application

A starter application for building web applications with the PixelFix Framework.

## Developer

**Neene Kaseba Ned**  
Developer and Creator of PixelFix Framework.

**Zambia Air Services Training Institute**  
310198, KK International Airport  
Lusaka, Zambia

**Email:** [neene@zasti.ac.zm](mailto:neene@zasti.ac.zm)  
**Phone:** (+260) 976-032-099 | (+260) 969-889-084

# 📚 Documentation

The PixelFix documentation is organized into the sections below.

## Getting Started

- [Introduction](./docs/getting-started/introduction.md)
- [Requirements](./docs/getting-started/requirements.md)
- [Installation](./docs/getting-started/installation.md)
- [First Application](./docs/getting-started/first-application.md)
- [Application Structure](./docs/getting-started/application-structure.md)
- [Configuration](./docs/getting-started/configuration.md)

## Architecture

- [Architecture Overview](./docs/architecture/overview.md)
- [Application Lifecycle](./docs/architecture/application-lifecycle.md)
- [Dependency Injection](./docs/architecture/dependency-injection.md)
- [Service Providers](./docs/architecture/service-providers.md)
- [Public API](./docs/architecture/public-api.md)

## HTTP

- [Routing](./docs/http/routing.md)
- [Routing Reference](./docs/http/routing-reference.md)
- [Route Model Binding](./docs/http/route-model-binding.md)
- [Route Cache](./docs/http/route-cache.md)
- [Controllers](./docs/http/controllers.md)
- [Requests](./docs/http/requests.md)
- [Responses](./docs/http/responses.md)
- [Response Reference](./docs/http/response-reference.md)
- [Middleware](./docs/http/middleware.md)
- [Middleware Reference](./docs/http/middleware-reference.md)
- [CSRF](./docs/http/csrf.md)

## Database

- [Database Overview](./docs/database/overview.md)
- [Connections](./docs/database/connections.md)
- [Connections Reference](./docs/database/connections-reference.md)
- [Schema](./docs/database/schema.md)
- [Migrations](./docs/database/migrations.md)
- [Models](./docs/database/models.md)
- [Model Reference](./docs/database/model-reference.md)
- [ORM Lifecycle](./docs/database/orm-lifecycle.md)
- [Query Builder](./docs/database/query-builder.md)
- [Query Builder Reference](./docs/database/query-builder-reference.md)
- [Relationships](./docs/database/relationships.md)
- [Relationships Reference](./docs/database/relationships-reference.md)
- [Scopes](./docs/database/scopes.md)
- [Soft Deletes](./docs/database/soft-deletes.md)
- [Transactions](./docs/database/transactions.md)
- [Upserts](./docs/database/upserts.md)
- [Model Events & Observers](./docs/database/model-events-observers.md)
- [Factories](./docs/database/factories.md)
- [Seeders](./docs/database/seeders.md)

## Authentication

- [Authentication Overview](./docs/authentication/overview.md)
- [Authentication Reference](./docs/authentication/auth-reference.md)
- [Guards](./docs/authentication/guards.md)
- [Providers](./docs/authentication/providers.md)
- [Tokens](./docs/authentication/tokens.md)
- [Password Reset](./docs/authentication/password-reset.md)

## Authorization

- [Authorization Overview](./docs/authorization/overview.md)
- [Gates](./docs/authorization/gates.md)
- [Policies](./docs/authorization/policies.md)
- [Policy Reference](./docs/authorization/policy-reference.md)

## Console & Generators

- [Console Overview](./docs/console/overview.md)
- [Command Reference](./docs/console/command-reference.md)
- [Custom Commands](./docs/console/custom-commands.md)
- [Generators](./docs/console/generators.md)
- [Generator Architecture](./docs/console/generator-architecture.md)
- [Stubs](./docs/console/stubs.md)

## Validation

- [Validation Overview](./docs/validation/overview.md)
- [Validation Requests](./docs/validation/requests.md)
- [Validation Rules](./docs/validation/rules.md)
- [Rule Reference](./docs/validation/rule-reference.md)
- [Custom Rules](./docs/validation/custom-rules.md)

## Views

- [Views Overview](./docs/views/overview.md)
- [Templates](./docs/views/templates.md)
- [Twig](./docs/views/twig.md)
- [Layouts](./docs/views/layouts.md)

## API

- [Pagination](./docs/api/pagination.md)
- [Resources](./docs/api/resources.md)
- [Serialization](./docs/api/serialization.md)

## Application

- [Exceptions](./docs/application/exceptions.md)
- [Filesystem](./docs/application/filesystem.md)
- [Logging](./docs/application/logging.md)
- [Sessions](./docs/application/sessions.md)

## Testing

- [Testing Overview](./docs/testing/overview.md)
- [Test Runner](./docs/testing/test-runner.md)
- [Unit Tests](./docs/testing/unit-tests.md)
- [Integration Tests](./docs/testing/integration-tests.md)
- [Feature Tests](./docs/testing/feature-tests.md)
- [Database Testing](./docs/testing/database-testing.md)

## Reference

- [CLI Reference](./docs/reference/cli.md)
- [Configuration Reference](./docs/reference/configuration.md)
- [Conventions](./docs/reference/conventions.md)
- [Environment](./docs/reference/environment.md)
- [Helpers](./docs/reference/helpers.md)
- [Releasing](./docs/reference/releasing.md)
- [Troubleshooting](./docs/reference/troubleshooting.md)

## Task Manager

- [Task Manager Introduction](./docs/task-manager/introduction.md)
- [Task Manager Quick Start](./docs/task-manager/quick-start.md)
- [Task Manager Tutorial](./docs/task-manager/tutorial.md)
- [Authentication](./docs/task-manager/authentication.md)
- [Authorization](./docs/task-manager/authorization.md)
- [Building Features](./docs/task-manager/building-features.md)
- [Controllers](./docs/task-manager/controllers.md)
- [Database](./docs/task-manager/database.md)
- [Models](./docs/task-manager/models.md)
- [Routing](./docs/task-manager/routing.md)
- [Testing](./docs/task-manager/testing.md)
- [Trace a Request](./docs/task-manager/trace-a-request.md)
- [Validation](./docs/task-manager/validation.md)
- [Views](./docs/task-manager/views.md)
- [Features](./docs/task-manager/features.md)
- [End-to-End Build](./docs/task-manager/end-to-end-build.md)

## Documentation Map

- [Complete Documentation Map](./docs/documentation-map.md)

## Requirements

- PHP 8.2+
- Composer
- Git

## Create an application

PixelFix applications are distributed through Packagist as the `pixelfix/pixelfix` project package.

```bash
composer create-project pixelfix/pixelfix my-app