# Tabs Component

Renders a tab navigation and corresponding tab-content panels from an ordered tabs array.

**Component:** `navigation/tabs.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `id` | `tabs` | Base id used to generate tab and panel ids. |
| `tabs` | `[]` | Array of tab objects. |
| `style` | `tabs` | Use `tabs` or `pills` for the navigation style. |

## Behavior and Notes

Each tab object supports `id`, `label`, `active`, optional `icon`, and `content`.

The `icon` and `content` values are rendered with `|raw`.

Supported styles are `tabs` and `pills`; unsupported values fall back to `tabs`.

The first/active state is controlled independently for each tab through `active`.

## Usage

```twig
{% include 'components/navigation/tabs.twig' with {
    id: 'task-tabs',
    style: 'tabs',
    tabs: [
        {
            id: 'details',
            label: 'Details',
            active: true,
            content: '<p>Task details</p>'
        },
        {
            id: 'history',
            label: 'History',
            content: '<p>Task history</p>'
        }
    ]
} %}
```
