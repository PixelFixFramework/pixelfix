# Floating Input

Renders a Bootstrap floating-label input with automatic old-input restoration, validation state, accessible feedback, and optional partials.

**Component:** `components/floating/input.twig`

---

## Defaults

The component renders a complete text input without requiring parameters. It defaults to the name and ID `input`, the label `Input`, and a non-required field.

```twig
{% include
    'components/floating/input.twig'
%}
```

For repeated inputs, provide a unique `name` or `id` to avoid duplicate IDs.

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `type` | `text` | HTML input type. |
| `name` | `input` | Input name. Also used as the ID when `id` is not supplied. |
| `id` | Resolved name | Input ID and the target for its label. |
| `label` | `Input` | Floating label text. |
| `placeholder` | Label | Placeholder required for Bootstrap floating-label behavior. |
| `value` | `''` | Initial value; flashed old input takes precedence. Password fields are always blank. |
| `required` | `false` | Adds the required attribute and an asterisk in the label. |
| `disabled` | `false` | Disables the input. |
| `readonly` | `false` | Makes the input read-only. |
| `autofocus` | `false` | Adds autofocus. Use on at most one field per page. |
| `autocomplete` | Derived | Explicit autocomplete value. If omitted, common email, password, name, and username values are inferred. Pass an empty string to suppress the attribute. |
| `class` | `''` | Backward-compatible alias for additional input classes. |
| `input_class` | `class` or `''` | Additional input CSS classes. |
| `wrapper_class` | `''` | Additional classes on the floating-label wrapper. |
| `label_class` | `''` | Additional label classes. |
| `help_text` | `''` | Optional helper text, associated with the input using `aria-describedby`. |
| `validation_message` | Derived | Custom feedback text when no server-side error message is available. |
| `show_valid_state` | `true` | When true, flashed non-empty old input without a field error receives `is-valid`. Explicit `false` disables this state. |
| `maxlength`, `minlength` | Not set | Native input length constraints. |
| `min`, `max`, `step` | Not set | Native numeric or date constraints where supported by the input type. |
| `pattern` | Not set | Native validation pattern. |
| `inputmode` | Not set | Virtual-keyboard hint. |
| `aria_describedby` | `''` | Additional element IDs to append to automatic help/error references. |
| `label_partial` | `''` | Replaces the full `<label>` element. |
| `help_partial` | `''` | Replaces helper-text contents inside the `form-text` wrapper. |
| `feedback_partial` | `''` | Replaces validation-feedback contents inside the `invalid-feedback` wrapper. |

---

## Basic Usage

```twig
{% include
    'components/floating/input.twig'
    with {
        type:
            'email',

        name:
            'email',

        label:
            'Email Address',

        required:
            true,

        autocomplete:
            'email',
    }
    only
%}
```

## Complete Example

```twig
{% include
    'components/floating/input.twig'
    with {
        type:
            'text',

        name:
            'full_name',

        id:
            'student-full-name',

        label:
            'Full Name',

        placeholder:
            'Enter your full name',

        value:
            student.name|default(''),

        required:
            true,

        autocomplete:
            'name',

        maxlength:
            120,

        help_text:
            'Enter your name as it appears on official documents.',

        validation_message:
            'Please provide your full name.',

        wrapper_class:
            'mb-4',

        input_class:
            'student-name-input',
    }
    only
%}
```

## Validation and Old Input

The component uses PixelFix `has_error()`, `error()`, and `old()` helpers. When the field has a validation error it receives `is-invalid`, `aria-invalid="true"`, and an associated feedback message. Non-password fields restore flashed old input before falling back to the supplied `value`. Password fields never render a prefilled or restored value.

The component preserves the existing valid-state behavior: non-empty flashed old input without a field error receives `is-valid` by default. Set `show_valid_state: false` to disable that state if your form applies validation classes elsewhere.

## Password Input

```twig
{% include
    'components/floating/input.twig'
    with {
        type:
            'password',

        name:
            'password',

        label:
            'Password',

        autocomplete:
            'new-password',

        required:
            true,
    }
    only
%}
```

Password fields ignore both the configured `value` and flashed old input.

## Partial Overrides

The component supports independent label, helper-text, and validation-feedback partials.

```twig
{% include
    'components/floating/input.twig'
    with {
        name:
            'username',

        label:
            'Username',

        label_partial:
            'forms/partials/floating-label.twig',

        help_partial:
            'forms/partials/username-help.twig',

        feedback_partial:
            'forms/partials/field-feedback.twig',
    }
    only
%}
```

Partials receive explicit context only:

- `label_partial`: `id`, `name`, `label`, `required`, `label_class`.
- `help_partial`: `id`, `input_id`, `name`, `label`, `help_text`.
- `feedback_partial`: `id`, `input_id`, `name`, `label`, `has_error`, `error_message`, `validation_message`.

## Security and Accessibility

Text values, labels, attributes, helper text, and validation messages are escaped by Twig. Password values are never rendered. The component connects helper text and server-side errors to the input with `aria-describedby`, and sets `aria-invalid="true"` when PixelFix reports a field error.

---
