# Console Command Reference

This page lists the current command signatures directly from the PixelFix command classes.

## Application

```bash
php pixelfix new {name}
php pixelfix serve {--host=127.0.0.1} {--port=8000} {--open}
php pixelfix serve:status
php pixelfix serve:restart
php pixelfix serve:stop
```

## Routing

```bash
php pixelfix route:list {--cached} {--live}
php pixelfix route:cache
php pixelfix route:clear
```

## Migrations and seeding

```bash
php pixelfix migrate {migration?} {--force} {--f} {--dry-run} {--d}
php pixelfix migrate:status {migration?}
php pixelfix migrate:rollback {migration?} {--reverse} {--r} {--force} {--f}
php pixelfix migrate:reset {--force} {--f}
php pixelfix migrate:refresh {--force} {--f}
php pixelfix migrate:fresh {--force} {--f}
php pixelfix db:seed {seeder?} {--class=} {--force} {--fresh} {--list|-l} {--dry-run|-d}
```

## Generators

```bash
php pixelfix make:model {name} {--auth} {--all|-a} {--force|-f} {--dry-run|-d} {--no-interaction|-n}
php pixelfix make:controller {name} {--resource|-r} {--model|-m=} {--force|-f} {--dry-run|-d} {--no-interaction|-n}
php pixelfix make:middleware {name} {--alias=} {--no-register} {--force|-f} {--dry-run|-d} {--no-interaction|-n}
php pixelfix make:migration {name} {--force|-f} {--dry-run|-d} {--no-interaction|-n}
php pixelfix make:factory {name} {--model|-m=} {--force|-f} {--dry-run|-d} {--no-interaction|-n}
php pixelfix make:seeder {name} {--model|-m=} {--factory=} {--no-register} {--force|-f} {--dry-run|-d} {--no-interaction|-n}
php pixelfix make:request {name} {--model|-m=} {--force|-f} {--dry-run|-d} {--no-interaction|-n}
php pixelfix make:policy {name} {--model|-m=} {--no-register} {--force|-f} {--dry-run|-d} {--no-interaction|-n}
php pixelfix make:provider {name} {--force|-f} {--dry-run|-d} {--no-interaction|-n}
php pixelfix make:resource {name} {--force|-f} {--dry-run|-d} {--no-interaction|-n}
php pixelfix make:test {name} {--force|-f} {--dry-run|-d} {--no-interaction|-n}
php pixelfix make:user {--auth} {--all|-a} {--force|-f} {--dry-run|-d} {--no-interaction|-n}
php pixelfix make:command {name}
```

## Maintenance

```bash
php pixelfix ide:generate
php pixelfix stub:publish {--force} {--f}
php pixelfix help {command?}
```

## Launcher aliases

The framework repository contains both launchers:

```bash
php pixelfix help
php pixel help
```

They resolve to the framework console entry point used by the current project.

## Reading command output

For command-specific behavior, `help` accepts a command name:

```bash
php pixelfix help make:model
php pixelfix help migrate
```

Use the CLI reference together with the generator documentation when an option controls generated artifacts or registration behavior.
