# Select

Renders a standard Bootstrap select field with placeholder, options, old-input restoration, and validation feedback.

**Component:** `components/form/select.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | Required | Select name and id. |
| `label` | `''` | Field label. |
| `required` | `false` | Adds the required attribute. |
| `options` | `{}` | Associative array of option values and labels. |
| `placeholder` | `Select` | Placeholder option text. |
| `value` | `''` | Initial selected value. |
| `validation_message` | `null` | Custom validation message. |

---

# Options

```twig
{% set statusOptions = {
    active: 'Active',
    inactive: 'Inactive'
} %}
```

---

# Usage

```twig
{% include
    'components/form/select.twig'
    with {
        name:
            'status',

        label:
            'Status',

        options:
            statusOptions,

        placeholder:
            'Select status',

        value:
            'active',

        required:
            true
    }
    only
%}
```
