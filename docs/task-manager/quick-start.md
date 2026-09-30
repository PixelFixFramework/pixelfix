# Task Manager Quick Start

The Task Manager is the concrete reference application used throughout the PixelFix documentation.

## 1. Install dependencies

From the Task Manager project root:

```bash
composer install
```

The application defines a local path repository for a sibling PixelFix framework checkout and can therefore be developed directly against a working framework tree.

## 2. Configure the environment

Copy the example environment file when needed:

```bash
cp .env.example .env
```

The application can use SQLite for local development. Check the current `config/config.php` and `.env` before changing database settings.

## 3. Prepare the database

Run:

```bash
php pixel migrate
php pixel db:seed
```

## 4. Start the application

Use the framework launcher:

```bash
php pixel serve
```

Or use PHP directly:

```bash
php -S localhost:8000 -t public
```

## 5. Explore the feature flow

Start with:

```text
/
/register
/login
/tasks/index
/tasks/create
/tasks/{id}
/tasks/{id}/edit
```

The public route definitions are in `routes/web.php`.

## 6. Trace a request

The most useful first request to trace is:

```text
GET /tasks/{id}
```

It exercises routing, the web middleware group, controller dispatch, task lookup, policy authorization, model/database access, Twig rendering, and the final response.

Continue with [Trace a Task Manager Request](trace-a-request.md).
