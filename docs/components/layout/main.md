# Main Content Component

Renders the main PixelFix application content area, with optional title, breadcrumbs, and configurable container/content classes.

**Component:** `layout/main.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `class` | `''` | Additional classes for the main element. |
| `id` | `pixelfix-main` | Main element id. |
| `title` | `null` | Optional page title. |
| `breadcrumbs` | `[]` | Optional breadcrumb array. |
| `content` | `''` | Main content. Rendered as raw HTML. |
| `container_class` | `''` | Additional class applied to the main container elements. |
| `content_class` | `''` | Additional class applied to the main content wrapper. |

## Behavior and Notes

A content header is rendered when `title` is set or when breadcrumbs are present.

Breadcrumb entries use `label` and optional `url`. The final breadcrumb is always rendered as the current page, even if a URL is supplied.

`content` is rendered with `|raw`.

## Usage

```twig
{% include 'components/layout/main.twig' with {
    id: 'dashboard-main',
    class: 'dashboard-page',
    title: 'Dashboard',
    breadcrumbs: [
        { label: 'Home', url: '/' },
        { label: 'Dashboard' }
    ],
    content: '<p>Dashboard content</p>'
} %}
```
