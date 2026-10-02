# Default Header Component

Renders the standard PixelFix application header by embedding `components/layout/header.twig` and supplying the default navigation components.

**Component:** `components/layout/default-header.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `user` | `null` | Optional user object. `name`, `email`, and `created_at` are read when available. |
| `avatar_url` | `null` | Optional user avatar URL. |
| `user_created_at` | Derived | Optional member date; when omitted, `user.created_at` is used when available. |
| `user_role_text` | `User` | Role/status text passed to the user menu. |
| `profile_url` | `#` | Profile URL passed to the user menu. |
| `logout_url` | `#` | Logout URL passed to the user menu. |
| `messages` | `[]` | Array of message objects passed to the Messages header component. |
| `message_count` | `messages|length` | Number of unread messages displayed in the Messages badge. |
| `messages_url` | `#` | URL used by the Messages footer button. |
| `messages_footer_text` | `See All Messages` | Text displayed by the Messages footer button. |
| `notifications` | `[]` | Array of notification objects passed to the Notifications header component. |
| `notification_count` | `notifications|length` | Number of unread notifications displayed in the Notifications badge and header. |
| `notifications_url` | `#` | URL used by the Notifications footer button. |
| `notifications_footer_text` | `See All Notifications` | Text displayed by the Notifications footer button. |

## Message Data

The `messages` parameter accepts an array of message objects.

Each message may contain:

| Property | Default | Description |
|---|---|---|
| `id` | — | Unique message identifier. |
| `name` | `Unknown User` | Name of the message sender. |
| `preview` | `''` | Message preview text. |
| `time` | `''` | Relative or formatted message time. |
| `avatar` | `null` | Avatar image URL. |
| `initials` | Derived | Initials displayed when an avatar is unavailable. |
| `badge_type` | Random | Badge type used for the initials fallback. |
| `star_type` | `text-secondary` | Text color class applied to the message star. |
| `url` | `#` | URL opened when the message is selected. |

For the complete Messages API, see:

`components/layout/header/messages.twig`

## Notification Data

The `notifications` parameter accepts an array of notification objects.

Each notification may contain:

| Property | Default | Description |
|---|---|---|
| `id` | — | Unique notification identifier. |
| `icon` | `null` | Bootstrap Icons class displayed with the notification. |
| `text` | `Notification` | Notification text. |
| `time` | `null` | Relative or formatted notification time. |
| `url` | `#` | URL opened when the notification is selected. |

For the complete Notifications API, see:

`components/layout/header/notifications.twig`

## Behavior and Notes

The component embeds:

`components/layout/header.twig`

The start region includes:

- Live Preview
- Documentation

The end region includes:

- Search
- Messages
- Notifications
- Language
- Fullscreen
- Theme
- User Menu

### Messages

The `messages` array is passed directly to the Messages header component.

When `message_count` is not supplied, the component uses:

```twig
messages|length