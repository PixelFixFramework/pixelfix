# Twig Integration

PixelFix uses Twig to render `.twig` templates. Twig lets you combine static HTML with values supplied by controllers, loops, conditionals, layouts, and included components. Keep database queries and authorization decisions in PHP; use Twig to present data that has already been prepared by your application.

## Render a view from PHP

```php
return view('tasks/index', [
    'tasks' => $tasks,
    'heading' => 'My tasks',
]);
```

The view name maps to `resources/views/tasks/index.twig`. Each array key becomes a Twig variable, so the template can use `{{ heading }}` and loop over `tasks`.

## Print values safely

```twig
<h1>{{ heading }}</h1>

<ul>
    {% for task in tasks %}
        <li>{{ task.title }}</li>
    {% else %}
        <li>No tasks have been created yet.</li>
    {% endfor %}
</ul>
```

`{{ value }}` prints an expression. Twig auto-escapes ordinary output in HTML templates, which helps prevent untrusted text from being interpreted as markup. Avoid applying `|raw` to data supplied by users.

## Conditions

```twig
{% if auth.check() %}
    <p>Welcome, {{ user.name }}.</p>
{% else %}
    <p>Please sign in.</p>
{% endif %}
```

Conditions control what the page displays, not whether a request is authorized. Protected controller actions must still enforce authentication and authorization on the server.

## Framework globals

The current environment registers the following Twig globals:

```text
auth
user
csrf
ui
app_debug
current_uri
current_route
```

For example, the `csrf` global renders a complete hidden CSRF input. It must be used as markup:

```twig
<form method="post" action="{{ route('tasks.store') }}">
    {{ csrf|raw }}
    {# render the form fields here #}
</form>
```

The `csrf` value is a global variable, not a function. Use `{{ csrf|raw }}`, not `{{ csrf() }}`. Use `raw` here only because the trusted framework global returns an HTML input; do not use it to display user text. See [CSRF Protection](../http/csrf.md).

## Framework Twig functions

The view provider registers functions including:

```text
asset()
config()
errors()
old()
flash_messages()
route()
url()
```

For example, `route('tasks.index')` returns the URL for a named route and `asset('css/app.css')` builds a URL for a public asset. The application can register additional functions through its own view configuration/providers, so the functions actually registered by the running application are the runtime contract.

## Layouts and components

Use `{% extends 'layouts/app.twig' %}` to reuse the page shell and `{% block content %}` to fill a layout block. Use `{% include 'components/feedback/alert.twig' with {...} only %}` to render a reusable component with explicitly supplied data. The `only` keyword prevents the included template from receiving unrelated variables from the parent context.

## Troubleshooting

If Twig reports an unknown variable, confirm that the controller passed that key to `view()`. If it reports an unknown function, check whether the name is registered as a Twig function or is actually a global variable. If a template cannot be found, compare the normalized view name with its path under `resources/views` and check the exact include path.
