# Task Manager Views: Turn Controller Data into a Component-Based Page

A view is the presentation layer. It decides how data should look in the browser; it should not decide whether a user is allowed to edit a task and it should not perform database writes. In the Task Manager, route views remain intentionally small and use reusable Twig components to render each page.

## 1. Find the three relevant locations

```text
resources/views/
├── layouts/
│   └── app.twig
├── tasks/
│   ├── index.twig
│   ├── show.twig
│   ├── create.twig
│   └── edit.twig
└── components/
    └── pages/
        └── tasks/
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
    Task Manager
{% endblock %}

{% block content %}
    {% include 'components/pages/tasks/index.twig' %}
{% endblock %}
```

The view file determines which layout block contains the page, but the detailed page markup lives in `components/pages/tasks/index.twig`. This separation makes it easier to find page-level code and reuse smaller components.

## 3. Understand the data path

For a list page, the controller performs the authorized query and passes its results into the view:

```php
$tasks = Task::query()
    ->where('user_id', '=', auth()->id())
    ->orderBy('created_at', 'desc')
    ->paginate(20);

return view('tasks/index', [
    'tasks' => $tasks,
]);
```

The view receives the key `tasks`, so its Twig code reads that same variable. If the controller passes `taskList` but the template reads `tasks`, the data does not match and the page will fail or render incorrectly. Naming consistency is important across controller arrays and Twig variables.

The query is scoped to the signed-in user before retrieval. Never retrieve everyone's tasks and rely on a Twig `if` statement to hide records. Authorization and data scoping belong in the server-side feature logic.

## 4. Compose a form from reusable controls

A create page should use shared form components for labels, inputs, submit buttons, and validation feedback. A typical component include passes named variables through Twig:

```twig
{% include 'components/form/input.twig' with {
    name: 'title',
    label: 'Task title',
    value: old('title', task.title|default('')),
    placeholder: 'Enter a task title',
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

`php pixel make:view tasks.index` creates a generic view at `resources/views/tasks/index.twig`. It does not choose a special task/login/register template and it does not automatically import components that the Twig source references.

To use a bundled component, import it through the documented component importer, then include it in a view or another component. Use the component library reference to understand the component's parameters, defaults, accessible behavior, and dependencies.

## 8. Diagnose a blank or broken page

1. Check the controller's `view()` call and the exact view name.
2. Confirm the corresponding `resources/views/...` file exists.
3. Confirm every `extends` and `include` reference resolves to an existing file.
4. Compare the data keys passed from PHP with the variable names used by Twig.
5. Check whether the controller supplied `tasks` as a paginator or collection and whether the template expects that interface.
6. Inspect the browser console for JavaScript/component behavior and the PHP/application logs for server-side errors.
7. Make sure a route error is not being mistaken for a template error.

Related reading: [Views Overview](../views/overview.md), [Layouts](../views/layouts.md), [Twig](../views/twig.md), [Components](../views/templates.md), [Validation](../validation/overview.md), and [Task Manager Authorization](authorization.md).
