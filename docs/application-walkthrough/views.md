# Example Application Views: Turn Controller Data into a Component-Based Page

A view is the presentation layer. It decides how data should look in the browser; it should not decide whether a user is allowed to edit a record and it should not perform database writes. In the Example Application, route views remain intentionally small and use reusable Twig components to render each page.

## 1. Find the three relevant locations

```text
resources/views/
├── layouts/
│   └── app.twig
├── records/
│   ├── index.twig
│   ├── show.twig
│   ├── create.twig
│   └── edit.twig
└── components/
    └── pages/
        └── records/
            ├── index.twig
            ├── show.twig
            ├── create.twig
            └── edit.twig
```

The route view selects the layout and delegates its page content to a component. The page component composes reusable buttons, input controls, cards, tables, flash messages, and other UI elements. The layout owns the document shell and shared application areas.

## 2. Keep the route view declarative

A small route view can extend the app layout and include a page component:

```twig
{% extends "layouts/app.twig" %}

{% block title %}
    Example Application
{% endblock %}

{% block content %}
    {% include 'components/pages/records/index.twig' %}
{% endblock %}
```

The view file determines which layout block contains the page, but the detailed page markup lives in `components/pages/records/index.twig`. This separation makes it easier to find page-level code and reuse smaller components.

## 3. Understand the data path

For a list page, the controller performs the authorized query and passes its results into the view:

```php
$records = Record::query()
    ->where('user_id', '=', auth()->id())
    ->orderBy('created_at', 'desc')
    ->paginate(20);

return view('records/index', [
    'records' => $records,
]);
```

The view receives the key `records`, so its Twig code reads that same variable. If the controller passes `recordList` but the template reads `records`, the data does not match and the page will fail or render incorrectly. Naming consistency is important across controller arrays and Twig variables.

The query is scoped to the signed-in user before retrieval. Never retrieve everyone's records and rely on a Twig `if` statement to hide records. Authorization and data scoping belong in the server-side feature logic.

## 4. Compose a form from reusable controls

A create page should use shared form components for labels, inputs, submit buttons, and validation feedback. A typical component include passes named variables through Twig:

```twig
{% include 'components/form/input.twig' with {
    name: 'title',
    label: 'Record title',
    value: old('title', record.title|default('')),
    placeholder: 'Enter a record title',
    required: true
} only %}
```

This example illustrates component composition; use the exact property names documented for the component you selected. The `only` keyword limits the include context to the supplied values, which helps a component's input contract remain explicit.

The HTML form still needs the correct action, HTTP method, and CSRF token for a browser session. A component renders fields; it does not implement the route/controller logic or save the model. After submission, the request must be validated and authorized before data is persisted.

## 5. Show validation feedback

The framework provides helpers for old input and field errors, and PixelFix's validation components can render messages. The field name in Twig must match the key in the Form Request's validation rules. If the rule is for `title` but the input is named `task_title`, the submitted field and validation message will not match without explicit mapping.

Never render raw user input as unescaped HTML. Prefer normal Twig escaping for ordinary text. Do not use a “raw” filter for user-supplied content unless the content has been safely sanitized for the exact context.

## 6. Use status/flash components for feedback

Flash messages are useful after a successful create/update/delete operation because browser forms often redirect after a write. The controller should set the appropriate flash data through the supported redirect/session flow; the feedback component displays messages it receives. A toast or notifications header is a display component, not a backend delivery system.

## 7. Generate generic views, then compose components

`php pixel make:view records.index` creates a generic view at `resources/views/records/index.twig`. A plain command does not select an authentication preset or automatically import referenced components. Explicit auth presets and `--auth-bundle` create the standard authentication page views and resolve missing reusable component dependencies. Use `--as=admin.profile` for dot-separated destinations or `--path=admin/profile.twig` for slash-separated paths; both remain confined to `resources/views/`.

To use a bundled component, import it through the documented component importer, then include it in a view or another component. Use the component library reference to understand the component's parameters, defaults, accessible behavior, and dependencies.

## 8. Diagnose a blank or broken page

1. Check the controller's `view()` call and the exact view name.
2. Confirm the corresponding `resources/views/...` file exists.
3. Confirm every `extends` and `include` reference resolves to an existing file.
4. Compare the data keys passed from PHP with the variable names used by Twig.
5. Check whether the controller supplied `records` as a paginator or collection and whether the template expects that interface.
6. Inspect the browser console for JavaScript/component behavior and the PHP/application logs for server-side errors.
7. Make sure a route error is not being mistaken for a template error.

Related reading: [Views Overview](../views/overview.md), [Layouts](../views/layouts.md), [Twig](../views/twig.md), [Components](../views/templates.md), [Validation](../validation/overview.md), and [Example Application Authorization](authorization.md).
