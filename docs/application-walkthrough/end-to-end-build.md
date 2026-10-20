# Building the Example Application End to End

This guide explains the order in which to build a small data-driven application. It assumes you already have a PixelFix application. If you still need to create the project, use the separate PixelFix Installer and follow that package's instructions; the application console is for work inside an existing project.

## 1. Prepare the application

From the directory containing `composer.json` and the `pixel` launcher, install dependencies if necessary:

```powershell
composer install
```

Configure `.env` for your local database and confirm `config/config.php` reads those values. Do not commit credentials. Before changing a database, confirm it points to your development database rather than a shared or production database.

## 2. Design the data before writing controllers

The Example Application has two central records:

- **User:** identifies the person who owns records and can sign in.
- **record:** stores record information and a `user_id` foreign-key value linking the record to its owner.

For each field, decide its type, whether it is nullable, whether it needs an index, and whether a user is allowed to edit it. These choices shape the migration, model, validation rules, and forms.

## 3. Create and apply migrations

Migrations define the database structure. The user table stores authentication-related data; the record table stores its owner, title, description, status, due date, timestamps, and soft-delete timestamp.

Review migration state before applying changes:

```powershell
php pixel migrate:status
php pixel migrate
```

Only use schema-reset commands on a disposable development database. Commands that rebuild or drop tables may permanently remove records.

## 4. Add factories and seeders

A factory describes sample model attributes—for example, a plausible record title and status. A seeder orchestrates data creation, often by calling factories and saving models. This separation helps the same factory be reused in tests and development data setup.

```powershell
php pixel db:seed --list
php pixel db:seed --dry-run
php pixel db:seed
```

Use the preview and list options to understand what will run before inserting sample data.

## 5. Build authentication

Registration and login need routes, controller actions, validation, and views. Form Requests define accepted input. The controller should use validated data rather than trusting every value in the raw request. Login checks credentials through the configured authentication guard, and logout clears the user's authentication state.

The login interface composes a reusable authentication component. A generic view does not import its includes, while `php pixel make:view auth.login --preset=login` creates the login page and resolves its component dependencies through the shared artifact pipeline.

## 6. Add authorization before exposing record operations

A record owner must be able to work with their own records, but another signed-in user should not automatically gain access. The record policy contains decisions such as viewing a record, updating it, and deleting it. The controller invokes the policy before sensitive operations.

Filtering a list by `user_id` is useful, but it does not replace checking authorization for a single record loaded by ID.

## 7. Validate record input

The store and update Form Requests define which values are accepted. For example, the title might be required and limited in length, while status must be one of the supported values. The controller should persist `$request->validated()` or explicitly chosen validated fields—not the entire raw request payload.

Validation protects data quality. Authorization protects access. Most applications need both.

## 8. Compose the views from components

Use generic views for pages and components for reusable interface pieces. A view can include a button, form control, alert, navigation bar, or record-specific component. Reuse shared components from their canonical domain rather than copying them into each feature directory.

After adding an include, check that its component file exists at that path. Importing a component and generating a view are separate operations.

## 9. Test the complete behavior

Write tests for important outcomes: valid registration, rejected invalid input, successful login, inability to view another user's record, and successful record updates. Tests should assert behavior that a user or API client can observe rather than merely checking that a class exists.

## Request lifecycle summary

```text
Browser request
    ↓
Route match
    ↓
Middleware
    ↓
Controller action
    ↓
Form Request validation
    ↓
Authorization policy
    ↓
Model / database operation
    ↓
Twig view composed from components or HTTP response
```

Follow the individual Example Application guides for complete examples of each layer. When changing a feature, work through this path one layer at a time and run the relevant tests after each change.
