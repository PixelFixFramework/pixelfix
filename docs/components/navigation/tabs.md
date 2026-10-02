# Tabs

> **Component:** `components/navigation/tabs.twig`

## Purpose

Renders Bootstrap tabs or pills together with their tab panels from a tab definition array.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``id`` | Optional | `tabs` | Base id used to generate tab and panel ids. |
| ``tabs`` | Optional | `[]` | Array of tab objects. |
| ``style`` | Optional | `tabs` | Use `tabs` or `pills`. |


## Behavior

Each tab object accepts `id`, `label`, `content` and optional `icon` and `active`. The component uses `active` to set the button/panel state and ARIA attributes. `content` and `icon` are rendered raw.

## Example

```twig
{% include 'components/navigation/tabs.twig' with {
    id: 'taskTabs',
    style: 'pills',
    tabs: [
        {
            id: 'details',
            label: 'Details',
            content: '<p>Task details</p>',
            active: true
        },
        {
            id: 'history',
            label: 'History',
            content: '<p>Activity history</p>'
        }
    ]
} %}
```

## Usage

Use unique tab ids within a page. Ensure Bootstrap's tab JavaScript is loaded so clicking the generated buttons switches panels.

## Notes

An optional `icon` may contain trusted icon HTML such as `<i class="bi bi-info-circle"></i>`.

## Related Components

- `components/navigation/breadcrumb.twig`
- `components/navigation/navbar.twig`
