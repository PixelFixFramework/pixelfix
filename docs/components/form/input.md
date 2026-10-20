# Input

Renders a standard Bootstrap form input with a label above the field, optional help text, old-input restoration and validation feedback. This is the **normal form input**, not the floating input or input-group component.

**Component:** `components/form/input.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `type` | `text` | Native HTML input type. |
| `name` | `input` | Form field name. Also used as the default ID. |
| `id` | `name` | Optional separate HTML ID. |
| `label` | `Input` | Label rendered above the field. Set to `''` to omit it; supply `aria_label` when no visible label is used. |
| `label_class` | `form-label` | Additional label styling. |
| `placeholder` | `''` | Placeholder text. |
| `value` | `''` | Initial value; flashed old input takes precedence. Password values are always blank. |
| `required` | `false` | Adds the native required attribute and a visible indicator. |
| `class` / `input_class` | `''` | Additional input classes; `input_class` takes precedence. |
| `wrapper_class` | `mb-3` | Classes on the outer field wrapper. |
| `size` | `null` | Set to `sm` or `lg` for Bootstrap input sizing. |
| `autocomplete` | inferred when recognized | Explicit native autocomplete value, or inferred for email, password, name, username and telephone fields. Set to `''` to disable it. |
| `disabled`, `readonly`, `autofocus` | `false` | Native input flags. Explicit `false` is respected. |
| `maxlength`, `minlength`, `min`, `max`, `step`, `pattern`, `inputmode` | `null` | Native input constraints and hints. |
| `form`, `accept`, `multiple`, `title` | `null` / `false` | Optional native input attributes. |
| `validation_message` | Generated message | Custom validation feedback. Legacy `validationMessage` is also accepted. |
| `show_valid_state` | `true` | Adds `is-valid` after non-empty flashed old input when no error exists. An initial configured value alone does not mark the field valid. |
| `help_text` | `''` | Help text displayed below the input. |
| `aria_label`, `aria_describedby` | `null` / `''` | Accessibility attributes. Help and error IDs are added to `aria-describedby` automatically. |
| `required_indicator` | `*` | Required indicator; use `''` to suppress it. |
| `label_partial`, `input_partial`, `help_partial`, `feedback_partial` | `''` | Optional templates for customizing individual parts of the field. |

---

## Minimal usage

```twig
{% include
    'components/form/input.twig'
%}
```

This renders a standard text input with a label and Bootstrap styling. No floating-label markup or input-group wrapper is added.

## Email input

```twig
{% include
    'components/form/input.twig'
    with {
        type:
            'email',

        name:
            'email',

        label:
            'Email Address',

        placeholder:
            'name@example.com',

        required:
            true,

        autocomplete:
            'email',
    }
    only
%}
```

## Password input

Password fields never render configured values or flashed old input.

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
            true,

        autocomplete:
            'current-password',
    }
    only
%}
```

## Help text and custom feedback

```twig
{% include
    'components/form/input.twig'
    with {
        name:
            'username',

        label:
            'Username',

        help_text:
            'Use letters, numbers and underscores.',

        help_partial:
            'forms/partials/username-help.twig',

        feedback_partial:
            'forms/partials/field-feedback.twig',
    }
    only
%}
```

Partials receive explicit context. The label partial receives `id`, `name`, `label`, `required`, `required_indicator` and `label_class`. The input partial receives the native input attributes and resolved validation state. The help partial receives `id`, `input_id`, `name` and `help_text`. The feedback partial receives `id`, `input_id`, `name`, `error_message`, `validation_message` and `has_error`.

## Security and validation notes

- Labels, placeholders, values, help text and validation feedback are rendered through Twig's normal escaping.
- Password values are never restored or prefilled.
- Validation state comes from PixelFix's `errors()`, `has_error()`, `error()` and `old()` helpers.
- `aria-invalid` is set on fields with errors. Help and error descriptions are associated through `aria-describedby`.
- The component uses Bootstrap classes; the application must load Bootstrap CSS.
