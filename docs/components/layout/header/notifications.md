# Notifications Header Component

Renders PixelFix's Notifications dropdown in the application header, including the unread-count badge, notification text and time, optional icons, an empty state, and an optional footer link.

**Component:** `components/layout/header/notifications.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `notifications` | `[]` | Collection of notification objects displayed in the dropdown. |
| `notification_count` | `notifications\|length` | Number displayed in the unread badge and dropdown header. |
| `broadcast_channel` | `''` | Optional broadcast channel name. When supplied, the trigger exposes `data-pixelfix-broadcast-channel` for the generic live-notification client. |
| `notifications_label` | `Notifications` | Accessible label used when the unread count is updated by a live notification. |
| `show` | `true` | Whether the entire header item is rendered. An explicit `false` hides it. |
| `id` | `pixelfix-notifications-toggle` | ID of the dropdown trigger button. |
| `menu_id` | `pixelfix-notifications-dropdown` | ID of the dropdown menu. |
| `aria_label` | `Notifications: {count} unread` | Accessible label for the trigger. The default includes the unread count. |
| `title` | `''` | Optional title for the trigger button. |
| `icon` | `bell-fill` | Bootstrap Icon name or class. Set to `''` to omit the icon. |
| `control_class` | `''` | Additional class for the trigger. `link_class` is accepted as an alias. |
| `class` | `''` | Additional class appended to the trigger class. |
| `item_class` | `pixelfix-nav-item dropdown` | Class on the outer list item. |
| `menu_class` | `''` | Additional class on the dropdown menu. |
| `badge_class` | `''` | Additional class on the warning unread badge. |
| `header_text` | `Notifications` | Text displayed after the count in the dropdown header. |
| `empty_text` | `No notifications` | Text displayed when the collection is empty. |
| `show_footer` | `true` | Whether to render the footer when a destination is configured. |
| `notifications_url` | `''` | Direct URL for the footer. `notifications_footer_url` is an alias. |
| `notifications_route` | `''` | Named route for the footer; takes precedence over direct URLs. `notifications_footer_route` and `notifications_url_route` are aliases. |
| `notifications_route_parameters` | `[]` | Parameters passed to the footer named route. Footer route parameter aliases are also supported. |
| `notifications_footer_text` | `See All Notifications` | Text displayed by the footer link. |
| `notifications_footer_target` | `''` | Optional target for the footer link. |
| `notifications_footer_rel` | automatic for `_blank` | Optional relationship for the footer link. Defaults to `noopener noreferrer` when opening a new tab. |
| `footer_class` | `''` | Additional class for the footer link. |

## Generic live notifications

The component accepts an optional `broadcast_channel`. It does not prescribe an event class or application domain. When a broadcast arrives on that channel, the generic `public/assets/js/pixelfix-notifications.js` client accepts a payload with `title`, `text`, `subject`, or `message` for display text. It can additionally use `url`/`href`/`link`, `icon`, `time`/`created_at`, `event_id`, `target`, `rel`, and `unread`. The client ignores broadcast events that do not contain displayable notification text.

The browser client subscribes to the channel declared by the component. Generate the WebSocket client with `php pixelfix make:broadcast-client`; it is generated to `public/assets/js/pixelfix-broadcasting.js`. Include the broadcasting client first, then the generic notification client on pages using live notifications:

```twig
<script src="{{ asset('js/pixelfix-broadcasting.js') }}"></script>
<script src="{{ asset('js/pixelfix-notifications.js') }}"></script>
```

`asset('js/...')` paths map to files under `public/assets/js`. Do not place JavaScript assets in `public/js`. The live client does not assume that an application has a `/notifications` route or any particular event class; if a payload has no safe HTTP(S) destination, it is rendered as non-link content.

## Notification object

| Property | Default | Description |
|---|---|---|
| `id` | — | Optional identifier, rendered as `pixelfix-notification-{id}`. |
| `event_id` | — | Optional stable event identifier exposed in the DOM so a live broadcast can be deduplicated against the already-rendered item. |
| `icon` | `''` | Optional Bootstrap Icon name or CSS class displayed before the notification text. |
| `text` | `Notification` | Notification message. |
| `time` | `null` | Optional relative or formatted time. |
| `url` | `''` | Direct destination. `href` is an alias. No `#` fallback is generated. |
| `route` | `''` | Named route; takes precedence over `url` / `href`. `url_route` and `route_name` are aliases. |
| `route_parameters` | `[]` | Parameters passed to the named route. `url_route_parameters` and `parameters` are aliases. |
| `target` | `''` | Optional link target. |
| `rel` | automatic for `_blank` | Optional relationship; defaults to `noopener noreferrer` for `_blank`. |
| `aria_label` | `''` | Optional accessible label for a linked notification. |
| `title` | `''` | Optional title for a linked notification. |
| `item_class` | `''` | Additional class for the notification item. |

