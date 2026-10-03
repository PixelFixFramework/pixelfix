# Spinner

Renders a Bootstrap loading spinner with contextual styling and optional small size.

**Component:** `components/feedback/spinner.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `type` | `primary` | Bootstrap text color applied to the spinner. |
| `size` | `null` | Use `sm` for the small spinner size. |
| `label` | `Loading...` | Accessible loading text. |

---

# Usage

```twig
{% include
    'components/feedback/spinner.twig'
    with {
        type:
            'primary'

        size:
            'sm'

        label:
            'Loading students...'
    }
    only
%}
```

---

## Complete Example

```twig
{% include
    'components/feedback/spinner.twig'
    with {
        type:
            'success',

        label:
            'Saving changes...'
    }
    only
%}
```
