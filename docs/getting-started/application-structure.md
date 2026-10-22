# Application Structure

A PixelFix application keeps application code, configuration, templates, assets, and runtime files in separate places. Knowing where each type of file belongs makes the framework easier to learn and prevents accidental exposure of private files.

```text
project/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Requests/
│   ├── Models/
│   ├── Policies/
│   └── Providers/
├── bootstrap/
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── logging.php
│   ├── mail.php
│   ├── notifications.php
│   ├── providers.php
│   ├── queue.php
│   ├── redis.php
│   ├── session.php
│   └── ... other subsystem files
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── docs/
├── public/
├── resources/
│   └── views/
├── routes/
├── storage/
├── tests/
├── .env
├── composer.json
├── pixel
└── pixelfix
```

## Where application code belongs

- `app/Http/Controllers/` contains methods that respond to matched routes. Controllers coordinate the request and response; they should not contain every database or presentation detail.
- `app/Http/Requests/` contains Form Request classes that validate input and may authorize a request before a controller uses its validated data.
- `app/Models/` contains ORM models and relationships, such as `User` and `Task`.
- `app/Policies/` contains authorization rules, often answering whether a user may view, update, delete, restore, or permanently delete a model.
- `app/Providers/` contains services that the application registers or initializes during boot.

## Bootstrap and configuration

`bootstrap/` builds the application and registers the lifecycle bootstrappers. Each top-level PHP file under `config/` returns one configuration group: for example, `config/app.php` defines the `app` group and `config/database.php` defines the `database` group. These files read values from `.env` through helpers such as `env()`, and the framework exposes the assembled values through `config()`.

Keep passwords, API keys, and environment-specific credentials in `.env` or your deployment environment, not in committed PHP source files.

## Database files

- `database/migrations/` describes changes to the schema, such as creating a `tasks` table.
- `database/factories/` describes how to create sample model attributes.
- `database/seeders/` inserts predictable starter or demonstration records.

A migration describes a structure change; a seeder inserts data. They solve different problems.

## Public and private files

`public/` is the web server's document root. The front controller is `public/index.php`; public stylesheets, scripts, and images can be served from `public/assets/`. The web server should not serve the project root because `.env`, source files, tests, and dependencies are not public assets.

`resources/views/` contains Twig layouts, pages, and components. Route files under `routes/` declare URL-to-action mappings. `storage/` contains runtime files such as logs, compiled views, sessions, and generated metadata; these should not normally be committed as source.

## The two launchers

The generated application contains `pixel` and `pixelfix` launchers. For normal application work, this documentation uses `php pixel <command>` from the application root. Creating a new project is handled by the separate installer, not by the application's command launcher.

## Tests

`tests/` contains application tests and their bootstrap. The generated test runner can execute the test suite without requiring the developer to know the framework's internal test-runner classes.
