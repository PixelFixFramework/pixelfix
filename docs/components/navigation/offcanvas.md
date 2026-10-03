# Offcanvas

Renders a Bootstrap offcanvas panel with configurable placement, backdrop, scrolling, title, and raw body content.

**Component:** `components/navigation/offcanvas.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `id` | Required | Offcanvas id. |
| `title` | `Menu` | Offcanvas title. |
| `content` | `''` | Offcanvas body content rendered as raw HTML. |
| `placement` | `start` | Panel placement: `start`, `end`, `top`, or `bottom`. |
| `backdrop` | `true` | Controls whether the backdrop is displayed. |
| `scroll` | `false` | Controls whether body scrolling is allowed while the offcanvas is open. |

---

# Usage

```twig
{% include
    'components/navigation/offcanvas.twig'
    with {
        id:
            'mobile-menu',

        title:
            'Navigation',

        content:
            '<nav>...</nav>',

        placement:
            'start',

        backdrop:
            true,

        scroll:
            false
    }
    only
%}
```

---

## Placement

Supported values are:

- `start`
- `end`
- `top`
- `bottom`

Unknown values use `start`.
