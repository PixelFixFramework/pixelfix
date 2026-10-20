# Flash Messages

Renders PixelFix session flash messages as Bootstrap Alert components. By default, the component reads `flash_messages()`, maps `error` to Bootstrap's `danger` variant, and escapes message content as plain text.

**Component:** `components/feedback/flash-messages.twig`

Bootstrap CSS is required. Dismissible alerts also require Bootstrap's JavaScript bundle.

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `messages` | `flash_messages()` | Optional override using the same grouped structure returned by `flash_messages()`. The presence of this parameter takes precedence, including when it is an empty array. |
| `show` | `true` | Set to `false` to suppress the component. An explicit `false` is respected. |
| `wrapper_id` | `''` | Optional ID for the messages wrapper. |
| `wrapper_class` | `''` | Additional classes on the wrapper. The legacy `class` option is also supported. |
| `alert_class` | `''` | Additional classes applied to each Alert. |
| `alert_id_prefix` | `''` | Optional prefix for generated alert IDs. Each rendered message gets the prefix, message type, and index. |
| `alert_role` | `'alert'` | ARIA role passed to each Alert. |
| `dismissible` | `false` | Makes each flash alert dismissible. Requires Bootstrap JavaScript. |
| `close_label` | `'Close notification'` | Accessible label for each dismiss button. |
| `escape_content` | `true` | Escapes message text by default. Set to `false` only when every message is trusted application-authored HTML. |
| `type_map` | `{'error': 'danger'}` | Optional type-to-Bootstrap-variant map merged with the default mapping. |
| `alert_partial` | `'components/feedback/alert.twig'` | Template used to render each alert. It receives `type`, `content`, the Alert options, plus `message`, `message_type`, `alert_type` and `message_index`. |
| `title_partial` | `''` | Optional title partial passed to the Alert component. |
| `content_partial` | `''` | Optional per-message content partial passed to the Alert component. It receives `message`, `message_type`, `alert_type` and `message_index`. |
| `actions_partial` | `''` | Optional actions partial passed to the Alert component. |
| `show_empty` | `false` | Shows an empty state when no flash messages are available. Hidden by default. |
| `empty_message` | `'No notifications.'` | Text displayed when `show_empty` is enabled and no messages exist. |
| `empty_partial` | `''` | Optional partial that replaces the default empty-state text. Receives `empty_message`. |

The flash message structure is grouped by type, with either one message or a list of messages under each type. The component also accepts a scalar message for a type when `messages` is supplied directly.

---

## Minimal Usage

Include the component wherever session flash messages should appear. No parameters are required.

```twig
{% include
    'components/feedback/flash-messages.twig'
%}
```

When no flash messages are available, the component renders nothing by default.

---

## Adding a Flash Message

Set flash messages in application code using the framework helper, then include the component in the destination view.

```php
flash('success', 'Student record created successfully.');
flash('error', 'The student record could not be saved.');
```

```twig
{% include
    'components/feedback/flash-messages.twig'
    with {
        wrapper_class:
            'mb-3',

        dismissible:
            true,
    }
    only
%}
```

The component maps `error` to Bootstrap `danger`. The framework helper groups flash messages by type and normalizes individual values to lists.

---

## Supplying Messages Directly

Use `messages` to render an explicit set of grouped messages instead of reading from the session. An explicitly supplied empty array is respected and does not fall back to session messages.

```twig
{% include
    'components/feedback/flash-messages.twig'
    with {
        messages: {
            success: [
                'Student created successfully.',
                'Welcome to PixelFix.',
            ],
            warning: [
                'Your profile is incomplete.',
            ],
        },
        wrapper_class:
            'mb-3',
    }
    only
%}
```

A single string per type is also supported:

```twig
{% include
    'components/feedback/flash-messages.twig'
    with {
        messages: {
            success: 'Saved successfully.',
            error: 'Please correct the highlighted fields.',
        },
    }
    only
%}
```

---

## Customizing the Alert

Pass options through to each Alert without rebuilding the message loop.

```twig
{% include
    'components/feedback/flash-messages.twig'
    with {
        wrapper_id:
            'page-notifications',

        wrapper_class:
            'mb-4',

        alert_class:
            'shadow-sm',

        alert_id_prefix:
            'flash-message',

        dismissible:
            true,

        close_label:
            'Dismiss notification',
    }
    only
%}
```

---

## Escaped Content

Flash message text is escaped by default, so a message containing HTML-like text is displayed as text instead of being interpreted as markup. This is the recommended setting for validation messages and messages that may contain user input.

```twig
{% include
    'components/feedback/flash-messages.twig'
    with {
        messages: {
            info: '<script>this is shown as text</script>',
        },
        escape_content:
            true,
    }
    only
%}
```

Set `escape_content: false` only if you intentionally flash trusted, application-authored HTML.

---

## Content and Alert Partials

Use `content_partial` to customize the body of each alert while retaining the standard Bootstrap Alert wrapper. The partial can access the current `message`, original `message_type`, mapped `alert_type` and `message_index`.

```twig
{% include
    'components/feedback/flash-messages.twig'
    with {
        content_partial:
            'notifications/partials/message.twig',
    }
    only
%}
```

Use `alert_partial` when you need to replace the entire rendered alert instead:

```twig
{% include
    'components/feedback/flash-messages.twig'
    with {
        alert_partial:
            'notifications/partials/alert.twig',
    }
    only
%}
```

The default alert partial is `components/feedback/alert.twig`.

---

## Empty State

An empty state is optional and is hidden by default.

```twig
{% include
    'components/feedback/flash-messages.twig'
    with {
        messages: [],
        show_empty:
            true,
        empty_message:
            'You have no new notifications.',
    }
    only
%}
```

A custom `empty_partial` can replace the default empty-state text.

---

## Complete Example

```twig
{% include
    'components/feedback/flash-messages.twig'
    with {
        wrapper_id:
            'page-notifications',

        wrapper_class:
            'mb-3',

        alert_class:
            'shadow-sm',

        dismissible:
            true,

        escape_content:
            true,

        show_empty:
            false,

        empty_message:
            'No notifications.',

        empty_partial:
            '',

        alert_partial:
            'components/feedback/alert.twig',

        content_partial:
            '',

        title_partial:
            '',

        actions_partial:
            '',
    }
    only
%}
```

Every entry in every Twig hash example, including the last entry, has a trailing comma so developers can add further options without editing the preceding line.