A notification with a URL or named route is rendered as a link. If it has no destination, it remains visible as a non-link item. This avoids generating dead `href="#"` or empty `href` attributes. Named routes are generated using PixelFix's `route()` helper. Route names and parameters must match routes registered by the application.

## Direct URL usage

```twig
{% set notifications = [
    {
        id: 1,
        icon: 'envelope',
        text: '4 new messages',
        time: '3 mins',
        url: '/messages',
    },
    {
        id: 2,
        icon: 'people-fill',
        text: '8 friend requests',
        time: '12 hours',
        url: '/friend-requests',
    },
] %}

{% include
    'components/layout/header/notifications.twig'
    with {
        notifications: notifications,
        notification_count: notifications|length,
        notifications_url: '/notifications',
        notifications_footer_text: 'See All Notifications',
    }
    only
%}
```

## Named routes for notification items

Each notification can use a named route and parameter map instead of a direct URL. If both are supplied, the named route takes precedence.

```twig
{% set notifications = [
    {
        id: 42,
        icon: 'envelope',
        text: 'A new message arrived',
        time: 'Just now',
        url: '/notifications/fallback',
        route: 'notifications.show',
        route_parameters: {
            notification: 42,
        },
    },
] %}
```

The route name is illustrative. The component calls `route('notifications.show', {'notification': 42})` and uses the generated URL instead of `/notifications/fallback`.

## Named route for the footer

```twig
{% include
    'components/layout/header/notifications.twig'
    with {
        notifications: notifications,
        notification_count: notifications|length,
        notifications_route: 'notifications.index',
        notifications_route_parameters: {
            status: 'unread',
        },
        notifications_footer_text: 'View Unread Notifications',
    }
    only
%}
```

The footer named route takes precedence over `notifications_url`. The footer is omitted when neither a direct URL nor a named route is configured, or when `show_footer: false` is supplied.

## Empty state and footer visibility

```twig
{% include
    'components/layout/header/notifications.twig'
    with {
        notifications: [],
        notification_count: 0,
        show_footer: false,
        empty_text: 'You are all caught up',
    }
    only
%}
```

## Customization

```twig
{% include
    'components/layout/header/notifications.twig'
    with {
        notifications: notifications,
        notifications_url: '/notifications',
        notifications_footer_text: 'Open notification centre',
        aria_label: 'Open notifications',
        title: 'Notifications',
        icon: 'bell',
        id: 'header-notifications-toggle',
        menu_id: 'header-notifications-menu',
        control_class: 'px-2',
        menu_class: 'shadow-sm',
        badge_class: 'rounded-pill',
        footer_class: 'fw-semibold',
        header_text: 'Recent notifications',
    }
    only
%}
```

## Default Header integration

The Default Header passes `notifications`, `notification_count`, the footer URL or named route and its parameters, `notifications_show_footer`, and `notifications_footer_text` to this component. The default footer URL is empty, so no footer link appears unless a destination is configured.

All Twig hash examples use trailing commas, including after the final entry.
