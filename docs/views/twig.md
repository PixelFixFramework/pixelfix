# Twig Integration

PixelFix uses Twig as its view engine and registers application-specific globals and functions through the view service provider.

## Rendering a view

Application code can render a template by name:

```php
return view('tasks/index', [
    'tasks' => $tasks,
]);
```

Dot notation is normalized as well, so `tasks.index` maps to the same `tasks/index.twig` template.

## Framework globals

The current Twig environment provides these globals:

```text
auth
user
csrf
ui
app_debug
current_uri
current_route
```

For example:

```twig
{% if auth.check() %}
    Welcome, {{ user.name }}
{% endif %}
```

The `csrf` global can be rendered directly in a form:

```twig
{{ csrf|raw }}
```

## Framework functions

The view service provider registers functions including:

```text
asset()
config()
errors()
old()
flash_messages()
route()
url()
```

The exact available function set should be treated as the current runtime contract; application-specific Twig functions may also be registered by providers.

## Debugging

The Twig environment enables debug behavior from the application's environment configuration and uses stricter variable handling in debug mode. In production mode, compiled templates use the configured Twig cache directory.
