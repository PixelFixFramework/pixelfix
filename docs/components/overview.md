# PixelFix Component Library: Beginner's Guide

A component is a reusable Twig template. Instead of copying the same button, navigation bar, form control, alert, or page section into several views, you put that markup in one component and include it wherever it is needed.

Components are presentation templates. They do not, by themselves, authenticate a user, validate a request on the server, save a record, or authorize an action. Those responsibilities belong to routes, controllers, request validation, services, and authorization rules.

## 1. Find the components shipped with PixelFix

The framework's importable component catalog lives under `src/Stubs/Framework/Components/Template/`. Its path relative to `resources/views/` becomes the component's Twig include path.

For example:

| Bundled template | Application component path | Intended use |
|---|---|---|
| `form/button.twig.stub` | `components/form/button.twig` | Submit actions and links styled as buttons |
| `form/input.twig.stub` | `components/form/input.twig` | Standard form input |
| `feedback/alert.twig.stub` | `components/feedback/alert.twig` | Inline status or error message |
| `data/table.twig.stub` | `components/data/table.twig` | Tabular data presentation |
| `auth/login.twig.stub` | `components/auth/login.twig` | Prebuilt login form presentation |
| `auth/register.twig.stub` | `components/auth/register.twig` | Prebuilt registration form presentation |

The complete component list is linked from the application [README](../../README.md#components). This guide explains how to use the library; each individual component page documents that component's parameters and behavior.

## 2. Import a bundled component or create your own

Use `import:component` when you want a component already authored by PixelFix. For example:

```powershell
php pixel import:component dashboard.tile
```

PixelFix copies the selected template into your application's `resources/views/components/` directory and plans its fixed, statically discoverable dependencies. Shared dependencies are reused at their canonical locations; existing application files are not silently replaced during an ordinary dependency import.

Use `make:component` when you want to author a new component using the generic component scaffold:

```powershell
php pixel make:component employee.summary
```

This generates a new component at `resources/views/components/employee/summary.twig`. The new component is yours to implement; generating it does not copy the behavior of an existing framework component.

Use `make:view` to create an ordinary page view:

```powershell
php pixel make:view employees.index
```

That creates `resources/views/employees/index.twig`. It does not automatically import components; your view should include the components that make up its page.

## 3. Include a component in a view

A view can include a component using Twig's `include` tag. The path is relative to the configured Twig template root and normally starts with `components/`:

```twig
{% include 'components/feedback/alert.twig' with {
    type: 'success',
    message: 'The employee was saved.'
} only %}
```

The `with` map passes values into the component. The `only` keyword makes the component receive only the values you name instead of inheriting every variable from the parent view. This makes a component easier to understand and reuse.

The example assumes that `components/feedback/alert.twig` has been imported or otherwise exists in the application.

## 4. Pass data from the controller

Prepare data in a controller or service, then pass it to the view. Keep database queries and permission decisions out of presentation components.

For example, a controller may prepare an employee's display name and pass it to a view. The view can then pass that value to a component:

```twig
{% include 'components/layout/card.twig' with {
    title: 'Employee',
    body: employee.name
} only %}
```

Check the individual component's documentation before using particular parameter names. Components are not all interchangeable: a table expects tabular data, a button expects label and action/link options, and a navigation component expects its documented destination and label.

## 5. Understand shared components and feature components

PixelFix treats these domains as shared UI building blocks:

- `form/` and `floating/`: common controls reused by many forms;
- `feedback/`: alerts, badges, flash messages, spinners, toasts and validation messages;
- `data/`: table and pagination presentation;
- `layout/`: cards, headers, footer, main content, modal and sidebar;
- `navigation/`: navbar, breadcrumb, offcanvas and tabs.

Feature-specific components include `auth/` and `dashboard/`. When a feature component is imported under a different namespace, fixed references to relocated feature components are updated by the importer, while shared dependencies remain in their canonical shared domains.

For example, importing a login component into an `employee` feature should not create a separate `employee/form/` domain for generic controls. The shared form button remains `components/form/button.twig`.

## 6. Dependencies: what import does and does not discover

PixelFix detects fixed template references such as literal Twig `include`, `embed`, and `extends` paths, along with supported default component references. It imports the known dependency closure in the required order and avoids planning the same destination repeatedly.

Some components also accept a configurable partial path. A caller may supply a custom path at runtime; a dynamic value cannot always be known by the importer. Read the component's documentation for its partial parameters and make sure any application-owned partial you configure exists.

A successful file import does not prove that an external service is configured. Components provide presentation; application services and controllers remain responsible for external integrations, validation, and session management.

## 7. Choose a component safely

1. Read that component's page before using it. It describes required parameters, defaults, dependencies and conditional behavior.
2. Import it with `php pixel import:component <component-name>`.
3. Check the command's table. `CREATED`, `UNCHANGED`, `SKIPPED`, `OVERWRITTEN`, `ERROR`, and dry-run statuses describe file operations; a status is not a guarantee that the rendered feature works.
4. Include the component with explicit variables, preferably using `only`.
5. Render the page and test the interaction. For forms, also test server-side validation and authorization; hiding a button in Twig is not an access-control check.

## 8. Common problems

**Twig reports that a component cannot be found.** Check the exact include path and confirm that the component exists under `resources/views/`. Import the bundled component if it is missing.

**A component renders nothing.** Some components deliberately render nothing until a required value is supplied. Check the individual page's conditions and parameters.

**A component has no Bootstrap styling or icon.** Components emit CSS classes and icon classes; the application must load the corresponding CSS/icon assets. Importing a Twig file does not install those browser assets automatically.

**A form looks correct but an action is not secure.** UI components provide markup. Server-side validation, CSRF protection, authentication and authorization still need to be configured and tested.

**A dependency is already present.** Shared dependencies should be reused. Do not create duplicate shared domains just to match the feature's namespace. Inspect the import table to see each target path and status.

## 9. Component reference pages

Use the component reference section in the README to find the exact documentation for authentication, dashboard, data, feedback, floating controls, forms, layout and navigation. Each reference should be read alongside this guide when first learning the library.
