# Range

Renders a standard Bootstrap range input with a label, numeric value display, configurable bounds, validation feedback, and optional help or content partials. This is a normal form control, not a floating input.

**Component:** `components/form/range.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | `range` | Form field name. |
| `id` | `name` | Input ID; also identifies the associated label, help, feedback, and value output. |
| `label` | `Range` | Visible label. |
| `min` | `0` | Minimum selectable value. |
| `max` | `100` | Maximum selectable value. |
| `step` | `1` | Increment between selectable values. |
| `value` | `min` | Initial value when no flashed old input exists. |
| `class` / `input_class` | `''` | Additional input CSS classes. `input_class` takes precedence. |
| `wrapper_class` | `mb-3` | Wrapper CSS classes. |
| `required` | `false` | Adds the native `required` attribute. |
| `disabled` | `false` | Disables the slider. |
| `autofocus` | `false` | Adds autofocus. |
| `show_value` | `true` | Shows the selected value beside the label and updates it as the slider moves. |
| `show_min_max` | `false` | Shows the minimum and maximum below the slider. |
| `show_valid_state` | `true` | Marks a non-empty flashed value as valid if there is no error. |
| `help_text` | `''` | Optional descriptive text. |
| `validation_message` | Inferred | Custom feedback when the field has no validation error. The legacy `validationMessage` spelling is also supported. |
| `title`, `form`, `aria_label`, `aria_describedby` | `null` / `''` | Optional native/accessibility attributes. |
| `label_partial` | `''` | Replaces the default label. |
| `range_partial` | `''` | Replaces the `<input type="range">`; receives bounds, value, classes, state, and output metadata. When `show_value` is enabled, render `data-pixelfix-range="true"` and `data-output-id="{{ output_id }}"` on the control for live updates. |
| `value_partial` | `''` | Replaces the value output. When `show_value` is enabled, expose the supplied `id` on the output element so the built-in live update can find it. |
| `help_partial` | `''` | Replaces help text. |
| `feedback_partial` | `''` | Replaces validation feedback. |
| `wrapper_id` | `null` | Optional wrapper ID. |
| `required_indicator` | `*` | Required marker; set to `''` to hide it. |

The selected value is taken from flashed old input when present, even if that value is intentionally empty; otherwise the configured `value` is used. Password-style handling is not relevant to a range field. Range values and labels are escaped by Twig.

Validation integrates with PixelFix's `errors()`, `has_error()`, `error()`, and `old()` helpers. Help and validation messages are linked to the control with `aria-describedby`. When validation fails, the component adds `is-invalid` and `aria-invalid="true"`.

`show_value` uses a small delegated inline browser-side input listener to keep the displayed value in sync. If the application enforces a strict Content Security Policy that blocks inline scripts, set `show_value: false` or move the same listener into the application's approved JavaScript bundle. Bootstrap CSS supplies the slider styling; Bootstrap JavaScript is not required for the range control itself.

---

## Minimal usage

```twig
{% include
    'components/form/range.twig'
%}
```

## Typical usage

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
            50,

        show_min_max:
            true,
    }
    only
%}
```

## Help text and validation

```twig
{% include
    'components/form/range.twig'
    with {
        name:
            'satisfaction',

        label:
            'Satisfaction',

        min:
            1,

        max:
            10,

        value:
            7,

        required:
            true,

        help_text:
            'Choose a value from 1 to 10.',

        validation_message:
            'Please select a satisfaction score.',
    }
    only
%}
```

## Custom value partial

```twig
{% include
    'components/form/range.twig'
    with {
        name:
            'rating',

        label:
            'Rating',

        value_partial:
            'forms/partials/range-value.twig',
    }
    only
%}
```

The value partial receives `id`, `input_id`, `name`, `value`, `min`, `max`, and `step`. Give the output element the passed `id` so the live value update can target it.
