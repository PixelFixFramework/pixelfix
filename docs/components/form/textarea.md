# Textarea

Renders a **standard Bootstrap textarea** with a label above the field, configurable rows, old-input restoration, optional help text, and accessible validation feedback. This is the normal textarea, not the floating textarea.

**Component:** `components/form/textarea.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | `textarea` | Form field name. Used as the validation key and default HTML ID. |
| `id` | `name` | Optional separate HTML ID. |
| `label` | `Textarea` | Visible label above the field. Set to `''` to omit it; supply `aria_label` when no visible label is used. |
| `label_class` | `form-label` | Classes on the label. |
| `placeholder` | `''` | Placeholder text. |
| `value` | `''` | Initial textarea value; flashed old input takes precedence, including an intentionally empty submitted value. |
| `rows` | `4` | Number of visible text rows. |
| `cols` | `null` | Optional native column count. |
| `required`, `disabled`, `readonly`, `autofocus` | `false` | Native textarea flags. Explicit `false` values are respected. |
| `class` / `textarea_class` | `''` | Additional textarea classes; `textarea_class` takes precedence. |
| `wrapper_class` | `mb-3` | Classes on the outer field wrapper. `wrapper_id` optionally adds a wrapper ID. |
| `size` | `null` | Set to `sm` or `lg` for Bootstrap textarea sizing. |
| `minlength`, `maxlength` | `null` | Native text length constraints. |
| `wrap`, `dirname`, `form`, `title`, `autocomplete`, `spellcheck` | `null` | Optional native textarea attributes. |
| `validation_message` | Generated message | Custom validation feedback. Legacy `validationMessage` is also accepted. |
| `show_valid_state` | `true` | Adds `is-valid` after non-empty flashed old input when no error exists. A configured initial value alone does not mark the field valid. |
| `help_text` | `''` | Help text displayed beneath the textarea. |
| `aria_label`, `aria_describedby` | `''` | Accessibility attributes. Help and error IDs are added to `aria-describedby` automatically when appropriate. |
| `required_indicator` | `*` | Required marker; set to `''` to suppress it. |
| `label_partial`, `textarea_partial`, `help_partial`, `feedback_partial` | `''` | Optional templates for customizing individual parts of the field. |

---

## Minimal usage

```twig
{% include
    'components/form/textarea.twig'
%}
```

This renders a complete standard textarea with a label and Bootstrap styling. No floating-label wrapper is added.

## Typical usage

```twig
{% include
    'components/form/textarea.twig'
    with {
        name:
            'description',

        label:
            'Description',

        rows:
            6,

        placeholder:
            'Enter a description',

        required:
            true,
    }
    only
%}
```

## Help text and validation feedback

```twig
{% include
    'components/form/textarea.twig'
    with {
        name:
            'comments',

        label:
            'Comments',

        help_text:
            'Do not include confidential information.',

        maxlength:
            500,

        feedback_partial:
            'forms/partials/field-feedback.twig',
    }
    only
%}
```

## Partial customization

```twig
{% include
    'components/form/textarea.twig'
    with {
        name:
            'notes',

        label:
            'Notes',

        label_partial:
            'forms/partials/field-label.twig',

        textarea_partial:
            'forms/partials/textarea-control.twig',

        help_partial:
            'forms/partials/notes-help.twig',
    }
    only
%}
```

Partials receive explicit context. The label partial receives `id`, `name`, `label`, `required`, `required_indicator` and `label_class`. The textarea partial receives the resolved value, full Bootstrap class string, rows and columns, native attributes, accessibility attributes and validation state. The help partial receives `id`, `input_id`, `textarea_id`, `name` and `help_text`. The feedback partial receives `id`, `input_id`, `textarea_id`, `name`, `error_message`, `validation_message` and `has_error`.

## Security and validation notes

- Label text, placeholder, textarea value, help text and validation feedback are escaped by Twig.
- Flashed old input takes precedence over the configured initial value, including when the submitted text is empty.
- Validation state uses PixelFix's `errors()`, `has_error()`, `error()` and `old()` helpers.
- Error state is associated with the control through `aria-describedby` and `aria-invalid`.
- Bootstrap CSS must be loaded by the application for the styling classes to take effect.
