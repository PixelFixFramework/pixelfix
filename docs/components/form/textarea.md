# Textarea

Renders a standard Bootstrap textarea with configurable rows, old-input restoration, and validation feedback.

**Component:** `components/form/textarea.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | Required | Textarea name and id. |
| `label` | `''` | Field label. |
| `rows` | `4` | Number of textarea rows. |
| `placeholder` | `''` | Placeholder text. |
| `required` | `false` | Adds the required attribute. |
| `class` | `''` | Additional CSS classes. |
| `value` | `''` | Initial textarea value. |
| `validation_message` | `null` | Custom validation message. |

---

# Usage

```twig
{% include
    'components/form/textarea.twig'
    with {
        name:
            'description',

        label:
            'Description',

        rows:
            6,

        placeholder:
            'Enter description',

        required:
            true
    }
    only
%}
```
