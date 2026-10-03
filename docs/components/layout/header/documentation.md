# Documentation Header Item

Renders the Documentation link in the application header.

**Component:** `components/layout/header/documentation.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `documentation_url` | `#` | URL opened by the Documentation item. |

---

# Usage

```twig
{% include
    'components/layout/header/documentation.twig'
    with {
        documentation_url:
            '/docs'
    }
    only
%}
```
