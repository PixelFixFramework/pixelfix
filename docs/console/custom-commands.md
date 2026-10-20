# Custom Console Commands

A console command is a PHP class that accepts command-line arguments and performs a task. Commands are useful for repetitive maintenance work, imports, reports, and scripts that belong to a project's development workflow.

## Current support boundary

In this source version, `ConsoleKernel` discovers command classes shipped inside the framework's own `src/Console/Commands` directory. It does not automatically discover command classes placed in an application's `app/Console/Commands/` directory. Creating a PHP class with the right name is therefore not enough to make it available in the terminal.

The public application CLI currently supports the commands listed in the [Command Reference](command-reference.md). This page describes the command contract for people studying or extending the framework itself; it is not a step-by-step recipe for registering application-owned commands.

## What a command declares

A command extends `PixelFix\Framework\Console\Command`, sets a signature and description, and implements `handle()`. The signature defines the command name plus its arguments and options. The base class parses input and exposes it through methods such as `argument()` and `option()`.

A simplified framework-level example is:

```php
protected static string $signature = 'reports:summary {period}';
protected static string $description = 'Summarize a reporting period';

public function handle(): int
{
    $period = (string) $this->argument('period');

    // Delegate the report generation to a service.

    return self::SUCCESS;
}
```

This illustrates the contract, not an instruction to manually place a class in an application folder and expect the current kernel to discover it.

## Keep command logic testable

Even where a project provides its own command-discovery mechanism, keep the command thin. Parse input, call an application service, and return a success or failure exit code. Put business logic in a service that can be tested without constructing console input or relying on terminal output.

A future application-level command generator/discovery feature should be documented only after it exists in the framework source and has tests for registration, argument parsing, hidden-command visibility, and execution.
