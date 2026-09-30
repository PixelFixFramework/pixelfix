# Application Structure

A PixelFix application separates framework bootstrapping, application code, web assets, data access, views, routes, and tests into predictable directories.

```text
project/
â”œâ”€â”€ app/
â”‚   â”œâ”€â”€ Http/
â”‚   â”‚   â”œâ”€â”€ Controllers/
â”‚   â”‚   â””â”€â”€ Requests/
â”‚   â”œâ”€â”€ Models/
â”‚   â”œâ”€â”€ Policies/
â”‚   â””â”€â”€ Providers/
â”œâ”€â”€ bootstrap/
â”œâ”€â”€ config/
â”œâ”€â”€ database/
â”‚   â”œâ”€â”€ factories/
â”‚   â”œâ”€â”€ migrations/
â”‚   â””â”€â”€ seeders/
â”œâ”€â”€ docs/
â”œâ”€â”€ public/
â”œâ”€â”€ resources/
â”‚   â””â”€â”€ views/
â”œâ”€â”€ routes/
â”œâ”€â”€ storage/
â”œâ”€â”€ tests/
â”œâ”€â”€ .env
â”œâ”€â”€ composer.json
â”œâ”€â”€ pixel
â””â”€â”€ pixelfix
```

## `app/`

Application source code belongs here.

### `app/Http/Controllers/`

HTTP controllers contain application actions that are invoked by routes.

The Task Manager application includes `HomeController`, `AuthController`, `TaskController`, and `UserController`.

### `app/Http/Requests/`

Form Request classes encapsulate request validation and expose validated data to controllers.

The Task Manager application uses dedicated requests such as `LoginRequest`, `RegisterUserRequest`, `StoreTaskRequest`, and `UpdateTaskRequest`.

### `app/Models/`

Application models represent application data and interact with PixelFix's ORM.

The Task Manager application defines `User` and `Task` models.

### `app/Policies/`

Policies contain model-oriented authorization rules.

The Task Manager application defines `UserPolicy` and `TaskPolicy`.

### `app/Providers/`

Application service providers register or boot application-specific services and integrations. Providers are discovered and loaded as part of application bootstrap.

## `bootstrap/`

The application bootstrap file creates the `Application` object and defines the bootstrapper pipeline.

A current generated application performs these steps in order:

```text
LoadEnvironment
      â†“
LoadConfiguration
      â†“
CoreBootstraper
      â†“
ProvidersBootstraper
      â†“
BootConsole
      â†“
Application::boot()
```

The bootstrap pipeline prepares the container, configuration, framework services, application providers, and console before the application is considered booted.

## `config/`

Application configuration is defined here. In the current implementation, `config/config.php` is the configuration source loaded by `LoadConfiguration`.

The Task Manager configuration groups values under keys such as:

```text
app
`
auth
`
database
`
```

Additional configuration sections may be added by applications.

## `database/`

Database-specific artifacts live here:

```text
database/
â”œâ”€â”€ factories/
â”œâ”€â”€ migrations/
â””â”€â”€ seeders/
```

Migrations define schema changes, factories define model data generation, and seeders populate application data.

## `public/`

`public/` is the application's web-accessible directory. The application front controller is `public/index.php`, and static assets are normally published or stored under `public/assets/`.

The web server should use this directory as the document root rather than exposing the application root.

## `resources/`

Application presentation resources live here. The Task Manager application uses Twig templates under:

```text
resources/views/
```

Layouts, pages, components, and error views can be organized below this directory.

## `routes/`

Routes are separated into files such as:

```text
routes/web.php
routes/api.php
routes/console.php
```

The Task Manager application defines its browser routes in `routes/web.php`. Its web route group applies the `web` middleware stack.

## `storage/`

Runtime-generated files are stored here, including provider manifests, compiled templates, sessions, logs, and framework runtime metadata.

Storage contents should generally be treated as generated runtime state rather than application source code.

## `tests/`

Application tests belong here. A generated application includes its own test bootstrap, test case base class, and test runner.

## Root CLI files

PixelFix applications expose their console entry point through:

```text
pixelfix
pixel
```

The `pixel` launcher delegates to the `pixelfix` entry point. The entry point loads the Composer autoloader, loads `bootstrap/app.php`, resolves the `ConsoleKernel`, and passes the command-line arguments to it.
