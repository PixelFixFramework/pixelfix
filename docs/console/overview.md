# Console

PixelFix includes an application console with built-in commands for running the application, managing routes and databases, and generating application artifacts.

## Running commands

The project entry point is:

```bash
php pixelfix <command>
```

Use:

```bash
php pixelfix help
```

to inspect the registered commands and their signatures.

## Command categories

The current framework command surface includes four main groups:

### Application

```text
new
serve
serve:status
serve:restart
serve:stop
```

### Routes

```text
route:list
route:cache
route:clear
```

### Database

```text
migrate
migrate:rollback
migrate:reset
migrate:refresh
migrate:fresh
migrate:status
db:seed
```

### Generators

```text
make:model
make:user
make:controller
make:middleware
make:migration
make:factory
make:seeder
make:request
make:policy
make:provider
make:resource
make:test
```

Additional framework tooling includes `ide:generate` and `stub:publish`.

See the [CLI reference](../reference/cli.md) for the current command list and [Generators](generators.md) for the generation system.
