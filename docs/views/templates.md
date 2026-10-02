# Templates and Components

PixelFix templates are ordinary Twig templates. The Task Manager demonstrates a component-oriented approach built with Twig includes and a shared application layout.

## Layout inheritance

A page can extend the application layout:

```twig
{% extends "layouts/app.twig" %}

{% block title %}
    Tasks
{% endblock %}

{% block content %}
    ...
{% endblock %}
```

## Includes

Reusable UI pieces are included with Twig's `include` syntax:

```twig
{% include 'components/form/input.twig' with {
    name: 'email',
    label: 'Email',
    required: true
} %}
```

The Task Manager uses this pattern for form controls, navigation, cards, feedback messages, tables, and pagination.

## Passing data

Controllers pass data to views as an associative array:

```php
return view(
    'tasks/show',
    ['task' => $task]
);
```

The keys become Twig variables.

## Keep templates presentational

Business rules should remain in application classes. Templates should primarily compose markup, iterate over supplied data, display validation state, and select presentation behavior.
