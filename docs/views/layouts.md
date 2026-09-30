# Layouts

Layouts provide a shared page shell for application views.

The Task Manager uses `resources/views/layouts/app.twig` as the common layout for pages such as login, registration, and task screens.

## Basic pattern

```twig
{% extends "layouts/app.twig" %}

{% block title %}
    My Page
{% endblock %}

{% block content %}
    <h1>My Page</h1>
{% endblock %}
```

Keep global page structure—document metadata, shared navigation, scripts, and the main content slot—in the layout. Put feature-specific content in child templates.

## Reusable layout fragments

The Task Manager further decomposes the page shell into reusable components such as headers, sidebars, navigation, cards, modals, breadcrumbs, and footers.

This lets a feature page remain focused on its content while the visual system evolves independently.
