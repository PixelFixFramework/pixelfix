# Checkbox

Renders a Bootstrap checkbox with accessible labels, validation feedback, old-input restoration, and optional label/help/feedback partials.

**Component:** `components/form/checkbox.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | `checkbox` | Submitted field name. Set a unique name for each independent checkbox. |
| `id` | Same as `name` | HTML ID used by the label and accessibility attributes. |
| `label` | `Checkbox` | Escaped, plain-text label. |
| `label_html` | `null` | Trusted HTML label content; takes precedence over plain text unless a label partial is supplied. Use only application-authored or safely escaped markup. |
| `value` | `1` | Value submitted when checked. An unchecked checkbox is omitted by standard HTML form submission. |
| `checked` | `false` | Initial checked state when no old value or flashed validation failure overrides it. |
| `required` | `false` | Adds the native `required` attribute. |
| `disabled` | `false` | Disables the checkbox. |
| `inline` | `false` | Adds Bootstrap's `form-check-inline` class. |
| `switch` | `false` | Adds Bootstrap's `form-switch` class. |
| `class` | `''` | Additional classes for the input. |
| `wrapper_class` | `mb-3` | Classes for the outer wrapper; pass an empty string to remove them. |
| `label_class` | `''` | Additional label classes. |
| `autofocus` | `false` | Adds `autofocus`. |
| `form` | `''` | Associates the checkbox with a form by ID. |
| `title` | `''` | Native title attribute. |
| `aria_label` | `''` | Explicit accessible name when needed. A visible label is preferred. |
| `aria_describedby` | `''` | Additional IDs to associate with the checkbox. Help and error IDs are appended automatically when present. |
| `help_text` | `''` | Optional escaped help text. |
| `validation_message` | Generated | Custom fallback validation message. |
| `label_partial` | `''` | Template that replaces the label's content. |
| `help_partial` | `''` | Template that replaces the help text. |
| `feedback_partial` | `''` | Template that replaces validation feedback. |

All boolean options preserve an explicitly supplied `false` value.

---

## Basic usage

```twig
{% include
    'components/form/checkbox.twig'
    with {
        name:
            'terms',

        label:
            'I agree to the terms.',

        value:
            '1',

        required:
            true,

        checked:
            false,
    }
    only
%}
```

## Inline checkbox or switch

```twig
{% include
    'components/form/checkbox.twig'
    with {
        name:
            'notifications',

        label:
            'Enable notifications',

        inline:
            true,

        switch:
            true,

        disabled:
            false,
    }
    only
%}
```

## Label HTML

Use `label_html` for trusted markup such as an application-generated terms link. Escape dynamic URLs and label text before composing the markup. Prefer a label partial for more involved custom rendering.

```twig
{% include
    'components/form/checkbox.twig'
    with {
        name:
            'terms',

        label:
            'Terms and Conditions',

        label_html:
            'I agree to the <a href="/terms">Terms and Conditions</a>.',

        required:
            true,
    }
    only
%}
```

## Partial customization

```twig
{% include
    'components/form/checkbox.twig'
    with {
        name:
            'privacy_consent',

        label:
            'Privacy consent',

        help_text:
            'You can change this preference later.',

        label_partial:
            'forms/partials/privacy-checkbox-label.twig',

        help_partial:
            'forms/partials/privacy-checkbox-help.twig',

        feedback_partial:
            'forms/partials/field-feedback.twig',
    }
    only
%}
```

Partials receive explicit context. The label partial receives `id`, `name`, `label`, `label_html`, `value`, `checked`, `required`, and `disabled`. The help partial receives `id`, `input_id`, `name`, `label`, `help_text`, `required`, and `checked`. The feedback partial receives `id`, `name`, `label`, `has_error`, `error_message`, `validation_message`, and `required`.

## Validation and old input

The component uses PixelFix's `errors()`, `has_error()`, `error()`, and `old()` helpers. A flashed old value takes precedence over the configured initial `checked` state. If a validation failure is present and the checkbox was omitted from submitted old input, it renders unchecked. Error state adds `is-invalid`, `aria-invalid="true"`, and an associated feedback ID.

Standard HTML form behavior applies: an unchecked checkbox submits no value. The receiving controller should treat a missing checkbox key as false.

## Security

Plain `label` and help/feedback text are escaped by Twig. `label_html` is intentionally rendered as raw HTML to support links such as the Register component's terms link; only pass trusted markup, and escape dynamic values before building it.

All Twig examples in this documentation use trailing commas after every hash entry, including the last entry.
