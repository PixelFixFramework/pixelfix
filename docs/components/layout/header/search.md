# Search Header Item

Renders a desktop search form and a small-screen search link.

**Component:** `layout/header/search.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `search_url` | `#` | Search destination URL. |

## Behavior and Notes

Desktop search uses GET with a `query` field.

The small-screen link points directly to `search_url`.

## Usage

```twig
{% include 'components/layout/header/search.twig' with {
    search_url: route('search')
} %}
```
