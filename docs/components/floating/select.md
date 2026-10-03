# Floating Select

Renders a Bootstrap floating-label select with options and validation state.

**Component:** `components/floating/select.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | Required | Select name and id. |
| `label` | `''` | Floating label text. |
| `required` | `false` | Adds the required attribute. |
| `options` | `{}` | Associative array of option values and labels. |
| `placeholder` | `Select` | Placeholder option text. |
| `validation_message` | Derived | Custom validation message used when no server error exists. |

---

# Options

`options` is an associative array where each key is the option value and each
value is the displayed option text.

```twig
{% set countries = {
    zm: 'Zambia',
    za: 'South Africa',
    bw: 'Botswana'
} %}
```

---

# Usage

```twig
{% include
    'components/floating/select.twig'
    with {
        name:
            'country',

        label:
            'Country',

        options:
            countries,

        placeholder:
            'Select country',

        required:
            true
    }
    only
%}
```
