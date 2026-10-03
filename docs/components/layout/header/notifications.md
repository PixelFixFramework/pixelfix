# Notifications Header Item

Renders the notifications dropdown in the application header.

The component accepts a collection of notification objects and renders
the notifications in the application header.

**Component:** `components/layout/header/notifications.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `notifications` | `[]` | Array of notification objects displayed in the dropdown. |
| `notification_count` | `notifications\|length` | Number of unread notifications displayed in the badge. |
| `notifications_url` | `#` | URL used by the Notifications footer. |
| `notifications_footer_text` | `See All Notifications` | Text displayed by the Notifications footer. |

---

## Notification Object

Each item in `notifications` represents one notification.

| Property | Default | Description |
|---|---|---|
| `id` | — | Unique notification identifier. |
| `icon` | `null` | Bootstrap Icons class displayed before the notification text. |
| `text` | `Notification` | Notification text. |
| `time` | `null` | Relative or formatted notification time. |
| `url` | `#` | URL opened when the notification is selected. |

---

# Usage

The Notifications component is included using Twig's `include` statement.

Before including the component, create a `notifications` collection.

For example:

```twig
{% set notifications = [
    {
        id: 1,
        icon: 'bi bi-envelope',
        text: '4 new messages',
        time: '3 mins',
        url: '#'
    },
    {
        id: 2,
        icon: 'bi bi-people-fill',
        text: '8 friend requests',
        time: '12 hours',
        url: '#'
    },
    {
        id: 3,
        icon: 'bi bi-file-earmark-fill',
        text: '3 new reports',
        time: '2 days',
        url: '#'
    }
] %}

{% include
    'components/layout/header/notifications.twig'
    with {
        notifications:
            notifications,

        notification_count:
            notifications|length,

        notifications_url:
            '#',

        notifications_footer_text:
            'See All Notifications'
    }
    only
%}
```

---

## Notification Count

When `notification_count` is not supplied, the component uses:

```twig
notifications|length
```

The value is displayed as the unread notification count in the header badge.

An explicit count can also be supplied:

```twig
{% include
    'components/layout/header/notifications.twig'
    with {
        notifications:
            notifications,

        notification_count:
            5,

        notifications_url:
            '#',

        notifications_footer_text:
            'See All Notifications'
    }
    only
%}
```

---

## Notification Icon

The `icon` property controls the Bootstrap Icon displayed before the notification text.

```twig
{
    id: 1,
    icon: 'bi bi-envelope',
    text: '4 new messages',
    time: '3 mins',
    url: '#'
}
```

When `icon` is not supplied, no icon is rendered for that notification.

---

## Notification Text

The `text` property contains the notification message displayed to the user.

```twig
{
    id: 1,
    icon: 'bi bi-envelope',
    text: '4 new messages',
    time: '3 mins',
    url: '#'
}
```

When `text` is not supplied, the component uses `Notification`.

---

## Notification Time

The `time` property displays a relative or formatted time.

```twig
{
    id: 1,
    icon: 'bi bi-envelope',
    text: '4 new messages',
    time: '3 mins',
    url: '#'
}
```

When `time` is not supplied, no time value is displayed.

---

## Notification Link

The `url` property determines where the user is taken when a notification is selected.

```twig
{
    id: 1,
    icon: 'bi bi-envelope',
    text: '4 new messages',
    time: '3 mins',
    url: '/messages'
}
```

When `url` is not supplied, the component uses `#`.

---

## Empty State

When the `notifications` collection is empty, the component displays:

```text
No notifications
```

Example:

```twig
{% include
    'components/layout/header/notifications.twig'
    with {
        notifications:
            [],

        notification_count:
            0,

        notifications_url:
            '#',

        notifications_footer_text:
            'See All Notifications'
    }
    only
%}
```

---

## Footer

The Notifications footer uses the reusable Button component.

The footer URL is controlled by `notifications_url`.

The footer text is controlled by `notifications_footer_text`.

Example:

```twig
{% include
    'components/layout/header/notifications.twig'
    with {
        notifications:
            notifications,

        notification_count:
            notifications|length,

        notifications_url:
            '/notifications',

        notifications_footer_text:
            'View All Notifications'
    }
    only
%}
```

Default values:

| Parameter | Default |
|---|---|
| `notifications_url` | `#` |
| `notifications_footer_text` | `See All Notifications` |

---

## Complete Example

```twig
{% set notifications = [
    {
        id: 1,
        icon: 'bi bi-envelope',
        text: '4 new messages',
        time: '3 mins',
        url: '#'
    },
    {
        id: 2,
        icon: 'bi bi-people-fill',
        text: '8 friend requests',
        time: '12 hours',
        url: '#'
    },
    {
        id: 3,
        icon: 'bi bi-file-earmark-fill',
        text: '3 new reports',
        time: '2 days',
        url: '#'
    }
] %}

{% include
    'components/layout/header/notifications.twig'
    with {
        notifications:
            notifications,

        notification_count:
            notifications|length,

        notifications_url:
            '#',

        notifications_footer_text:
            'See All Notifications'
    }
    only
%}
```

---

## Integration With Default Header

The Default Header component passes the Notifications configuration to the Notifications component.

The supported parameters are:

| Parameter | Default | Description |
|---|---|---|
| `notifications` | `[]` | Notification collection. |
| `notification_count` | `notifications\|length` | Unread notification count. |
| `notifications_url` | `#` | Notifications footer URL. |
| `notifications_footer_text` | `See All Notifications` | Notifications footer text. |

Example:

```twig
{% include
    'components/layout/default-header.twig'
    with {
        notifications:
            notifications,

        notification_count:
            notifications|length,

        notifications_url:
            '/notifications',

        notifications_footer_text:
            'View All Notifications'
    }
    only
%}
```
