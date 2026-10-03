# Alert

Renders a Bootstrap alert with optional title and dismissible behavior.

**Component:** `components/feedback/alert.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `type` | `primary` | Bootstrap alert type. |
| `title` | `null` | Optional alert title. |
| `dismissible` | `false` | Determines whether the alert is dismissible. |
| `content` | `''` | Alert content. |

---

# Usage

```twig
{% include
    'components/feedback/alert.twig'
    with {
        type:
            'success'

        title:
            'Success'

        dismissible:
            true

        content:
            'The operation completed successfully.'
    }
    only
%}
```

---

## Complete Example

```twig
{% include
    'components/feedback/alert.twig'
    with {
        type:
            'danger',

        title:
            'Validation Error',

        dismissible:
            true,

        content:
            'Please correct the highlighted fields.'
    }
    only
%}
```
