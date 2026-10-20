# Layouts

A layout is a shared page shell. Instead of repeating the HTML document, navigation, common stylesheets, footer, and script tags on every page, a layout defines those once and exposes Twig blocks for page-specific content.

## Basic pattern

A layout might define a title and content block:

```twig
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{% block title %}Application{% endblock %}</title>
</head>
<body>
    {% block content %}{% endblock %}
</body>
</html>
```

A page extends it and fills those blocks:

```twig
{% extends 'layouts/app.twig' %}

{% block title %}Task List{% endblock %}

{% block content %}
    <h1>Your tasks</h1>
{% endblock %}
```

The names are contracts: the page's block must match a block declared by the layout. A block with a different name will not replace `content`.

## Use components inside layouts

Keep the layout focused on page-wide structure and use Twig includes for reusable pieces such as the navbar, footer, alerts, and sidebar. The page view should compose components rather than copy the same navigation markup across every route.

Generate generic views with `php pixel make:view page.name`, then include components that have been created or imported into the application. `MakeViewCommand` does not automatically import the components a view references.


## A simple mental model

Think of a layout as the frame around many pages: it owns the document structure, shared navigation, stylesheet links, and named blocks. A page extends the layout and fills the blocks that the layout exposes. A component is a reusable piece inside a block, such as a notice, button, form control, or task summary.

If content does not appear, check that the page extends the correct layout and that the block name matches exactly. A block called `main` in a page does not fill a layout block named `content`. If a component include fails, confirm the referenced Twig file exists under `resources/views/` and that its path matches the include.
