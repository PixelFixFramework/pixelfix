# Floating Textarea

Renders a Bootstrap floating-label `<textarea>` with configurable height, flashed old-input restoration, validation state, accessible help/error associations, and optional partials.

**Component:** `components/floating/textarea.twig`

---

## Defaults

The component renders a complete textarea field without requiring parameters. It defaults to the field name and ID `textarea`, label and placeholder `Message`, five rows, and an optional field.

```twig
{% include
    'components/floating/textarea.twig'
%}
```

For repeated fields, supply a unique `name` or `id` to avoid duplicate IDs.

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | `textarea` | Textarea field name. |
| `id` | Resolved name | Textarea ID and label target. |
| `label` | `Message` | Floating label. |
| `placeholder` | Label | Placeholder used by Bootstrap's floating-label layout. |
| `value` | `''` | Initial value. Flashed old input takes precedence, including an intentionally empty old value. |
| `rows` | `5` | Number of visible text rows. Also determines the default inline height. |
| `height` | `rows × 30px` | Explicit textarea height, such as `180px` or `12rem`. |
| `required` | `false` | Adds the native required attribute and a visible asterisk. |
| `disabled` | `false` | Disables the textarea. |
| `readonly` | `false` | Makes the value read-only. |
| `autofocus` | `false` | Adds autofocus. Use on at most one field per page. |
| `minlength` / `maxlength` | Not set | Native character-length constraints. |
| `cols` | Not set | Native textarea column count. |
| `wrap` | Not set | Native text-wrapping mode (`soft` or `hard`). |
| `form` | Not set | Associates the textarea with a form by ID. |
| `class` | `''` | Backward-compatible alias for additional textarea classes. |
| `textarea_class` | `class` or `''` | Additional classes on the textarea. |
| `wrapper_class` | `''` | Additional classes on the floating-label wrapper. |
| `label_class` | `''` | Additional classes on the label. |
| `style` | `''` | Additional inline CSS appended after the height declaration. |
| `help_text` | `''` | Optional helper text associated through `aria-describedby`. |
| `validation_message` | Derived | Custom feedback when no server-side error is available. |
| `show_valid_state` | `true` | Non-empty flashed old input without a validation error receives `is-valid`. Explicit `false` disables that state. |
| `aria_describedby` | `''` | Additional element IDs combined with automatic help/error references. |
| `label_partial` | `''` | Replaces the complete `<label>` element. |
| `help_partial` | `''` | Replaces helper-text content. |
| `feedback_partial` | `''` | Replaces validation-feedback content. Receives both the error and derived validation message. |

## Basic example

```twig
{% include
    'components/floating/textarea.twig'
    with {
        name:
            'description',

        label:
            'Description',

        placeholder:
            'Describe the item',

        rows:
            6,

        required:
            true,
    }
    only
%}
```

## Initial value and help text

```twig
{% include
    'components/floating/textarea.twig'
    with {
        name:
            'notes',

        label:
            'Notes',

        value:
            existingRecord.notes,

        help_text:
            'Add any details that may help the reviewer.',

        maxlength:
            2000,
    }
    only
%}
```

If the form is redirected back with flashed old input, that submitted value takes precedence over `value`. Empty old input is preserved rather than replaced by the initial model value.

## Custom partials

```twig
{% include
    'components/floating/textarea.twig'
    with {
        name:
            'comments',

        label:
            'Comments',

        label_partial:
            'forms/partials/field-label.twig',

        help_partial:
            'forms/partials/comments-help.twig',

        feedback_partial:
            'forms/partials/field-feedback.twig',
    }
    only
%}
```

Partial context:

- `label_partial`: `id`, `name`, `label`, `required`, `label_class`.
- `help_partial`: `id`, `input_id`, `name`, `label`, `help_text`.
- `feedback_partial`: `id`, `input_id`, `name`, `label`, `has_error`, `error_message`, `validation_message`.

## Validation behaviour

The component uses PixelFix's `has_error(name)`, `error(name)`, and `old(name, default)` template helpers. Errors apply `is-invalid`, set `aria-invalid="true"`, and associate the feedback element via `aria-describedby`. Help text and caller-provided described-by IDs are combined with that feedback ID.

A non-empty flashed old value receives `is-valid` when no error exists. Set `show_valid_state: false` to disable that behavior. An explicitly provided initial value alone does not mark the field valid.

All normal values and feedback messages are rendered with Twig escaping. Bootstrap CSS is required for the floating-label and validation styles.
