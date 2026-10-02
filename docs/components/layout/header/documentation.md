# Documentation Header Item

Renders the Documentation navigation item used by the default header.

**Component:** `layout/header/documentation.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `documentation_url` | `#` | Documentation link URL. |

## Usage

```twig
{% include 'components/layout/header/documentation.twig' with {
    documentation_url: '/docs'
} %}
```
