# Generator Stubs

A **stub** is a template used by a generator to create the first version of a file. For example, `make:model Task` starts with a model stub, while `make:view tasks.index` starts with the generic Twig view stub. The generator fills supported placeholders and writes the rendered result to the application's destination directory.

## Where framework stubs live

The framework's source templates are grouped by artifact type under `src/Stubs/Framework/`, for example:

```text
src/Stubs/Framework/
├── Models/
│   ├── Generic/
│   └── Specialized/
├── Views/
│   ├── Generic/
│   └── Specialized/
└── Components/
    ├── Generic/
    └── Template/
```

`Generic` contains the default template for an artifact type. `Specialized` contains named variations selected by a generation service. `Template` contains pre-authored templates, such as the reusable Twig components that developers can import.

## How stub lookup works

The shared `StubDiscovery` service first checks the application's `stubs/` override location, then searches the framework's `Generic/`, `Specialized/`, and `Template/` folders. A qualified path such as `auth/login.twig.stub` must match exactly. A bare filename is searched recursively and is accepted only when it has a unique match.

The stub name is selected by the generator pipeline, not by the developer-facing command. For example, `MakeViewCommand` declares the generic view stub and stays declarative; view-specific selection, where configured, belongs to the View generation service.

## Placeholders

Generators replace only the placeholders that they explicitly supply. Common artifact placeholders may include names such as `{{ class }}`, `{{ namespace }}`, or `{{ table }}`, but the supported set varies by generator. Do not assume every template receives every placeholder.

Twig templates are a special case: Twig itself uses braces for template expressions. The view and component generators therefore preserve Twig expressions rather than substituting them as PHP artifact placeholders.

## Customization and support boundary

There is no public command in this version that automatically publishes the framework's stubs into an application. Do not edit files inside `vendor/`, because Composer can replace them during an update. `StubDiscovery` supports application-level override files already placed under `stubs/`, but creating and maintaining an override is a separate, deliberate customization task.

For UI changes, prefer `make:component` for a new generic component or `import:component` for a bundled component. Use stub overrides only when you intentionally need to change the template used by a generator, not merely to customize one generated view.
