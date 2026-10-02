# Sidebar Component

Renders a configurable PixelFix application sidebar with branding, searchable navigation, nested menu items, optional user information, and optional logout.

**Component:** `layout/sidebar.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `brand` | `PixelFix` | Brand text. |
| `logo` | `P` | Brand logo/short text. |
| `items` | `[]` | Navigation item array. |
| `user` | `null` | Optional user object used for the sidebar footer. |
| `logout_url` | `null` | Optional logout URL. When set, a POST logout form is rendered. |
| `logout_text` | `Logout` | Logout button text. |
| `class` | `''` | Additional sidebar classes. |
| `id` | `pixelfix-sidebar` | Sidebar id. |
| `brand_url` | `/` | Brand link URL. |
| `search` | `true` | Whether to render the menu search box. |
| `search_placeholder` | `Filter menu…` | Search input placeholder. |
| `search_empty_text` | `No matching pages.` | Message displayed when search has no matches. |
| `breakpoint` | `991.98` | Breakpoint value written to `data-sidebar-breakpoint`. |
| `persistence` | `false` | Enables persistence data attribute. |
| `mini` | `false` | Adds the mini sidebar class and data attribute. |
| `collapsed` | `false` | Adds the collapsed class. |
| `without_hover` | `false` | Adds the without-hover class. |
| `accordion` | `true` | Controls the sidebar accordion data attribute. |
| `animation_speed` | `300` | Animation speed data value. |

## Behavior and Notes

Navigation items are recursive and support `label`, `url`, `icon`, `active`, `open`, `disabled`, `badge`, `badge_class`, `header`, and `children`.

A navigation item with `header=true` renders a section header instead of a link.

An item with children renders a toggle and nested navigation tree.

The sidebar navigation uses `url` directly; it does not resolve a route name.

When `logout_url` is supplied, the component renders `{{ csrf|raw }}` inside the POST form, so a `csrf` value must also be available in the rendering context.

The user object is expected to expose `name` and optionally `email` for the footer.

## Usage

```twig
{% include 'components/layout/sidebar.twig' with {
    brand: 'Task Manager',
    logo: 'T',
    brand_url: route('home'),
    items: [
        {
            label: 'Dashboard',
            url: '/dashboard',
            icon: '▣',
            active: true
        },
        {
            label: 'Tasks',
            url: '/tasks',
            icon: '✓',
            children: [
                { label: 'All Tasks', url: '/tasks' },
                { label: 'Completed', url: '/tasks/completed' }
            ]
        }
    ],
    search: true
} %}
```
