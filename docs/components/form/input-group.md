# Input Group

Renders a complete Bootstrap input group with a label, optional prefix/suffix or icon, old-input restoration, validation feedback, autocomplete and accessible help text.

**Component:** `components/form/input-group.twig`

---

## Minimal usage

The component renders a usable text field with a label even when no options are passed.

```twig
{% include
    'components/form/input-group.twig'
%}
```

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `type` | `text` | HTML input type. Password values are never repopulated. |
| `name` | `input` | Input name; also supplies the default ID. |
| `id` | Derived from `name` | Custom HTML ID. |
| `label` | `Input` | Visible label. Pass `''` when the label is supplied elsewhere. |
| `label_class` | `form-label` | Classes applied to the label. |
| `placeholder` | `''` | Input placeholder. |
| `required` | `false` | Adds `required` and a visible required indicator. |
| `value` | `''` | Initial value; flashed old input takes precedence. |
| `class` | `''` | Additional input classes. |
| `wrapper_class` | `mb-3` | Classes on the field wrapper. |
| `group_class` | `''` | Additional classes on the Bootstrap input group. |
| `icon` | `null` | Trusted icon markup, kept for compatibility. |
| `icon_partial` | `''` | Partial that renders the icon markup. |
| `icon_position` | `start` | Icon position: `start` or `end`. |
| `prefix`, `suffix` | `''` | Escaped text displayed before or after the input. |
| `prefix_partial`, `suffix_partial` | `''` | Partials replacing the prefix or suffix text. |
| `maxlength`, `minlength` | `null` | Character limits. |
| `min`, `max`, `step` | `null` | Native input constraints. |
| `pattern`, `inputmode`, `accept` | `null` | Native HTML input attributes. |
| `autofocus`, `disabled`, `readonly`, `multiple` | `false` | Native input state attributes. Explicit `false` is respected. |
| `autocomplete` | Derived | Explicit autocomplete value; an empty string disables inference. |
| `validation_message` | Derived from the label | Message shown when the field is invalid but no specific error is available. |
| `show_valid_state` | `true` | Adds `is-valid` only when flashed old input is non-empty and there is no error. |
| `help_text` | `''` | Escaped help text below the group. |
| `aria_label`, `aria_describedby`, `title`, `form` | `null` / `''` | Accessible label, additional description IDs, title and form association. |
| `label_partial`, `input_partial`, `icon_partial`, `prefix_partial`, `suffix_partial`, `help_partial`, `feedback_partial` | `''` | Optional partials for replacing individual regions. |
| `wrapper_id`, `help_id`, `feedback_id` | Derived or `null` | Optional IDs for the wrapper, help and feedback elements. |
| `required_indicator` | `*` | Text shown next to a required label. |
| `size` | `null` | Bootstrap control size: `sm` or `lg`. |

---

## Basic usage

```twig
{% include
    'components/form/input-group.twig'
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

## Icons, prefixes and suffixes

`icon_position` supports `start` and `end`. The `icon` option accepts trusted HTML, as in the older component API. Prefer `icon_partial` when keeping custom icon markup in a separate template.

```twig
{% include
    'components/form/input-group.twig'
    with {
        name:
            'amount',

        label:
            'Amount',

        prefix:
            'K',

        icon:
            '<i class="bi bi-cash-stack"></i>',

        icon_position:
            'start',

        suffix:
            'ZMW',
    }
    only
%}
```

## Validation and old input

The component uses PixelFix's `errors()`, `has_error()`, `error()` and `old()` helpers. Flashed old input takes precedence over `value`. Password inputs always render an empty value. By default, non-empty old input receives `is-valid` when the field has no error; set `show_valid_state: false` to disable that state.

```twig
{% include
    'components/form/input-group.twig'
    with {
        name:
            'username',

        label:
            'Username',

        help_text:
            'Use 4–24 letters, numbers or underscores.',

        minlength:
            4,

        maxlength:
            24,

        pattern:
            '[A-Za-z0-9_]+',

        required:
            true,
    }
    only
%}
```

## Partial customization

Each partial receives explicit context and only replaces its named region. The full component continues to manage the form control, validation state and layout.

```twig
{% include
    'components/form/input-group.twig'
    with {
        name:
            'company',

        label:
            'Company',

        label_partial:
            'forms/partials/company-label.twig',

        prefix_partial:
            'forms/partials/company-prefix.twig',

        help_partial:
            'forms/partials/company-help.twig',

        feedback_partial:
            'forms/partials/field-feedback.twig',
    }
    only
%}
```

- `label_partial`: `id`, `input_id`, `name`, `label`, `label_class`, `required`, `required_indicator`, `type`.
- `input_partial`: `id`, `name`, `type`, `value`, `placeholder`, `class`, `required`, `disabled`, `readonly`, `autofocus`, `maxlength`, `minlength`, `min`, `max`, `step`, `pattern`, `inputmode`, `autocomplete`, `aria_label`, `aria_describedby`, `title`, `form`, `multiple`, `accept`, `has_error`.
- `icon_partial`: `icon`, `position`, `name`, `id`.
- `prefix_partial` / `suffix_partial`: `name`, `id`, `value`, `type`.
- `help_partial`: `id`, `input_id`, `name`, `help_text`, `type`.
- `feedback_partial`: `id`, `input_id`, `name`, `error_message`, `validation_message`, `has_error`.

## Security notes

Text values, labels, help text and validation feedback are escaped by Twig. The legacy `icon` parameter renders raw HTML for compatibility; only pass trusted markup. Use `icon_partial` for reusable application-controlled markup instead of embedding untrusted content.
