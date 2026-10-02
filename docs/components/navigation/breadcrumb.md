# Breadcrumb Component

Renders a breadcrumb navigation from an ordered item array.

**Component:** `navigation/breadcrumb.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `items` | `[]` | Array of breadcrumb objects with `label` and optional `url`. |

## Behavior and Notes

The last item is always rendered as the active/current page.

Non-final items are rendered as links using `item.url`.

## Usage

```twig
{% include 'components/navigation/breadcrumb.twig' with {
    items: [
        { label: 'Home', url: '/' },
        { label: 'Tasks', url: '/tasks' },
        { label: 'Details' }
    ]
} %}
```
