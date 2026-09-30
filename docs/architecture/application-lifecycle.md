# Application Lifecycle

The PixelFix application lifecycle has two closely related phases: **bootstrap** and **boot**.

## 1. Entry point

A generated application's `pixelfix` entry point loads Composer's autoloader and then loads:

```text
bootstrap/app.php
```

The `pixel` launcher simply requires the `pixelfix` entry point.

## 2. Application construction

`bootstrap/app.php` creates:

```php
$app = new Application(BASE_PATH);
```

The `Application` constructor creates and registers the core container, bootstrap manager, runtime manager, provider manifest, and provider repository.

## 3. Bootstrapper registration

The application then calls `bootstrapWith()` with an ordered list of bootstrapper classes.

A generated application uses:

```text
LoadEnvironment
LoadConfiguration
CoreBootstraper
ProvidersBootstraper
BootConsole
```

The order is significant because later stages depend on services established by earlier stages.

## 4. Environment loading

`LoadEnvironment` creates a Dotenv loader rooted at the application base path and safely loads `.env`.

Environment values are therefore available to configuration code and the framework's `env()` helper during subsequent bootstrap stages.

## 5. Configuration loading

`LoadConfiguration` reads:

```text
config/config.php
```

The configuration file must return an array. PixelFix places that array in a `Repository` and shares the same repository instance under both `Repository::class` and `Config::class`.

The configuration repository supports dotted keys such as:

```php
$config->get('auth.defaults.guard');
```

## 6. Core bindings

`CoreBootstraper` makes the application's container globally available through the framework's `App` support class and ensures the `Application` and `Container` instances are available from the container.

## 7. Provider loading

`ProvidersBootstraper` builds the provider list from three sources:

```text
Framework providers
        +
Discovered application providers
        +
Configured providers
```

The list is de-duplicated before being loaded.

Framework providers initialize subsystems such as HTTP, the kernel, logging, exceptions, storage, database, ORM, sessions, authentication, middleware, pipelines, routing, and views.

Application providers are discovered from the application and can add application-specific registrations and boot logic.

## 8. Console boot

`BootConsole` resolves the `ConsoleKernel` and boots it. This makes framework and discovered application commands available to the application's CLI entry point.

## 9. Application boot

After the bootstrapper pipeline completes, `bootstrap/app.php` calls:

```php
$app->boot();
```

The application delegates provider booting to the provider repository and then marks itself as booted.

## 10. HTTP execution

When the HTTP kernel handles a request, it ensures the kernel is booted and resolves its routing services from the container.

The HTTP path then proceeds conceptually as:

```text
Incoming request
      ↓
HTTP Kernel
      ↓
Route matching
      ↓
Middleware resolution and ordering
      ↓
Route execution
      ↓
Application handler
      ↓
Response
```

A route can carry middleware of its own. The kernel resolves that middleware and can order it according to the configured middleware priority list.

## 11. Console execution

For CLI requests, the console entry point resolves `ConsoleKernel` and delegates the command-line arguments to it.

The console kernel parses the command, resolves the registered command class from the container, injects the current input and output context, and executes the command lifecycle.

## 12. Runtime reset

`Application` also exposes runtime reset support. Runtime services can be reset and core application/container instances re-established for a fresh execution context.

This capability is especially relevant to long-running or repeated execution environments and to framework testing.
