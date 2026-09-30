# Generators

PixelFix generators create application artifacts from framework stubs and conventions.

## Common generator commands

```bash
php pixelfix make:model Task
php pixelfix make:controller TaskController
php pixelfix make:middleware AuthMiddleware
php pixelfix make:migration create_tasks_table
php pixelfix make:factory TaskFactory --model=Task
php pixelfix make:seeder TaskSeeder --model=Task
php pixelfix make:request StoreTaskRequest --model=Task
php pixelfix make:policy TaskPolicy --model=Task
php pixelfix make:provider AuthServiceProvider
php pixelfix make:resource TaskResource
php pixelfix make:test TaskTest
```

Most generators support `--force`, `--dry-run`, and `--no-interaction`.

## Model generation

The model generator has additional composition features:

```bash
php pixelfix make:model Task --all
```

The `--all` workflow builds related artifacts for the model. In the current implementation that includes the model plus a migration, factory, root database seeder integration, and a model seeder.

For the authentication user setup:

```bash
php pixelfix make:model User --all --auth
```

The authentication option is intended for the `User` model generation path.

## Resource controllers

The controller generator supports resource mode and an optional model:

```bash
php pixelfix make:controller TaskController --resource --model=Task
```

## Generator safety options

### `--dry-run`

Plans and displays the generation operation without committing the generated artifacts.

### `--force`

Allows an existing artifact to be overwritten when the generator's resolution rules permit it.

### `--no-interaction`

Disables interactive prompts and makes the command suitable for scripted workflows.

## Artifact-oriented generation

Generators are not implemented as isolated string-copy commands. The current system builds artifact definitions, discovers project state, validates those artifacts, resolves conflicts, creates a generation plan, generates source, runs workflow operations, and displays the result.

See [Generator Architecture](generator-architecture.md) for the internal lifecycle.
