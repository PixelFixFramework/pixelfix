# Floating Input

Renders a Bootstrap floating-label input with automatic validation state and framework old-input/error integration.

**Component:** `components/floating/input.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `type` | `text` | HTML input type. |
| `name` | Required | Input name and id. |
| `label` | `''` | Floating label text. |
| `required` | `false` | Adds the required attribute. |
| `validation_message` | Derived | Custom validation message used when the field has no server error. |
| `autocomplete` | Derived | Autocomplete value. Automatically inferred for common email, password, name, and username fields. |

---

# Usage

```twig
{% include
    'components/floating/input.twig'
    with {
        type:
            'email'

        name:
            'email'

        label:
            'Email Address'

        required:
            true

        autocomplete:
            'email'
    }
    only
%}
```

---

## Validation

The component uses `has_error()` and `error()`/framework validation state to
apply `is-invalid`. A non-empty old value produces the valid state.

---

## Complete Example

```twig
{% include
    'components/floating/input.twig'
    with {
        type:
            'text',

        name:
            'full_name',

        label:
            'Full Name',

        required:
            true,

        validation_message:
            'Please provide your full name.'
    }
    only
%}
```
