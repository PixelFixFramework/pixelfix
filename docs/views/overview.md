# Views

PixelFix uses Twig for server-rendered views. Application templates live under `resources/views`.

## Rendering a view

Controllers can render a template with the global `view()` helper:

```php
return view(
    'tasks/index',
    [
        'tasks' => $tasks,
    ]
);
```

The template name is normalized by `ViewFactory`. Both slash and dot notation are supported:

```php
view('tasks/index');
view('tasks.index');
```

The `.twig` extension is added automatically when it is omitted.

## Twig environment

PixelFix creates a shared Twig `Environment` with a filesystem loader rooted at:

```text
resources/views
```

In debug mode, Twig caching is disabled and strict variables are enabled. In non-debug mode, Twig templates use the framework's configured cache directory.

## Passing data

Pass an associative array from the controller:

```php
return view(
    'tasks/show',
    [
        'task' => $task,
        'user' => auth()->user(),
    ]
);
```

Access the values in Twig:

```twig
<h1>{{ task.title }}</h1>
<p>{{ user.name }}</p>
```

## Layouts

Twig inheritance is supported. A layout normally defines blocks and child templates override them:

```twig
{# resources/views/layouts/app.twig #}
<html>
    <head>
        <title>{% block title %}Application{% endblock %}</title>
    </head>

    <body>
        {% block content %}{% endblock %}
    </body>
</html>
```

A page can extend it:

```twig
{% extends "layouts/app.twig" %}

{% block title %}
    Tasks
{% endblock %}

{% block content %}
    <h1>Tasks</h1>
{% endblock %}
```

## Includes and components

Application templates can include smaller reusable templates:

```twig
{% include 'components/forms/input.twig' with {
    name: 'title',
    label: 'Title'
} %}
```

The Task Manager uses this pattern extensively for forms, layout pieces, feedback messages, navigation, pagination, and dashboard components.

## Built-in globals

The framework registers these Twig globals:

| Global | Purpose |
|---|---|
| `auth` | Authentication view helper object. |
| `user` | Current authenticated user helper object. |
| `csrf` | CSRF field helper value used by forms. |
| `ui` | Configured UI driver value. |
| `app_debug` | Whether the view debug flag is enabled. |
| `current_uri` | Normalized current request URI. |
| `current_route` | Current named route, when available. |

## Built-in Twig functions

PixelFix registers these functions:

```text
asset()
config()
errors()
old()
flash_messages()
url()
route()
active()
has_error()
error()
flash()
```

Examples:

```twig
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
```

```twig
<a href="{{ route('tasks.index') }}">Tasks</a>
```

```twig
{% if has_error('title') %}
    <div>{{ error('title') }}</div>
{% endif %}
```

## Route-aware navigation

The `active()` Twig function can compare the current route name or URI prefix and return the string `active` when the current request matches.

Examples:

```twig
<a class="{{ active('tasks.index') }}" href="{{ route('tasks.index') }}">
    Tasks
</a>
```

For URI matching:

```twig
<a class="{{ active('/tasks') }}" href="{{ route('tasks.index') }}">
    Tasks
</a>
```

## Flash messages

Flash messages are available through Twig:

```twig
{% for type, messages in flash_messages() %}
    {% for message in messages %}
        <div>{{ message }}</div>
    {% endfor %}
{% endfor %}
```

The Task Manager also uses a client-side flash message array generated from the same session state.

## Forms and CSRF

Browser forms should include the CSRF field whenever the route is behind the `web` middleware group:

```twig
<form method="POST" action="{{ route('tasks.store') }}">
    {{ csrf|raw }}

    <!-- inputs -->
</form>
```

## Escaping

Twig's normal escaping should be preferred for rendered content. PixelFix also exposes an `e()` PHP helper for explicit HTML escaping when building server-side strings.

Use raw output only when the value is intentionally HTML, such as the CSRF field helper:

```twig
{{ csrf|raw }}
```

## ViewFactory API

The framework's `ViewFactory` exposes:

```php
$factory->make($view, $data);
$factory->render($view, $data);
$factory->exists($view);
```

`make()` returns a `View` object; `render()` returns the rendered string; `exists()` tests whether the normalized template exists in the Twig loader.

## Task Manager example

The Task Manager uses a shared `layouts/app.twig` layout and page-specific templates such as:

```text
resources/views/tasks/index.twig
resources/views/tasks/create.twig
resources/views/tasks/edit.twig
resources/views/tasks/show.twig
```

The create page demonstrates the normal server-rendered form flow:

```twig
<form
    method="POST"
    action="{{ route('tasks.store') }}"
>
    {{ csrf|raw }}

    {% include 'components/forms/input.twig' with {
        name: 'title',
        label: 'Title'
    } %}

    <!-- additional fields -->
</form>
```

This keeps route generation, CSRF protection, reusable components, and server-side validation feedback inside the same view system.
