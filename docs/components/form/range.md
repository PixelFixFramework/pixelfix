# Range

Renders a Bootstrap range input with configurable bounds, step, state, and validation feedback.

**Component:** `components/form/range.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | Required | Range input name and id. |
| `label` | `''` | Field label. |
| `min` | `0` | Minimum range value. |
| `max` | `100` | Maximum range value. |
| `step` | `1` | Range step. |
| `value` | `min` | Initial value. |
| `class` | `''` | Additional CSS classes. |
| `required` | `false` | Adds the required attribute. |
| `disabled` | `false` | Disables the range input. |
| `validation_message` | `null` | Custom validation message. |

---

# Usage

```twig
{% include
    'components/form/range.twig'
    with {
        name:
            'volume',

        label:
            'Volume',

        min:
            0,

        max:
            100,

        step:
            5,

        value:
            50
    }
    only
%}
```
