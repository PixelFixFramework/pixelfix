# Generator Architecture

PixelFix's generator system is built around a unified artifact lifecycle. This page documents the framework architecture rather than the application-facing command syntax.

## Lifecycle

The current generator command pipeline is:

```text
Definition
    ↓
Discovery
    ↓
Validation
    ↓
Resolution
    ↓
Planning
    ↓
Generation
    ↓
Workflow
    ↓
Display
```

`Resolution` is an explicit stage in the current implementation between validation and planning. It handles conflict and outcome decisions before the plan is executed.

## 1. Definition

A generator starts by describing the requested artifact through a `Definition` and `DefinitionCollection`.

A definition contains information such as the requested name, generated class, namespace, directory, stub, type, relationships, configuration, and target paths.

Multiple definitions can be produced by one command. This is what allows commands such as `make:model --all` to create a coordinated set of artifacts.

## 2. Discovery

Discovery inspects application state relevant to the requested artifacts. The framework contains artifact discovery services as well as type-specific discovery services for models, controllers, middleware, providers, policies, requests, factories, seeders, migrations, resources, and commands.

Discovery is about understanding the target application before generation; it is not the generation step itself.

## 3. Validation

Validation checks whether the requested artifacts are valid against framework conventions and current project state.

Examples include checking existing artifacts and reserved names or paths.

## 4. Resolution

Resolution turns validation outcomes and discovered state into explicit generation decisions. The current framework contains resolution services for creation, overwriting, reserved artifacts, and validation-failure outcomes.

This is where the generator decides how a request should proceed rather than embedding those decisions inside the final file writer.

## 5. Planning

Planning produces the operations that should be performed. Creation and overwrite strategies are represented separately so the plan can be reasoned about before generation occurs.

## 6. Generation

Generation renders the resolved artifact definitions into source files using framework stubs and generation services.

The framework has both generic artifact generation services and type-specific generators.

## 7. Workflow

Workflow applies the generated artifact operations and any coordinated side effects required by the command. The workflow layer is also where multi-artifact generation can be coordinated consistently.

## 8. Display

The final display stage formats artifact outcomes for the console. Console rendering is separated from generation so output concerns do not leak into source-generation logic.

## Internal versus public API

Application developers normally use the `make:*` commands and should not depend directly on individual discovery, planning, resolution, or display services. Those classes are framework implementation points and can evolve as long as the command-level behavior remains coherent.

Framework contributors can use this lifecycle as the architectural boundary when extending a generator.
