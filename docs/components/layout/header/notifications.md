# Notifications Header Item

Renders the notifications dropdown in the application header.

The component supports a configurable notification collection, unread notification count, notification links, configurable footer text, notification icons, notification text, and timestamps.

**Component:** `components/layout/header/notifications.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `notifications` | `[]` | Array of notification objects displayed in the dropdown. |
| `notification_count` | `notifications|length` | Number of unread notifications displayed in the header badge, notification header, and accessible label. |
| `notifications_url` | `#` | URL used by the "See All Notifications" footer button. |
| `notifications_footer_text` | `See All Notifications` | Text displayed by the notifications footer button. |

## Notification Object Parameters

Each item in the `notifications` array may contain the following properties:

| Property | Default | Description |
|---|---|---|
| `id` | — | Unique identifier for the notification. |
| `icon` | `null` | Bootstrap Icons class displayed before the notification text. |
| `text` | `Notification` | Notification message displayed to the user. |
| `time` | `null` | Relative or formatted notification time. |
| `url` | `#` | URL opened when the notification is selected. |

## Notification Icon

When `icon` is provided, the component renders the specified icon:

```twig
{% if notification.icon|default(null) %}

    <i
        class="
            {{ notification.icon }}
            me-2
        "
        aria-hidden="true"
    ></i>

{% endif %}