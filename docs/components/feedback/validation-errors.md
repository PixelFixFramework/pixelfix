# Validation Errors

Renders field validation errors from PixelFix's `errors()` helper as a Bootstrap danger alert. The component groups messages by field, escapes field labels and error text, and renders nothing when no validation errors exist.

**Component:** `components/feedback/validation-errors.twig`

Bootstrap CSS is required for styling. Dismissible alerts also require the Bootstrap JavaScript bundle.

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `errors` | `errors()` | Optional explicit override using a field-to-messages map. An explicitly supplied empty array is respected. |
| `show` | `true` | Set to `false` to suppress the component. An explicit `false` is respected. |
| `type` | `'danger'` | Bootstrap Alert variant. Defaults to `danger` to indicate validation failure. |
| `title` | `'Please correct the following errors.'` | Heading displayed by the Alert component. |
| `icon` | `'exclamation-triangle-fill'` | Optional Bootstrap Icon name or class string. Set to `''` to hide the icon. |
| `class` | `''` | Additional CSS classes applied to the Alert. |
| `id` | `''` | Optional HTML ID applied to the Alert. |
| `dismissible` | `false` | Adds Bootstrap dismissible styling and a close button. Requires Bootstrap JavaScript. |
| `close_label` | `'Dismiss validation errors'` | Accessible label for the close button. |
| `field_labels` | `{}` | Optional map of field names to human-readable labels. Unmapped fields retain their original names. |
| `field_partial` | `''` | Optional partial replacing each default `<li>`. Receives `field`, `field_label`, `messages`, `validation_errors` and `field_index`. |
| `content_partial` | `''` | Optional partial replacing the complete error-list content. Receives `validation_errors` through the Alert include context. |
| `alert_partial` | `'components/feedback/alert.twig'` | Template used to render the outer alert. Receives the Alert parameters and `validation_errors`. |
| `show_empty` | `false` | Shows an empty-state message when there are no errors. Hidden by default. |
| `empty_message` | `'No validation errors.'` | Text displayed when `show_empty` is enabled. |
| `empty_partial` | `''` | Optional partial replacing the default empty-state message. Receives `empty_message` and `validation_errors`. |

`errors()` returns an array grouped by field name. Each field can contain one message or multiple messages. The component normalizes scalar messages to a one-item list.

---

## Minimal Usage

Include the component where a form should display its validation errors. No parameters are required.

```twig
{% include
    'components/feedback/validation-errors.twig'
%}
```

The component reads the current errors from `errors()` and renders nothing when the error collection is empty.

---

## Customizing the Alert

```twig
{% include
    'components/feedback/validation-errors.twig'
    with {
        title:
            'There are problems with your submission.',

        type:
            'danger',

        class:
            'mb-4 shadow-sm',

        dismissible:
            true,

        close_label:
            'Dismiss form errors',
    }
    only
%}
```

---

## Human-Readable Field Labels

Use `field_labels` to display friendly labels instead of field names such as `email_address` or `password_confirmation`.

```twig
{% include
    'components/feedback/validation-errors.twig'
    with {
        field_labels: {
            name:
                'Full name',

            email:
                'Email address',

            password_confirmation:
                'Confirm password',
        },
    }
    only
%}
```

---

## Supplying Errors Directly

Pass `errors` to render an explicit collection rather than the session's current validation errors. An explicit empty array prevents fallback to `errors()`.

```twig
{% include
    'components/feedback/validation-errors.twig'
    with {
        errors: {
            name: [
                'The name field is required.',
                'The name must not exceed 100 characters.',
            ],

            email: [
                'Enter a valid email address.',
            ],
        },
    }
    only
%}
```

---

## Custom Field Partial

Use `field_partial` to control how each field and its messages are displayed.

```twig
{% include
    'components/feedback/validation-errors.twig'
    with {
        field_partial:
            'forms/partials/validation-error-item.twig',
    }
    only
%}
```

Example `resources/views/forms/partials/validation-error-item.twig`:

```twig
<li>
    <strong>{{ field_label }}:</strong>
    {% for message in messages %}
        <span>{{ message }}</span>{% if not loop.last %}; {% endif %}
    {% endfor %}
</li>
```

---

## Content and Alert Partials

`content_partial` replaces the whole default error list. `alert_partial` replaces the outer Bootstrap Alert template while keeping the prepared alert options and validation error collection available to the partial.

```twig
{% include
    'components/feedback/validation-errors.twig'
    with {
        content_partial:
            'forms/partials/validation-error-list.twig',

        alert_partial:
            'forms/partials/validation-alert.twig',
    }
    only
%}
```

---

## Empty State

By default, no markup is rendered when there are no validation errors. Enable the empty state only when a page needs to communicate that validation has passed or no errors are present.

```twig
{% include
    'components/feedback/validation-errors.twig'
    with {
        show_empty:
            true,

        empty_message:
            'No validation errors were found.',

        empty_partial:
            'forms/partials/no-validation-errors.twig',
    }
    only
%}
```

---

## Escaping and Safety

Field names, mapped field labels and validation messages are rendered as escaped text. Avoid marking error strings as raw HTML: validation errors can include values originating from user input. If you need richer markup, use a trusted application-authored partial and continue rendering the message variables with normal Twig escaping.
