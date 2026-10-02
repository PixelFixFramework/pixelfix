# Sidebar

> **Component:** `components/layout/sidebar.twig`

## Purpose

Renders the PixelFix dashboard/application sidebar with branding, optional menu search, recursive nested navigation, optional user information and optional POST logout.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``brand`` | Optional | `PixelFix` | Brand text. |
| ``logo`` | Optional | `P` | Logo text. |
| ``items`` | Optional | `[]` | Navigation item tree. |
| ``user`` | Optional | `null` | User object with `name` and `email`. |
| ``logout_url`` | Optional | `null` | When present, renders a POST logout form. |
| ``logout_text`` | Optional | `Logout` | Logout button text. |
| ``class`` | Optional | `''` | Additional sidebar classes. |
| ``id`` | Optional | `pixelfix-sidebar` | Sidebar id. |
| ``brand_url`` | Optional | `/` | Brand link destination. |
| ``search`` | Optional | `true` | Show menu filter. |
| ``search_placeholder`` | Optional | `Filter menu…` | Search placeholder. |
| ``search_empty_text`` | Optional | `No matching pages.` | Message when menu filtering finds nothing. |
| ``breakpoint`` | Optional | `991.98` | Responsive breakpoint stored in data attributes. |
| ``persistence`` | Optional | `false` | Enable sidebar state persistence. |
| ``mini`` | Optional | `false` | Enable mini sidebar mode. |
| ``collapsed`` | Optional | `false` | Start collapsed. |
| ``without_hover`` | Optional | `false` | Disable hover behaviour. |
| ``accordion`` | Optional | `true` | Enable accordion-style child navigation. |
| ``animation_speed`` | Optional | `300` | Sidebar animation speed. |


## Behavior

Each menu item may define `label`, `url`, `icon`, `active`, `disabled`, `badge`, `badge_class`, `open`, `children` and `header`. Items with `header` truthy become section headers; items with `children` render recursive trees and a toggle button. The logout form outputs the framework `csrf` value from the surrounding template context.

## Example

```twig
{% include 'components/layout/sidebar.twig' with {
    brand: 'Task Manager',
    logo: 'TM',
    brand_url: route('home'),
    items: [
        {
            label: 'Dashboard',
            url: route('dashboard'),
            icon: '▣',
            active: true
        },
        {
            label: 'Tasks',
            icon: '✓',
            children: [
                {label: 'All Tasks', url: route('tasks.index')},
                {label: 'Create Task', url: route('tasks.create')}
            ]
        }
    ],
    search: true
} %}
```

## Usage

Use inside `.pixelfix-app-wrapper` with the matching framework sidebar styles and JavaScript. Keep the item tree as data so navigation can be generated consistently.

## Notes

For logout, provide a valid `logout_url` and ensure a `csrf` value is available in the template scope because the source renders `{{ csrf|raw }}`.

## Related Components

- `components/layout/header.twig`
- `components/layout/main.twig`
