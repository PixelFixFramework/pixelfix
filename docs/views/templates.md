# Templates and Components

PixelFix uses Twig for server-rendered views. A view is the template associated with a route or controller response; a component is a reusable Twig template that a view or another component can include.

For a complete component-library walkthrough and a list of the component reference pages, see [Component Library: Beginner's Guide](../components/overview.md).

## Extend a layout

Use `extends` when a page should share a site's common HTML shell:

```twig
{% extends 'layouts/app.twig' %}

{% block title %}record Details{% endblock %}

{% block content %}
    <h1>{{ record.title }}</h1>
{% endblock %}
```

The layout defines the block names. The child view provides the page-specific content.

## Include a component

Use `include` to reuse a component:

```twig
{% include 'components/feedback/alert.twig' with {
    type: 'success',
    message: 'Record saved.'
} only %}
```

The `with` map passes parameters to the included template. `only` limits the included component to the explicitly passed values instead of exposing every variable from the surrounding template. This makes the component's required inputs clearer and reduces accidental coupling.

## Create versus import

- `php pixel make:view records.index` creates a generic page view.
- `php pixel make:view auth.login --preset=login` creates a login view and ensures its reusable component dependencies are available.
- `php pixel make:view auth --auth-bundle` creates the four standard authentication views and resolves their component dependencies.
- `php pixel make:component records.summary` creates a new generic component.
- `php pixel make:component --import dashboard.tile` imports a pre-authored framework component and its fixed dependencies.

Generic views do not automatically import components. Authentication presets and the authentication bundle are explicit exceptions: they declare the required component roots, and the shared artifact pipeline imports missing templates and deduplicates shared dependencies. Existing component files are handled by the normal component-import conflict and overwrite policy.

Views can be organized anywhere beneath `resources/views/`. Use `--as=admin.profile` for dot-separated nested destinations or `--path=admin/profile.twig` for slash-separated paths. The final generated file must stay inside the view root.

## Keep presentation logic simple

Templates should decide how to present data, not perform database updates or enforce authorization. Prepare data in controllers/services, authorize actions on the server, and use Twig for layout, conditions, loops, and reusable presentation.
