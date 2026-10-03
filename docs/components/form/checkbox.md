# Checkbox

Renders a Bootstrap checkbox with validation handling, old-input restoration, and optional HTML label content.

**Component:** `components/form/checkbox.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | Required | Checkbox name and id. |
| `label` | `''` | Plain-text checkbox label. |
| `label_html` | `null` | Raw HTML label content. When supplied, it takes precedence over `label`. |
| `value` | `1` | Submitted checkbox value. |
| `required` | `false` | Adds the required attribute. |
| `checked` | `false` | Initial checked state. |
| `class` | `''` | Additional checkbox CSS classes. |
| `disabled` | `false` | Disables the checkbox. |
| `validation_message` | `null` | Custom validation message. |

---

# Usage

```twig
{% include
    'components/form/checkbox.twig'
    with {
        name:
            'terms'

        label:
            'I agree to the terms.'

        value:
            '1'

        required:
            true

        checked:
            false
    }
    only
%}
```

---

## HTML Label

Use `label_html` when the label contains markup.

```twig
{% include
    'components/form/checkbox.twig'
    with {
        name:
            'terms',

        label:
            'Terms',

        label_html:
            'I agree to the <a href="/terms">Terms and Conditions</a>.',

        required:
            true
    }
    only
%}
```

---

## Validation

The component reads field errors using the framework `errors()` and `has_error()`
helpers and restores the checked state using `old()`.
