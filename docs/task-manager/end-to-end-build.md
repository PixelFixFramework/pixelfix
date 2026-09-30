# Building the Task Manager End to End

This guide describes the feature-building sequence demonstrated by the reference application.

## 1. Create the application

Create a PixelFix application and install its dependencies:

```bash
php pixelfix new task-manager
composer install
```

## 2. Create the domain models

The application contains `User` and `Task` models. The Task model maps to `tasks` and defines a `belongsTo` relationship to `User`.

## 3. Create database migrations

The user migration creates the authentication fields, timestamps, remember token, and soft-delete column. The task migration creates the owner foreign key, title, description, status, due date, timestamps, and soft-delete column.

Run migrations with:

```bash
php pixelfix migrate
```

## 4. Add factories and seeders

Factories provide realistic development data. `DatabaseSeeder` calls the user and task seeders, while `TaskSeeder` attaches generated tasks to an existing user.

Run:

```bash
php pixelfix db:seed
```

## 5. Build authentication

`AuthController` handles registration, login, and logout. `LoginRequest` and `RegisterUserRequest` validate form input before the controller changes authentication state.

## 6. Build authorization

`PolicyServiceProvider` maps `Task` to `TaskPolicy` and `User` to `UserPolicy`. `AuthServiceProvider` defines the `access-admin` gate.

## 7. Build task routes

The web routes expose list, create, store, show, edit, update, and destroy operations. Browser routes are placed inside the `web` middleware group.

## 8. Build validation

`StoreTaskRequest` and `UpdateTaskRequest` define the request rules. The controller consumes only `$request->validated()` rather than raw request data.

## 9. Build views

Twig templates use the application layout and reusable components. Forms include the `csrf` global, generate URLs through named routes, and can display old input and validation errors.

## 10. Add application tests

Use the framework's test case and test runner to protect the behavior that matters to the application.

## Result

The finished application demonstrates the main PixelFix workflow:

```text
Route
  ↓
Middleware
  ↓
Controller
  ↓
Request validation
  ↓
Authorization
  ↓
Model / Database
  ↓
View or HTTP response
```

The individual Task Manager pages in this documentation set provide the detailed implementation for each stage.
