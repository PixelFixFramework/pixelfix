# Alert

Renders a Bootstrap alert with a complete default message, an optional heading and icon, dismissible behaviour, and replaceable title/content/action partials.

**Component:** `components/feedback/alert.twig`

Bootstrap CSS is required for styling. Dismissible alerts also require Bootstrap's JavaScript bundle.

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `type` | `'primary'` | Bootstrap alert variant: `primary`, `secondary`, `success`, `danger`, `warning`, `info`, `light`, or `dark`. Unknown variants fall back to `primary`. |
| `title` | `null` | Optional escaped alert heading. |
| `content` | `'This is an alert message.'` | Alert body. Preserves legacy raw-HTML behaviour by default; use `escape_content: true` for plain or untrusted text. |
| `class` | `''` | Additional CSS classes applied to the alert. |
| `id` | `''` | Optional HTML ID. |
| `role` | `'alert'` | ARIA role, such as `alert` or `status`. |
| `dismissible` | `false` | Adds Bootstrap dismissible classes and a close button. Requires Bootstrap JavaScript. |
| `close_label` | `'Close'` | Accessible label for the dismiss button. |
| `icon` | `''` | Optional Bootstrap Icon name or CSS class string. Accepts `check-circle`, `bi-check-circle`, `bi bi-check-circle`, or another full icon class string. |
| `escape_content` | `false` | Escapes `content` instead of rendering it as raw HTML. Prefer this for user-supplied text. |
| `title_partial` | `''` | Optional partial replacing the default title heading. |
| `title_partial_context` | `{}` | Extra values passed to the title partial. The component supplies title, type, id, and matching `alert*` aliases. |
| `content_partial` | `''` | Optional partial replacing `content`. Takes precedence over embedded `content`. |
| `content_partial_context` | `{}` | Extra values passed to the content partial. The component supplies content, title, type, id, and matching `alert*` aliases. |
| `actions_partial` | `''` | Optional partial rendered after the content inside an `.alert-actions` wrapper. Useful for links or action buttons. |
| `actions_partial_context` | `{}` | Extra values passed to the actions partial. The component supplies content, title, type, id, and dismissible state with matching `alert*` aliases. |

---

## Minimal Usage

The component renders a complete Bootstrap alert without any parameters:

```twig
{% include
    'components/feedback/alert.twig'
%}
```

The default alert uses the `primary` variant and displays `This is an alert message.`.

---

## Standard Usage

```twig
{% include
    'components/feedback/alert.twig'
    with {
        type:
            'success',

        title:
            'Success',

        content:
            'The operation completed successfully.',

        icon:
            'check-circle',

        class:
            'mb-3',
    }
    only
%}
```

The `title` is escaped by Twig. `content` accepts trusted, application-authored HTML for backward compatibility. Do not pass user-supplied HTML through it. Set `escape_content: true` when the content should be displayed strictly as text.

---

## Dismissible Alert

```twig
{% include
    'components/feedback/alert.twig'
    with {
        type:
            'warning',

        title:
            'Please review',

        content:
            'Some information needs your attention.',

        icon:
            'exclamation-triangle-fill',

        dismissible:
            true,

        close_label:
            'Dismiss alert',
    }
    only
%}
```

---

## Escaped Content

Use `escape_content: true` when rendering text that may contain HTML or user-supplied input.

```twig
{% include
    'components/feedback/alert.twig'
    with {
        type:
            'info',

        title:
            'Submitted comment',

        content:
            comment,

        escape_content:
            true,
    }
    only
%}
```

---

## Content Partial

Use `content_partial` when the alert body needs richer markup or Twig logic. The content partial takes precedence over `content` and receives `content`, `title`, `type`, `id`, plus the `alertType`, `alertTitle`, and `alertContent` aliases. It does not inherit arbitrary view variables; use `content_partial_context` for any additional values.

```twig
{% include
    'components/feedback/alert.twig'
    with {
        type:
            'success',

        title:
            'Import completed',

        content_partial:
            'imports/partials/success-details.twig',
    }
    only
%}
```

Example `resources/views/imports/partials/success-details.twig`:

```twig
<p class="mb-1">The import finished successfully.</p>
<p class="mb-0 small">Processed {{ imported_count }} records.</p>
```

---

## Title and Actions Partials

Use `title_partial` to replace the default heading block and `actions_partial` to append custom actions after the content. Their context is explicit; use `title_partial_context` and `actions_partial_context` for extra values. Their context is explicit; use `title_partial_context` and `actions_partial_context` for extra values.

```twig
{% include
    'components/feedback/alert.twig'
    with {
        type:
            'danger',

        title_partial:
            'alerts/partials/validation-title.twig',

        content_partial:
            'alerts/partials/validation-errors.twig',

        actions_partial:
            'alerts/partials/validation-actions.twig',

        dismissible:
            true,
    }
    only
%}
```

---

## Complete Example

```twig
{% include
    'components/feedback/alert.twig'
    with {
        id:
            'student-created-alert',

        type:
            'success',

        title:
            'Student created',

        content:
            '<p class="mb-0">The student record was created successfully.</p>',

        icon:
            'check-circle-fill',

        class:
            'mb-3',

        role:
            'status',

        dismissible:
            true,

        close_label:
            'Dismiss student-created notification',

        escape_content:
            false,

        title_partial:
            '',

        content_partial:
            '',

        actions_partial:
            '',
    }
    only
%}
```

Every option in the Twig hash examples, including the final option, has a trailing comma so developers can extend examples by adding another entry.
