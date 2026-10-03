# Live Preview Header Item

Renders the Live Preview link in the application header.

**Component:** `components/layout/header/live-preview.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `live_preview_url` | `#` | URL opened by the Live Preview item. |

---

# Usage

```twig
{% include
    'components/layout/header/live-preview.twig'
    with {
        live_preview_url:
            '/preview'
    }
    only
%}
```
