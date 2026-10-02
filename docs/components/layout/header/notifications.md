# Notifications Header Item

Renders the notifications dropdown with an unread count and fixed notification entries.

**Component:** `layout/header/notifications.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `notification_count` | `15` | Notification count shown in the badge, header, and accessible label. |

## Behavior and Notes

The notification entries themselves are static in the template; only the count is configurable.

## Usage

```twig
{% include 'components/layout/header/notifications.twig' with {
    notification_count: 4
} %}
```
