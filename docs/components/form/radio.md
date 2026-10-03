# Radio

Renders a Bootstrap radio group from an associative options collection.

**Component:** `components/form/radio.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | Required | Radio group name. |
| `label` | `''` | Group label. |
| `options` | `{}` | Associative array of option values and labels. |
| `inline` | `false` | Displays radio controls inline when enabled. |
| `required` | `false` | Adds required to the radio controls. |
| `value` | `''` | Initial selected value. |
| `class` | `''` | Additional radio CSS classes. |
| `disabled` | `false` | Disables the radio controls. |
| `validation_message` | Derived | Custom validation message. |

---

# Options

```twig
{% set genderOptions = {
    male: 'Male',
    female: 'Female',
    other: 'Other'
} %}
```

---

# Usage

```twig
{% include
    'components/form/radio.twig'
    with {
        name:
            'gender',

        label:
            'Gender',

        options:
            genderOptions,

        inline:
            true,

        required:
            true
    }
    only
%}
```
