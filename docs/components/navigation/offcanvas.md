# Offcanvas Component

Renders a Bootstrap offcanvas panel with configurable placement, backdrop, scrolling, title, and raw body content.

**Component:** `navigation/offcanvas.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `id` | Required | Unique offcanvas id. |
| `title` | `Menu` | Offcanvas title. |
| `content` | `''` | Body content. Rendered as raw HTML. |
| `placement` | `start` | Supported values: `start`, `end`, `top`, `bottom`. |
| `backdrop` | `true` | Controls the Bootstrap backdrop. |
| `scroll` | `false` | Controls body scrolling while the offcanvas is open. |

## Behavior and Notes

Unsupported placement values fall back to `start`.

`content` is rendered with `|raw`.

## Usage

```twig
{% include 'components/navigation/offcanvas.twig' with {
    id: 'mobile-menu',
    title: 'Menu',
    placement: 'start',
    backdrop: true,
    scroll: false,
    content: '<p>Navigation goes here.</p>'
} %}
```
