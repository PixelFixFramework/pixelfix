# Console

The PixelFix console provides commands for routine work inside an application: generating code, running migrations, inspecting routes, and starting the local development server. Run commands from the **application root**, where the `pixel` launcher and `composer.json` are located.

## Run a command

```powershell
php pixel help
```

This displays the commands exposed by the current framework version. To view the options for one command, use its help option or the help command:

```powershell
php pixel help make:model
php pixel make:model --help
```

For normal application development this guide uses `php pixel`. Creating a brand-new project is a separate installer operation; it is not a command exposed by the application's console.

## Everyday command groups

### Inspect and run the application

```powershell
php pixel serve
php pixel serve:status
php pixel route:list
```

`serve` starts the development server. `serve:status` reports its state. `route:list` shows routes currently registered by the application.

### Generate application artifacts

```powershell
php pixel make:model Record --all
php pixel make:controller RecordController --resource --model=Record
php pixel make:request StoreRecordRequest --model=Record
php pixel make:view records.index
php pixel make:view analytics --as=reports.analytics
php pixel make:view auth.login --preset=login
php pixel make:view auth --auth-bundle --dry-run
php pixel make:component records.summary
```

Generators create code using framework conventions. Read the generated files and adjust their application-specific logic; generation creates a starting point, not a complete business feature. `make:view` creates generic views by default and supports safe destinations under `resources/views` through `--as` (dot-separated) or `--path` (slash-separated). The explicit authentication presets and `--auth-bundle` generate authentication page wrappers and resolve their required component dependencies through the shared artifact pipeline.

### Import a ready-made component

```powershell
php pixel make:component --import auth.login
php pixel make:component --import dashboard.tile --dry-run
```

`make:component` creates a new generic component. `make:component --import` copies a component that PixelFix already ships, along with required dependencies unless dependencies are disabled. See the Components documentation before choosing which operation to use.

### Database work

```powershell
php pixel migrate:status
php pixel migrate
php pixel db:seed --list
```

Check the migration state before changing a database. Read the migration and seeding guides before running destructive operations such as `migrate:fresh`.

## Generator safety options

Most generators support:

- `--dry-run`: show what would happen without writing generated files.
- `--force`: allow replacement when a destination already exists.
- `--no-interaction`: avoid interactive prompts; understand the command's overwrite behavior before using it in automation.

The exact options are command-specific. Use `php pixel help <command>` instead of assuming every command supports every option.

## Where to look next

Use the [Command Reference](command-reference.md) for supported commands, [Generators](generators.md) to understand generated files, and [Generator Architecture](generator-architecture.md) only if you are extending PixelFix's own generation system.
