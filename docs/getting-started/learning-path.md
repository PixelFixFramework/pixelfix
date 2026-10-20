# Learning Path for New PixelFix Developers

This guide suggests an order for learning PixelFix if you have not used an MVC framework before. You do not need to understand the service container or ORM internals to build your first page.

## Stage 1: Understand the basic pieces

Read [Introduction](introduction.md), [Requirements](requirements.md), [Installation](installation.md), and [Application Structure](application-structure.md).

Learn these four terms first:

- **Route:** matches a URL and HTTP method to an action.
- **Controller:** receives the matched request, coordinates work, and returns a response.
- **Model:** represents data and uses the ORM to query or save it.
- **View:** renders HTML using Twig.

## Stage 2: Build one page

Follow [Build Your First PixelFix Page](first-application.md). Add one GET route, one controller method, and one Twig view. Confirm it works before adding a database or authentication.

Then read [Routing](../http/routing.md), [Controllers](../http/controllers.md), and [Views](../views/overview.md). These explain what happened in that first page and how to structure a larger one.

## Stage 3: Work with data

Read [Database Overview](../database/overview.md), [Connections](../database/connections.md), [Schema](../database/schema.md), [Migrations](../database/migrations.md), and [Models](../database/models.md).

Create a small table in a migration, apply the migration, define a model, and read/write one record. Add factories and seeders only after you can explain the difference: factories create sample attributes; seeders use application code to insert records.

## Stage 4: Validate input and protect actions

Read [Validation](../validation/overview.md) and [Form Requests](../validation/requests.md) before trusting data submitted by a browser. Then study [Authentication](../authentication/overview.md) to learn who the current user is, and [Authorization](../authorization/overview.md) to learn which actions that user is allowed to perform.

Authentication and authorization are not interchangeable. A signed-in user can still be forbidden from editing another user's record.

## Stage 5: Build maintainable pages

Read [Twig](../views/twig.md), [Layouts](../views/layouts.md), and [Templates and Components](../views/templates.md). Use `make:view` for a generic page view and compose it from components. Use `make:component` for a new component and `import:component` to bring in one of PixelFix's existing components.

## Stage 6: Test and troubleshoot

Read [Testing Overview](../testing/overview.md), [Unit Tests](../testing/unit-tests.md), and [Feature Tests](../testing/feature-tests.md). Add a test for important behavior when you add a route, validation rule, authorization policy, or database workflow.

If something fails, use [Troubleshooting](../reference/troubleshooting.md). Read the first relevant exception rather than changing several unrelated configuration values at once.

## Stage 7: Learn framework architecture only when needed

After building an application feature, study [Architecture Overview](../architecture/overview.md), [Dependency Injection](../architecture/dependency-injection.md), [Service Providers](../architecture/service-providers.md), and [Generator Architecture](../console/generator-architecture.md). These topics explain how PixelFix itself is assembled. They are useful, but not prerequisites for everyday controller/model/view work.

## A recommended practice project

The Task Manager tutorial ties the pieces together. Build it one feature at a time and make sure you understand what every route, request, model method, and component does instead of copying the entire tutorial without checking the intermediate result.
