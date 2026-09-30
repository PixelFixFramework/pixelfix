# Introduction

## What is PixelFix?

PixelFix is a PHP framework for building web applications. The framework provides the application runtime and common infrastructure needed by a typical MVC application, including routing, HTTP request and response handling, controllers, middleware, validation, views, database access, ORM features, authentication, authorization, sessions, console tooling, migrations, factories, seeders, API resources, pagination, filesystem access, logging, and testing support.

The framework is distributed as the Composer package `pixelfix/framework` and targets PHP 8.2 or later.

## The application model

A PixelFix application is a separate project that uses the framework package. Application code lives outside the framework source tree and normally contains application-specific models, controllers, requests, policies, providers, routes, views, database definitions, and tests.

A generated application follows this general structure:

```text
app/
├── Http/
│   ├── Controllers/
│   └── Requests/
├── Models/
├── Policies/
└── Providers/

bootstrap/
config/
database/
├── factories/
├── migrations/
└── seeders/

docs/
public/
resources/
routes/
storage/
tests/
```

The exact contents of an application may change as the application grows.

## Framework and application responsibilities

PixelFix separates framework infrastructure from application behavior.

The framework supplies the machinery:

- the service container;
- application bootstrap and provider loading;
- HTTP and routing infrastructure;
- middleware execution;
- validation and request objects;
- views and Twig integration;
- database connections, query building, schema management, migrations, ORM features, factories, and seeders;
- authentication and authorization infrastructure;
- console commands and code generation;
- testing utilities and framework diagnostics.

The application supplies the domain behavior:

- application models and their business rules;
- application controllers and requests;
- application policies and providers;
- application routes;
- views and user-interface components;
- database migrations, factories, and seeders specific to the application;
- application tests.

## A real application example

The Task Manager reference application uses PixelFix for authentication, authorization, routing, validation, ORM-backed tasks and users, migrations, factories, seeders, sessions, Twig views, and testing.

For example, task creation in the application follows this general flow:

```text
HTTP request
    ↓
Route
    ↓
TaskController
    ↓
StoreTaskRequest validation
    ↓
Authorization
    ↓
Task model
    ↓
Database
    ↓
Redirect / rendered response
```

This relationship between framework services is a recurring theme throughout the documentation.

## Design goals

PixelFix is organized around a few practical principles:

1. **Convention through application structure.** Generated applications have predictable locations for common application artifacts.
2. **Services through dependency injection.** Core services are resolved through the framework container.
3. **Explicit application bootstrapping.** An application defines a bootstrap pipeline and loads service providers before serving requests.
4. **Composable HTTP processing.** Routes, middleware, controllers, validation, responses, and views participate in a defined request lifecycle.
5. **Framework tooling.** The console and generator systems are part of the development workflow rather than separate scripts.
6. **Testable infrastructure.** The framework contains unit, integration, feature, and runtime-oriented tests, and applications can maintain their own test suite.

## Where to go next

Start with the requirements and installation guides, then read the application structure guide before moving into the architecture documentation.
