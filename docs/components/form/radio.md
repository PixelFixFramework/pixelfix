# Radio

Renders a **standard Bootstrap radio group** with a legend, option labels, old-input restoration, and accessible validation feedback. This is the normal form radio group, not a floating control.

**Component:** `components/form/radio.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | `radio` | Submitted field name and validation key. |
| `id` | `name` | Base HTML ID; each option receives a unique ID based on its position unless an option defines its own `id`. |
| `label` | `Choose an option` | Group legend. Set to `''` to omit it; provide `aria_label` when there is no visible group label. |
| `options` | `{}` | Associative value-to-label map or a list of structured option definitions. When empty, the component displays `empty_message`. |
| `value` | `''` | Initial selected value; flashed old input takes precedence. |
| `inline` | `false` | Displays radio controls inline using Bootstrap's `form-check-inline`. |
| `required` | `false` | Adds the native `required` attribute to the radio controls and displays a required indicator. |
| `disabled` | `false` | Disables all radio options. Individual structured options can also be disabled. |
| `class` | `''` | Additional classes for each radio input. |
| `option_class` | `''` | Additional classes for each option wrapper. |
| `wrapper_class` | `mb-3` | Classes for the outer wrapper; use `''` to remove them. |
| `group_class` | `''` | Additional classes for the fieldset. |
| `label_class` | `form-label` | Classes for the group legend. |
| `autofocus` | `false` | Adds `autofocus` to the first option. |
| `form`, `title` | `''` | Optional native attributes applied to each radio. |
| `aria_label` | `''` | Explicit accessible name if the visible group label is omitted. A visible legend is preferred. |
| `aria_describedby` | `''` | Extra IDs associated with the radio group; generated help and error IDs are added automatically. |
| `help_text` | `''` | Optional escaped help text displayed below the group. |
| `validation_message` | Generated | Custom validation message. Legacy `validationMessage` is also accepted. |
| `show_valid_state` | `true` | Adds `is-valid` after non-empty flashed old input when no validation error exists. A configured value alone does not mark the group valid. |
| `required_indicator` | `*` | Required indicator; use `''` to suppress it. |
| `empty_message` | `No options available.` | Message shown when no options are supplied. |
| `label_partial` | `''` | Template that replaces the group legend. It should render a suitable `<legend>`. |
| `option_partial` | `''` | Template that renders each complete option. |
| `options_partial` | `''` | Template that renders the complete option collection. Takes precedence over `option_partial`. |
| `help_partial` | `''` | Template that replaces the help text. |
| `feedback_partial` | `''` | Template that replaces validation feedback. |
| `empty_partial` | `''` | Template that replaces the no-options message. |

All boolean options preserve explicitly supplied `false` values.

---

## Basic usage

```twig
{% include
    'components/form/radio.twig'
    with {
        name:
            'gender',

        label:
            'Gender',

        options: {
            male:
                'Male',

            female:
                'Female',

            other:
                'Other',
        },

        required:
            true,
    }
    only
%}
```

## Inline radio buttons

```twig
{% include
    'components/form/radio.twig'
    with {
        name:
            'contact_method',

        label:
            'Preferred contact method',

        options: {
            email:
                'Email',

            phone:
                'Phone',

            sms:
                'SMS',
        },

        inline:
            true,
    }
    only
%}
```

## Structured options

Use structured options when individual choices need a custom ID, disabled state, a preselected initial option, descriptive text, or trusted custom label markup.

```twig
{% include
    'components/form/radio.twig'
    with {
        name:
            'delivery',

        label:
            'Delivery method',

        options: [
            {
                value:
                    'standard',

                label:
                    'Standard delivery',

                description:
                    'Usually arrives within five working days.',
            },
            {
                value:
                    'express',

                label:
                    'Express delivery',

                description:
                    'Usually arrives the next working day.',

                disabled:
                    true,
            },
        ],

        value:
            'standard',
    }
    only
%}
```

A structured option can contain `value`, `label` (or `text`), `id`, `disabled`, `selected`, `description`, and `label_html`. Plain labels and descriptions are escaped. `label_html` is intentionally rendered as raw HTML and must contain only trusted or safely escaped markup.

## Initial value and old input

A flashed old value takes precedence over `value`. An intentionally submitted empty value clears the configured initial selection. When there is a validation error for the radio field and no old value is available, the component does not infer a selection from a structured option's `selected` flag.

## Partial customization

```twig
{% include
    'components/form/radio.twig'
    with {
        name:
            'department',

        label:
            'Department',

        options:
            departmentOptions,

        label_partial:
            'forms/partials/department-legend.twig',

        option_partial:
            'forms/partials/radio-option.twig',

        help_partial:
            'forms/partials/department-help.twig',

        feedback_partial:
            'forms/partials/field-feedback.twig',
    }
    only
%}
```

The option partial receives `id`, `group_id`, `name`, `value`, `label`, `label_html`, `checked`, `required`, `disabled`, `inline`, `class`, `option_class`, `description`, `has_error`, `autofocus`, `form`, `title`, `aria_describedby`, and `index`. The options partial receives the full `options` collection and the resolved selection. Help and feedback partials also receive explicit context, documented by their parameter names in the component template.

## Validation and accessibility

The component uses PixelFix's `errors()`, `has_error()`, `error()`, and `old()` helpers. A visible group label is rendered as a `<legend>` inside `<fieldset>`. Help and error IDs are attached with `aria-describedby`, and error state adds `aria-invalid="true"` to the group and radio inputs.

## Security

Plain option labels, descriptions, help text, and validation messages are escaped by Twig. `label_html` is intended only for trusted markup. Avoid passing unsanitized user input through it.

All Twig examples in this documentation use trailing commas after every hash entry, including the final entry.
