# Floating Select

Renders a Bootstrap floating-label `<select>` with automatic old-input restoration, validation state, accessible feedback, structured options, and optional partials.

**Component:** `components/floating/select.twig`

---

## Defaults

The component renders a complete select field without requiring parameters. It defaults to the name and ID `select`, the label and placeholder `Select an option`, an empty option list, and a non-required field.

```twig
{% include
    'components/floating/select.twig'
%}
```

For repeated selects, supply a unique `name` or `id` to avoid duplicate IDs.

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | `select` | Select name. Multiple selects automatically append `[]` unless already present. |
| `id` | Resolved name | Select ID and label target. |
| `label` | `Select an option` | Floating label. |
| `placeholder` | `Select an option` | Text for the empty-value placeholder option. |
| `show_placeholder` | `true` | Shows the placeholder option for single selects. Explicit `false` is respected. |
| `placeholder_disabled` | `false` | Disables the placeholder option. Useful with required selects. |
| `options` | `{}` | Flat map of `value: label` entries or a list of structured option definitions. |
| `value` | `''` | Initial selected value; flashed old input takes precedence. For multiple selects, provide an array of values. |
| `required` | `false` | Adds the native required attribute and a label asterisk. |
| `disabled` | `false` | Disables the select. |
| `autofocus` | `false` | Adds autofocus. Use on at most one field per page. |
| `multiple` | `false` | Enables multi-selection and automatically adds `[]` to the field name. |
| `size` | Not set | Native select size. Supply an integer when using a list-style select. |
| `autocomplete` | Not set | Optional native autocomplete value. |
| `form` | Not set | Associates the select with a form by ID. |
| `class` | `''` | Backward-compatible alias for additional select classes. |
| `select_class` | `class` or `''` | Additional classes on the select element. |
| `wrapper_class` | `''` | Additional classes on the floating-label wrapper. |
| `label_class` | `''` | Additional classes on the label. |
| `help_text` | `''` | Optional helper text connected through `aria-describedby`. |
| `validation_message` | Derived | Custom feedback when no server-side error is available. |
| `show_valid_state` | `true` | Non-empty flashed old input without a validation error receives `is-valid`. Explicit `false` disables this state. |
| `aria_describedby` | `''` | Additional element IDs to append to automatic help/error references. |
| `label_partial` | `''` | Replaces the complete `<label>` element. |
| `help_partial` | `''` | Replaces helper-text contents inside the `form-text` wrapper. |
| `feedback_partial` | `''` | Replaces validation-feedback contents inside the `invalid-feedback` wrapper. |
| `options_partial` | `''` | Replaces generated options inside the `<select>`. The partial is responsible for rendering the desired `<option>` elements. |

---

## Basic Usage

```twig
{% include
    'components/floating/select.twig'
    with {
        name:
            'status',

        label:
            'Status',

        required:
            true,

        options: {
            active:
                'Active',

            inactive:
                'Inactive',
        },
    }
    only
%}
```

## Complete Example

```twig
{% include
    'components/floating/select.twig'
    with {
        name:
            'country',

        id:
            'student-country',

        label:
            'Country',

        placeholder:
            'Choose a country',

        value:
            student.country_code|default(''),

        required:
            true,

        placeholder_disabled:
            true,

        options: {
            ZM:
                'Zambia',

            MW:
                'Malawi',

            ZW:
                'Zimbabwe',
        },

        help_text:
            'Choose the country where the student resides.',

        validation_message:
            'Please select a country.',

        wrapper_class:
            'mb-4',

        select_class:
            'student-country-select',
    }
    only
%}
```

## Structured Options

Use structured option definitions when individual options need attributes such as `disabled`. Flat maps remain supported for simple lists.

```twig
{% include
    'components/floating/select.twig'
    with {
        name:
            'role',

        label:
            'Role',

        options: [
            {
                value: 'student',
                label: 'Student',
            },
            {
                value: 'staff',
                label: 'Staff',
                disabled: true,
            },
            {
                value: 'administrator',
                label: 'Administrator',
            },
        ],
    }
    only
%}
```

## Validation and Old Input

The component uses PixelFix `has_error()`, `error()`, and `old()` helpers. When a field has an error, the select receives `is-invalid`, `aria-invalid="true"`, and associated feedback. Flashed old input takes precedence over the configured `value`. A non-empty flashed old value without an error receives `is-valid` by default; set `show_valid_state: false` to disable that state.

If `multiple: true`, supply an array as the default value for selected options. The component appends `[]` to the HTML field name unless it already ends with `[]`.

## Partial Overrides

Label, help, feedback and option rendering can be customized independently.

```twig
{% include
    'components/floating/select.twig'
    with {
        name:
            'department',

        label:
            'Department',

        label_partial:
            'forms/partials/floating-label.twig',

        help_partial:
            'forms/partials/department-help.twig',

        feedback_partial:
            'forms/partials/field-feedback.twig',

        options_partial:
            'forms/partials/department-options.twig',
    }
    only
%}
```

Partials receive explicit context only:

- `label_partial`: `id`, `name`, `label`, `required`, `label_class`.
- `help_partial`: `id`, `input_id`, `name`, `label`, `help_text`.
- `feedback_partial`: `id`, `input_id`, `name`, `label`, `has_error`, `error_message`, `validation_message`.
- `options_partial`: `id`, `name`, `options`, `selected_value`, `multiple`.

## Security and Accessibility

Option values and labels, selected values, labels, helper text, and validation messages are escaped by Twig. The component associates help and error content with the select using `aria-describedby`, and adds `aria-invalid="true"` when PixelFix reports a field error. For trusted, application-authored option markup, use an `options_partial`; do not output untrusted values as raw HTML.

---
