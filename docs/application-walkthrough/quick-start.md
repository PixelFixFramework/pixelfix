# Example Application Quick Start

This guide shows how to prepare an existing PixelFix application directory. It does not create a project; use the separate PixelFix Installer when you need to create a new application.

## 1. Install dependencies

Open a terminal in your application root—the directory containing `composer.json`—and run:

```powershell
composer install
```

Composer installs PHP dependencies and runs the project's configured setup scripts. If the framework repository is private, your GitHub account and Composer credentials must have permission to download it.

## 2. Configure the environment

The project includes `.env.example`. If the application does not yet have a local `.env`, copy the example:

```powershell
Copy-Item .env.example .env
```

Open `.env` and `config/config.php` and check the database settings. Never commit passwords, private tokens, or machine-specific secrets. Make sure the PHP CLI has the PDO driver required by the selected database.

## 3. Prepare the database

From the project root, run:

```powershell
php pixel migrate
php pixel db:seed
```

`migrate` applies the pending migration files to create or update the database schema. `db:seed` runs the configured seeders to insert sample data. Run migrations first so seeders have tables to write into. Do not run seeders against a production database unless you understand exactly what they insert.

If SQLite reports that a driver is unavailable, enable `pdo_sqlite` for the PHP executable used in this terminal. A database GUI or web-server PHP configuration does not necessarily enable the same driver for CLI PHP.

## 4. Start the application

The project exposes the framework's local development server:

```powershell
php pixel serve
```

Alternatively, PHP's built-in server can serve the public directory:

```powershell
php -S localhost:8000 -t public
```

Use the address printed by the server. Stop it with `Ctrl+C` when finished.

## 5. Explore the application

Visit `/` first. Create an account at `/register`, sign in at `/login`, then open `/records/index` and create a record at `/records/create`. record routes require authentication. record creation validates the title, description, status, and due date; successful creation associates the record with the currently signed-in user.

Try viewing, editing, and deleting your record. If you test access control, use two accounts and check that one user cannot access the other user's record. A single account does not test the ownership boundary.

## 6. Trace one request

A useful next step is `GET /records/{record}`. Follow it through `routes/web.php`, the `web` and `auth` middleware, `RecordController::show()`, record lookup, `RecordPolicy`, the model/database query, the Twig page, and the HTTP response. The [Trace a Request](trace-a-request.md) guide walks through each step.

## Troubleshooting checklist

- `php pixel` is not recognized: run it from the project root and verify the launcher file is present.
- Database connection fails: verify `.env`, `config/config.php`, the database service, database file permissions, and the CLI PDO driver.
- Login fails: confirm the user exists and its password is a password hash created by the registration flow.
- record route is denied: confirm you are signed in and viewing a record owned by that account.
