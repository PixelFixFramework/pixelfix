# Badge

Renders a Bootstrap badge using the supplied badge type and text.

**Component:** `components/feedback/badge.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `type` | `primary` | Bootstrap contextual badge type. |
| `text` | `Badge` | Text displayed inside the badge. |

---

# Usage

```twig
{% include
    'components/feedback/badge.twig'
    with {
        type:
            'success'

        text:
            'Active'
    }
    only
%}
```

---

## Complete Example

```twig
{% include
    'components/feedback/badge.twig'
    with {
        type:
            'warning',

        text:
            'Pending'
    }
    only
%}
```
