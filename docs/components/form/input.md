# Input

Renders a standard Bootstrap form input with old-input restoration and validation feedback.

**Component:** `components/form/input.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `type` | `text` | HTML input type. |
| `name` | `''` | Input name and id. |
| `label` | `null` | Optional field label. |
| `placeholder` | `''` | Input placeholder. |
| `required` | `false` | Adds the required attribute. |
| `class` | `''` | Additional input CSS classes. |
| `maxlength` | `null` | Maximum input length. |
| `autofocus` | `false` | Adds autofocus. |
| `value` | `''` | Initial field value. |
| `validationMessage` | `null` | Custom validation message. |

---

# Usage

```twig
{% include
    'components/form/input.twig'
    with {
        type:
            'email',

        name:
            'email',

        label:
            'Email',

        placeholder:
            'Email address',

        required:
            true
    }
    only
%}
```

---

## Password Input

Password values are not restored from the resolved old value.

```twig
{% include
    'components/form/input.twig'
    with {
        type:
            'password',

        name:
            'password',

        label:
            'Password',

        required:
            true
    }
    only
%}
```
