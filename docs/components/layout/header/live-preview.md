# Live Preview Header Item

Renders the Live Preview navigation item.

**Component:** `layout/header/live-preview.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `live_preview_url` | `#` | Live Preview link URL. |

## Usage

```twig
{% include 'components/layout/header/live-preview.twig' with {
    live_preview_url: '/preview'
} %}
```
