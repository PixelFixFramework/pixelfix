# Build the Task Manager with PixelFix

This tutorial explains how the reference Task Manager is assembled. It is meant to be read alongside the Task Manager source code so you can connect each concept to a working example.

## Before you begin

You need an existing PixelFix application directory. If you are starting from an empty computer, first install and use the **separate PixelFix Installer**; its README explains project creation. Do not try to create a new project with the application's `pixel` launcher. The `pixel` launcher is used after the project exists.

Open a terminal in the application root—the directory containing `composer.json`, `pixel`, and `routes/`—and install dependencies if they are not already installed:

```powershell
composer install
```

If the repository already contains the Task Manager source, you do not need to recreate the application. Follow the steps below to understand how it is built.

## 1. Configure the local environment

If `.env` does not exist but `.env.example` does, copy the example and edit the values for your machine. Treat `.env` as private because it can contain credentials. Application settings are defined in the corresponding files under `config/`, such as `config/app.php` and `config/database.php`; a variable in `.env` has no effect unless a configuration file reads it.

## 2. Create the database schema

The reference application has `users` and `tasks` tables. A migration describes the columns and indexes; it does not insert example records. Review the files in `database/migrations/`, check the migration state, then apply pending migrations:

```powershell
php pixel migrate:status
php pixel migrate
```

Configure a supported database and its PHP PDO driver before running these commands. See [Database Connections](../database/connections.md).

## 3. Add example data

Factories describe how model attributes should be generated. Seeders use models and factories to insert records. The Task Manager includes a database seeder that creates a user and tasks associated with that user.

```powershell
php pixel db:seed --dry-run
php pixel db:seed
```

Review the seeder before using it against a database with data you need to preserve.

## 4. Understand the User and Task models

The `User` model integrates with PixelFix authentication and uses the framework's authenticatable model behavior. The `Task` model maps to the `tasks` table and allows the fields intended for assignment during create/update operations.

A task belongs to a user through `tasks.user_id`. Its relationship method can be used to retrieve the owner. Controllers should still check that the signed-in user is allowed to view or change a task; defining a relationship alone is not an access-control rule.

## 5. Follow the authentication flow

The browser routes include registration, login, and logout. The registration and login Form Requests validate incoming values before the controller changes account or session state. The login controller attempts authentication using the configured guard; the logout action clears the authenticated session.

Read [Task Manager Authentication](authentication.md) for the route-by-route flow. Authentication answers “who is signed in?”; authorization answers “what may this person do?”

## 6. Follow a task request

The task routes expose list, create, store, show, edit, update, and delete operations. For each request, trace the matching route, middleware, controller, validated input, policy check, model/database call, and view or redirect.

Start with `GET /tasks/{task}`. It is a good learning example because it loads one task, checks whether the user may view it, and renders the result.

## 7. Learn by changing one thing

Choose a small change, such as displaying a task's status, and follow the full path: database field/model property, controller data, Twig view or component, and a test. Avoid changing the controller, model, template, and migration at once; make one change and verify it before proceeding.

## Related guides

- [Quick Start](quick-start.md) — run and explore the application.
- [Trace a Request](trace-a-request.md) — follow one request through the framework.
- [Models](models.md) — understand model behavior.
- [Validation](validation.md) — validate user input.
- [Authorization](authorization.md) — protect task operations.
- [Testing](testing.md) — verify changes.
