# Select

Renders a **standard Bootstrap select field** with a label above the control, options, old-input restoration, and accessible validation feedback. This is the normal form select, not the floating select.

**Component:** `components/form/select.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | `select` | Form field name. Used as the default HTML ID and validation key. |
| `id` | `name` | Optional separate HTML ID. |
| `label` | `Select` | Visible label above the select. Set to `''` to omit it; provide `aria_label` if no visible label is used. |
| `options` | `{}` | Associative value-to-label map or a list of structured option definitions. |
| `placeholder` | `Select an option` | Text for the blank placeholder option. |
| `show_placeholder` | `true` for single selects | Shows the placeholder option. Multiple selects omit it by default. |
| `placeholder_disabled` | `required` value | Disables the placeholder option by default for required single selects. |
| `placeholder_hidden` | `false` | Adds the HTML `hidden` attribute to the placeholder option. |
| `value` | `''` | Initial selected value or array of values; flashed old input takes precedence. |
| `required`, `disabled`, `autofocus`, `multiple` | `false` | Native select attributes. `multiple` renders `name[]` when the name does not already end with `[]`. |
| `size` | `null` | `sm` or `lg` adds Bootstrap select sizing classes; a numeric value sets the native option-list size. |
| `class` / `select_class` | `''` | Additional classes on the select; `select_class` takes precedence. |
| `wrapper_class` | `mb-3` | Classes on the outer field wrapper. |
| `label_class` | `form-label` | Classes on the label. |
| `autocomplete`, `form`, `title` | `null` | Optional native attributes. |
| `validation_message` | Generated message | Custom validation feedback. Legacy `validationMessage` is also accepted. |
| `show_valid_state` | `true` | Adds `is-valid` after non-empty flashed old input when no error exists. An initial configured value alone does not mark the select valid. |
| `help_text` | `''` | Help text displayed below the select. |
| `aria_label`, `aria_describedby` | `null` / `''` | Accessibility attributes. Help and error IDs are added to `aria-describedby` automatically. |
| `required_indicator` | `*` | Required indicator; set to `''` to suppress it. |
| `label_partial`, `select_partial`, `options_partial`, `help_partial`, `feedback_partial` | `''` | Optional templates for customizing parts of the field. |

## Options formats

### Simple value-to-label map

```twig
{% set statusOptions = {
    active:
        'Active',

    inactive:
        'Inactive',
} %}
```

### Structured options

Each option can define its own value, label, disabled state, and default selected state.

```twig
{% set countryOptions = [
    {
        value:
            'ZM',

        label:
            'Zambia',
    },
    {
        value:
            'MW',

        label:
            'Malawi',

        disabled:
            true,
    },
] %}
```

### Option groups

```twig
{% set locationOptions = {
    Africa: {
        label:
            'Africa',

        options: {
            ZM:
                'Zambia',

            MW:
                'Malawi',
        },
    },
    Europe: {
        label:
            'Europe',

        options: {
            GB:
                'United Kingdom',

            FR:
                'France',
        },
    },
} %}
```

---

## Minimal usage

```twig
{% include
    'components/form/select.twig'
%}
```

This renders a standard select with a label, placeholder, Bootstrap styling and validation feedback. No floating-label markup is added.

## Typical usage

```twig
{% include
    'components/form/select.twig'
    with {
        name:
            'status',

        label:
            'Status',

        options:
            statusOptions,

        placeholder:
            'Select status',

        value:
            'active',

        required:
            true,
    }
    only
%}
```

## Multiple selection

```twig
{% include
    'components/form/select.twig'
    with {
        name:
            'roles',

        label:
            'Roles',

        options: {
            student:
                'Student',

            staff:
                'Staff',

            administrator:
                'Administrator',
        },

        value: [
            'staff',
            'administrator',
        ],

        multiple:
            true,

        size:
            4,
    }
    only
%}
```

For multiple selects, the component automatically uses a `[]` suffix in the submitted field name while continuing to use the original name for old input and validation.

## Help text and partials

```twig
{% include
    'components/form/select.twig'
    with {
        name:
            'department',

        label:
            'Department',

        help_text:
            'Choose the department responsible for this record.',

        label_partial:
            'forms/partials/department-label.twig',

        options_partial:
            'forms/partials/department-options.twig',

        help_partial:
            'forms/partials/department-help.twig',

        feedback_partial:
            'forms/partials/field-feedback.twig',
    }
    only
%}
```

Partials receive explicit context. The label partial receives `id`, `name`, `label`, `required`, `required_indicator`, and `label_class`. The select partial receives the resolved IDs, field name, full Bootstrap class string, options, selected values, flags and native attributes. The options partial receives `id`, `name`, `options`, `value`, `selected_value`, `selected_values`, `multiple`, `placeholder`, and placeholder flags. The help partial receives `id`, `input_id`, `select_id`, `name`, and `help_text`. The feedback partial receives `id`, `input_id`, `select_id`, `name`, `error_message`, `validation_message`, and `has_error`.

## Security and validation notes

- Labels, option labels and values, help text, placeholders, and validation feedback are escaped by Twig.
- Flashed old input overrides the configured initial value, even when the submitted selection is blank.
- Validation state comes from PixelFix's `errors()`, `has_error()`, `error()`, and `old()` helpers.
- Error state is associated with the control through `aria-describedby` and `aria-invalid`.
- A select has no native `readonly` attribute; use `disabled` when users must not change its value. Disabled controls are not submitted by browsers.
- Bootstrap CSS must be loaded by the application.
