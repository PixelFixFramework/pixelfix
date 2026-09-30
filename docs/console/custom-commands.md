# Custom Commands

PixelFix supports console command classes and provides a generator for creating new commands.

## Generate a command

```bash
php pixelfix make:command ReportsCommand
```

The generated command follows the framework command conventions and is placed in the application's console command area.

## Command signatures

Commands define a static signature and description. A signature contains the command name and its arguments/options.

For example, framework commands use signatures such as:

```php
protected static string $signature =
    'make:resource {name}
     {--force|-f}
     {--dry-run|-d}
     {--no-interaction|-n}';
```

The command base class handles argument and option access so the command implementation can focus on its work.

## Keeping commands composable

A custom command should delegate reusable work to application services rather than placing all business logic in `handle()`. This keeps the command a console adapter and makes the underlying logic testable without invoking the CLI.
