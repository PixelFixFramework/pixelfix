# Input Group

Renders a Bootstrap input group with optional icon, validation handling, autocomplete, and state controls.

**Component:** `components/form/input-group.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `type` | `text` | HTML input type. |
| `name` | Required | Input name and id. |
| `label` | `''` | Input label. |
| `label_class` | `form-label` | CSS class applied to the label. |
| `placeholder` | `''` | Input placeholder. |
| `required` | `false` | Adds the required attribute. |
| `icon` | `null` | Optional raw icon markup. |
| `icon_position` | `start` | Places the icon at `start` or `end`. |
| `value` | `''` | Initial field value. |
| `class` | `''` | Additional input CSS classes. |
| `maxlength` | `null` | Maximum input length. |
| `autofocus` | `false` | Adds autofocus. |
| `disabled` | `false` | Disables the input. |
| `readonly` | `false` | Makes the input read-only. |
| `validation_message` | `null` | Custom validation message. |
| `autocomplete` | Derived | Explicit autocomplete value or an automatically inferred value. |

---

# Usage

```twig
{% include
    'components/form/input-group.twig'
    with {
        type:
            'email',

        name:
            'email',

        label:
            'Email',

        placeholder:
            'Email address',

        icon:
            '<i class="bi bi-envelope"></i>',

        icon_position:
            'start',

        required:
            true,

        autocomplete:
            'email'
    }
    only
%}
```

---

## Icon Position

`icon_position` supports `start` and `end`.

```twig
{% include
    'components/form/input-group.twig'
    with {
        name:
            'search',

        icon:
            '<i class="bi bi-search"></i>',

        icon_position:
            'end'
    }
    only
%}
```
