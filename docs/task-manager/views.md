# Task Manager: Views

The Task Manager is a server-rendered Twig application. Templates live under `resources/views`.

## Main template areas

```text
resources/views/
├── auth/
├── components/
├── errors/
├── layouts/
├── tasks/
└── welcome.twig
```

The reusable `components/` tree contains layout, navigation, forms, feedback, data, and dashboard templates.

## Layout

`layouts/app.twig` is the common application shell. Pages extend it and provide their content through Twig blocks.

The layout also loads application CSS and JavaScript, configures client-side flash messages, and exposes application-level UI settings to the browser.

## Task pages

The task area contains:

```text
tasks/index.twig
 tasks/create.twig
 tasks/edit.twig
 tasks/show.twig
```

The controller selects the appropriate template and passes model data explicitly.

## Reusable components

The create page includes shared form components rather than repeating raw markup. For example:

```twig
{% include 'components/forms/input.twig' with {
    name: 'title',
    label: 'Title',
    placeholder: 'Enter task title',
    maxlength: 255
} %}
```

The same approach is used for selects, textareas, buttons, cards, alerts, pagination, navigation, and validation feedback.

## Validation feedback

The framework exposes old input and validation errors to Twig, allowing components and forms to repopulate fields and display field-specific messages after a failed submission.

## Route generation in templates

The application consistently uses named routes:

```twig
href="{{ route('tasks.index') }}"
```

and form actions:

```twig
action="{{ route('tasks.store') }}"
```

This keeps template URLs aligned with the route definitions.
