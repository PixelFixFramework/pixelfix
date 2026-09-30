# Command-Line Reference

PixelFix exposes its console through the `pixelfix` launcher. The repository also contains a small `pixel` wrapper that invokes the same launcher.

Use either form from a framework/application root where the launcher is available:

```bash
php pixelfix help
php pixel help
```

## Application commands

### `new`

```bash
php pixelfix new {name}
```

Creates a new PixelFix application.

### `serve`

```bash
php pixelfix serve {--host=127.0.0.1} {--port=8000} {--open}
```

Starts the PixelFix development server.

### Development server controls

```bash
php pixelfix serve:status
php pixelfix serve:restart
php pixelfix serve:stop
```

## Routing commands

```bash
php pixelfix route:list {--cached} {--live}
php pixelfix route:cache
php pixelfix route:clear
```

`route:list` can inspect cached or live route state; the cache commands compile or clear the route cache.

## Migration commands

```bash
php pixelfix migrate {migration?} {--force} {--f} {--dry-run} {--d}
php pixelfix migrate:status {migration?}
php pixelfix migrate:rollback {migration?} {--reverse} {--r} {--force} {--f}
php pixelfix migrate:reset {--force} {--f}
php pixelfix migrate:refresh {--force} {--f}
php pixelfix migrate:fresh {--force} {--f}
```

`migrate:fresh` is destructive during development because it rebuilds the schema from scratch. Use it only when losing existing data is acceptable.

### Seeding

```bash
php pixelfix db:seed {seeder?} {--class=} {--force} {--fresh} {--list|-l} {--dry-run|-d}
```

The seed command can select a seeder, list available seeders, run in dry-run mode, or perform a fresh database workflow where supported by the command.

## Generator commands

### Model

```bash
php pixelfix make:model {name} \
    {--auth} \
    {--all|-a} \
    {--force|-f} \
    {--dry-run|-d} \
    {--no-interaction|-n}
```

`--all` generates the related artifact set supported by the current model generator. `--auth` adds the authentication-oriented model setup supported by the command.

### Controller

```bash
php pixelfix make:controller {name} \
    {--resource|-r} \
    {--model|-m=} \
    {--force|-f} \
    {--dry-run|-d} \
    {--no-interaction|-n}
```

### Request

```bash
php pixelfix make:request {name} \
    {--model|-m=} \
    {--force|-f} \
    {--dry-run|-d} \
    {--no-interaction|-n}
```

### Middleware

```bash
php pixelfix make:middleware {name} \
    {--alias=} \
    {--no-register} \
    {--force|-f} \
    {--dry-run|-d} \
    {--no-interaction|-n}
```

### Migration

```bash
php pixelfix make:migration {name} \
    {--force|-f} \
    {--dry-run|-d} \
    {--no-interaction|-n}
```

### Factory

```bash
php pixelfix make:factory {name} \
    {--model|-m=} \
    {--force|-f} \
    {--dry-run|-d} \
    {--no-interaction|-n}
```

### Seeder

```bash
php pixelfix make:seeder {name} \
    {--model|-m=} \
    {--factory=} \
    {--no-register} \
    {--force|-f} \
    {--dry-run|-d} \
    {--no-interaction|-n}
```

### Policy

```bash
php pixelfix make:policy {name} \
    {--model|-m=} \
    {--no-register} \
    {--force|-f} \
    {--dry-run|-d} \
    {--no-interaction|-n}
```

### Provider

```bash
php pixelfix make:provider {name} \
    {--force|-f} \
    {--dry-run|-d} \
    {--no-interaction|-n}
```

### Resource

```bash
php pixelfix make:resource {name} \
    {--force|-f} \
    {--dry-run|-d} \
    {--no-interaction|-n}
```

### Test

```bash
php pixelfix make:test {name} \
    {--force|-f} \
    {--dry-run|-d} \
    {--no-interaction|-n}
```

### Command

```bash
php pixelfix make:command {name}
```

### User/authentication scaffold

```bash
php pixelfix make:user \
    {--auth} \
    {--all|-a} \
    {--force|-f} \
    {--dry-run|-d} \
    {--no-interaction|-n}
```

## Maintenance commands

```bash
php pixelfix ide:generate
php pixelfix stub:publish {--force} {--f}
php pixelfix help {command?}
```

## Generator architecture

All `make:*` commands use the framework's generator infrastructure. The current artifact pipeline is:

```text
Definition
    ↓
Discovery
    ↓
Validation
    ↓
Planning
    ↓
Generation
    ↓
Workflow
    ↓
Display
```

The individual discovery, planning, resolution, and display services are implementation details unless you are extending PixelFix itself. Application developers generally consume the generator through CLI commands and generated artifacts.
