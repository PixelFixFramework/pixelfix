# Breadcrumb

> **Component:** `components/navigation/breadcrumb.twig`

## Purpose

Renders a Bootstrap breadcrumb trail from an array of navigation items.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``items`` | Optional | `[]` | Array of breadcrumb objects containing `label` and `url`. |


## Behavior

Every item except the last is rendered as a link using `item.url`. The last item is rendered as the active page and is marked with `aria-current="page"`.

## Example

```twig
{% include 'components/navigation/breadcrumb.twig' with {
    items: [
        {label: 'Dashboard', url: route('home')},
        {label: 'Tasks', url: route('tasks.index')},
        {label: 'Edit Task'}
    ]
} %}
```

## Usage

Provide the items in display order. Leave the last item's `url` out when it should represent the current page.

## Related Components

- `components/layout/main.twig`
