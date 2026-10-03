# Floating Textarea

Renders a Bootstrap floating-label textarea with configurable rows and validation state.

**Component:** `components/floating/textarea.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | Required | Textarea name and id. |
| `label` | `''` | Floating label text. |
| `required` | `false` | Adds the required attribute. |
| `rows` | `5` | Logical textarea row count used to calculate its height. |
| `validation_message` | Derived | Custom validation message used when no server error exists. |

---

# Usage

```twig
{% include
    'components/floating/textarea.twig'
    with {
        name:
            'description'

        label:
            'Description'

        rows:
            6

        required:
            true

        validation_message:
            'Please provide a description.'
    }
    only
%}
```
