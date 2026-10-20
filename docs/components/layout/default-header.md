# Default Header

Renders the complete default application header.

The Default Header combines the reusable header components into a single
application header, including search, messages, notifications, language,
fullscreen, theme, and user menu functionality.

**Component:** `components/layout/default-header.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `user` | `null` | User object used to populate the user menu. |
| `avatar_url` | `null` | URL of the user's avatar image. |
| `user_created_at` | Derived | User creation date; falls back to `user.created_at`. |
| `user_role_text` | `User` | Role text displayed in the user menu. |
| `user_menu_show` | `true` | Whether to render the User Menu component. Explicit `false` is respected. |
| `profile_url` | `''` | Direct Profile destination; `profile_href` is an alias. |
| `profile_route` | `''` | Named Profile route; takes precedence over `profile_url`. Also accepts `profile_url_route` and `profile_route_name`. |
| `profile_route_parameters` | `[]` | Parameters passed to `profile_route`. Also accepts `profile_url_route_parameters` and `profile_parameters`. |
| `settings_url` | `''` | Direct Settings destination; `settings_href` is an alias. |
| `settings_route` | `''` | Named Settings route; takes precedence over `settings_url`. Also accepts `settings_url_route` and `settings_route_name`. |
| `settings_route_parameters` | `[]` | Parameters passed to `settings_route`. Also accepts `settings_url_route_parameters` and `settings_parameters`. |
| `menu_links` | `[]` | Application-defined user-menu links. Each item accepts `label` and `url`, or `label`, `route`, and optional `route_parameters`; `target` and `rel` are optional. |
| `logout_url` | `''` | Direct Logout form action; `logout_action` is an alias. Logout is submitted using POST. |
| `logout_route` | `''` | Named Logout route; takes precedence over `logout_url`. Also accepts `logout_url_route`, `logout_route_name` and `logout_action_route`. |
| `logout_route_parameters` | `[]` | Parameters passed to `logout_route`. Also accepts `logout_url_route_parameters`, `logout_parameters` and `logout_action_route_parameters`. |
| `csrf` | `''` | Framework-generated CSRF field markup passed to the User Menu logout form. |
| `messages` | `[]` | Array of message objects; each may use a direct URL or named route. |
| `message_count` | `messages\|length` | Number of unread messages displayed in the badge. |
| `messages_url` | `''` | Direct URL used by the Messages footer. `messages_footer_url` is an alias. |
| `messages_route` | `''` | Named route for the Messages footer; takes precedence over the direct URL. Supports `messages_footer_route`, `messages_url_route` and `messages_route_name`. |
| `messages_route_parameters` | `[]` | Parameters for the Messages footer route. Supports `messages_footer_route_parameters`, `messages_url_route_parameters` and `messages_parameters`. |
| `messages_show_footer` | `true` | Whether to show the Messages footer when a destination is configured. |
| `messages_footer_text` | `See All Messages` | Text displayed by the Messages footer. |
| `notifications` | `[]` | Array of notification objects; each may use a direct URL or named route. |
| `notification_count` | `notifications\|length` | Number of unread notifications displayed in the badge. |
| `notifications_broadcast_channel` | `''` | Optional broadcast channel for generic live notifications. `broadcast_channel` is accepted as an alias. |
| `notifications_label` | `Notifications` | Accessible label used when the live unread count changes. |
| `notifications_url` | `''` | Direct URL for the Notifications footer. `notifications_footer_url` is an alias. |
| `notifications_route` | `''` | Named route for the Notifications footer; takes precedence over the direct URL. Supports `notifications_footer_route`, `notifications_url_route` and `notifications_route_name`. |
| `notifications_route_parameters` | `[]` | Parameters for the Notifications footer route. Supports `notifications_footer_route_parameters`, `notifications_url_route_parameters` and `notifications_parameters`. |
| `notifications_show_footer` | `true` | Whether to show the Notifications footer when a destination is configured. |
| `notifications_footer_text` | `See All Notifications` | Text displayed by the Notifications footer. |
| `search_url` | `''` | Direct URL used by desktop and small-screen Search. The Search controls are omitted without a destination. |
| `search_route` | `''` | Named route for Search; takes precedence over `search_url`. |
| `search_route_parameters` | `[]` | Parameters passed to `search_route`. |
| `search_query_name` | `query` | Name of the desktop Search input submitted using GET. |
| `search_placeholder` | `Search...` | Placeholder shown in the desktop Search input. |

The component also accepts `menu_links` for application-defined navigation and forwards `profile_target`, `profile_rel`, `settings_target`, `settings_rel`, `profile_label`, `settings_label`, `logout_text`, and the `user_menu_*` presentation options documented with the User Menu component.

---

# Usage

The Default Header component is included using Twig's `include` statement.

The component accepts user, messages, and notifications data and passes
the relevant values to the corresponding header components.

For example:

```twig
{% include
    'components/layout/default-header.twig'
    with {
        user:
            user,

        avatar_url:
            user.avatar_url,

        user_created_at:
            user.created_at,

        user_role_text:
            'Administrator',

        profile_url:
            '/profile',

        menu_links: [
            {
                label: 'Records',
                url: '/records',
            },
        ],

        settings_url:
            '/settings',

        logout_url:
            '/logout',

        messages:
            messages,

        message_count:
            messages|length,

        messages_url:
            '/messages',

        messages_footer_text:
            'See All the new Messages',

        notifications:
            notifications,

        notification_count:
            notifications|length,

        notifications_broadcast_channel:
            notificationChannel,

        notifications_url:
            '/notifications',

        notifications_footer_text:
            'See All Notifications',

        search_route:
            'search.index',

        search_route_parameters: {
            scope:
                'all',
        },

        search_query_name:
            'query',
    }
    only
%}
```

---

## User

The `user` parameter supplies the user object used by the user menu.

The component reads:

```twig
user.name
```

for the user name,

```twig
user.email
```

for the user email, and

```twig
user.created_at
```

for the user creation date when `user_created_at` is not explicitly supplied.

Example:

```twig
{% set user = {
    name: 'John Doe',
    email: 'john@example.com',
    created_at: '2026-01-15',
} %}
```

The user object is optional. When no user is supplied, the user menu
uses the default user values.

---

## Avatar

The `avatar_url` parameter controls the avatar image displayed by the
user menu.

```twig
{% include
    'components/layout/default-header.twig'
    with {
        user:
            user,

        avatar_url:
            '/images/users/john-doe.jpg',
    }
    only
%}
```

When `avatar_url` is not supplied, the user menu does not receive an
avatar URL.

---

## User Created Date

The `user_created_at` parameter controls the date displayed by the user
menu.

When it is not supplied, the component attempts to use:

```twig
user.created_at
```

Example:

```twig
{% include
    'components/layout/default-header.twig'
    with {
        user:
            user,

        user_created_at:
            '2026-01-15',
    }
    only
%}
```

---

## User Role

The `user_role_text` parameter controls the role text displayed by the
user menu.

The default value is `User`.

Example:

```twig
{% include
    'components/layout/default-header.twig'
    with {
        user:
            user,

        user_role_text:
            'Administrator',
    }
    only
%}
```

---

## Profile, Settings, and Application-Defined Links

Profile and Settings accept direct URLs or named routes. For application-specific destinations, pass `menu_links` items containing a `label` and either a `url` or a named `route` with optional `route_parameters`. Named routes take precedence over URLs, and links without a destination are omitted rather than rendered with `href="#"`.

```twig
{% include
    'components/layout/default-header.twig'
    with {
        profile_route: 'profile.show',
        profile_route_parameters: {
            id: user.id,
        },
        menu_links: [
            {
                label: 'Records',
                route: 'records.index',
                route_parameters: {
                    owner: 'me',
                },
            },
        ],
        settings_url: '/settings',
    }
    only
%}
```

Direct destinations remain supported:

```twig
{% include
    'components/layout/default-header.twig'
    with {
        profile_url: '/profile',
        menu_links: [
            {
                label: 'Records',
                url: '/records',
            },
        ],
        settings_url: '/settings',
    }
    only
%}
```

The example route names must be registered by the application.

---

## Logout Destination and CSRF

The `logout_url` parameter, or its `logout_action` alias, sets the action for the User Menu logout form. Alternatively, use `logout_route` and `logout_route_parameters`. A named route takes precedence over the direct URL. The logout operation remains a POST form; the application must supply its framework-generated CSRF field markup through `csrf`.

```twig
{% include
    'components/layout/default-header.twig'
    with {
        logout_route: 'logout',
        csrf: csrf,
    }
    only
%}
```

When no logout destination is configured, the Sign out form is omitted. The Default Header does not create a placeholder URL or implement the logout endpoint.

---

## Messages

The Default Header passes the Messages configuration to:

```text
components/layout/header/messages.twig
```

The supported parameters are:

| Parameter | Default | Description |
|---|---|---|
| `messages` | `[]` | Message collection. |
| `message_count` | `messages\|length` | Unread message count. |
| `messages_url` | `''` | Direct URL for the Messages footer. |
| `messages_route` | `''` | Named route for the footer; takes precedence over `messages_url`. |
| `messages_route_parameters` | `[]` | Parameters passed to the named route. |
| `messages_show_footer` | `true` | Whether to render the footer when a destination is configured. |
| `messages_footer_text` | `See All Messages` | Messages footer text. |

Example:

```twig
{% include
    'components/layout/default-header.twig'
    with {
        messages:
            messages,

        message_count:
            messages|length,

        messages_url:
            '/messages',

        messages_footer_text:
            'View All Messages',
    }
    only
%}
```

The footer can also use a named route:

```twig
{% include
    'components/layout/default-header.twig'
    with {
        messages: messages,
        messages_route: 'messages.index',
        messages_route_parameters: {
            folder: 'inbox',
        },
        messages_footer_text: 'View All Messages',
    }
    only
%}
```

If neither `messages_url` nor `messages_route` is configured, the Messages dropdown remains available but its footer link is omitted. The named route takes precedence when both are supplied. All Twig hash examples should use trailing commas, including the final entry.

---

## Notifications

The Default Header passes notification items and footer navigation settings to:

```text
components/layout/header/notifications.twig
```

The supported parameters are:

| Parameter | Default | Description |
|---|---|---|
| `notifications` | `[]` | Notification collection. Each item may use `url` / `href` or a named `route` with `route_parameters`. |
| `notification_count` | `notifications|length` | Unread notification count. |
| `notifications_url` | `''` | Direct URL for the footer. `notifications_footer_url` is an alias. |
| `notifications_route` | `''` | Named route for the footer; takes precedence over the direct URL. |
| `notifications_route_parameters` | `[]` | Parameters passed to the footer named route. |
| `notifications_show_footer` | `true` | Whether to render the footer when a destination is configured. |
| `notifications_footer_text` | `See All Notifications` | Notifications footer text. |

Direct URL example:

```twig
{% include
    'components/layout/default-header.twig'
    with {
        notifications: notifications,
        notification_count: notifications|length,
        notifications_url: '/notifications',
        notifications_footer_text: 'View All Notifications',
    }
    only
%}
```

Named-route example:

```twig
{% include
    'components/layout/default-header.twig'
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

Individual notifications also support `route` and `route_parameters`, with `url` / `href` as direct URL options. A named route takes precedence over a direct URL. Items without a destination remain visible as non-link content, and the footer is not rendered unless a destination exists. The Default Header forwards `notifications_show_footer` to the component's `show_footer` setting.

---

## Complete Dashboard Example

The following example demonstrates the Default Header using the same
type of data commonly supplied by an application dashboard.

```twig
{% set user = {
    name: 'John Doe',
    email: 'john@example.com',
    created_at: '2026-01-15',
} %}

{% set messages = [
    {
        id: 1,
        name: 'Brad Diesel',
        preview: 'Call me whenever you can...',
        time: '4 Hours Ago',
        avatar: 'https://i.pravatar.cc/96?img=12',
        initials: 'BD',
        star_type: 'text-danger',
        url: '/messages/1',
    },
    {
        id: 2,
        name: 'John Pierce',
        preview: 'I got your message bro',
        time: '4 Hours Ago',
        avatar: 'https://i.pravatar.cc/96?img=11',
        initials: 'JP',
        star_type: 'text-secondary',
        url: '/messages/2',
    },
    {
        id: 3,
        name: 'Nora Silvester',
        preview: 'The subject goes here',
        time: '4 Hours Ago',
        avatar: null,
        initials: 'NS',
        badge_type: 'warning',
        star_type: 'text-warning',
        url: '/messages/3',
    },
] %}

{% set notifications = [
    {
        id: 1,
        icon: 'bi bi-envelope',
        text: '4 new messages',
        time: '3 mins',
        url: '/messages',
    },
    {
        id: 2,
        icon: 'bi bi-people-fill',
        text: '8 friend requests',
        time: '12 hours',
        url: '/friend-requests',
    },
    {
        id: 3,
        icon: 'bi bi-file-earmark-fill',
        text: '3 new reports',
        time: '2 days',
        url: '/reports',
    },
] %}

{% include
    'components/layout/default-header.twig'
    with {
        user:
            user,

        avatar_url:
            'https://i.pravatar.cc/96?img=5',

        user_created_at:
            user.created_at,

        user_role_text:
            'Administrator',

        profile_url:
            '/profile',

        logout_url:
            '/logout',

        messages:
            messages,

        message_count:
            messages|length,

        messages_url:
            '/messages',

        messages_footer_text:
            'See All the new Messages',

        notifications:
            notifications,

        notification_count:
            notifications|length,

        notifications_broadcast_channel:
            notificationChannel,

        notifications_url:
            '/notifications',

        notifications_footer_text:
            'See All Notifications',

        search_route:
            'search.index',

        search_route_parameters: {
            scope:
                'all',
        },

        search_query_name:
            'query',
    }
    only
%}
```

---

## Header Composition

The Default Header embeds:

```text
components/layout/header.twig
```

The header start area includes:

```text
components/layout/header/live-preview.twig
components/layout/header/documentation.twig
```

The header end area includes:

```text
components/layout/header/search.twig
components/layout/header/messages.twig
components/layout/header/notifications.twig
components/layout/header/language.twig
components/layout/header/fullscreen.twig
components/layout/header/theme.twig
components/layout/header/user-menu.twig
```

The Default Header therefore provides a complete header composition while
allowing application data to be supplied through its parameters.

---

## Search

The Search header item uses `search_url` for a direct destination or `search_route` with `search_route_parameters` for a named route. When both are supplied, the named route takes precedence. The desktop control submits a GET request using `search_query_name`; the small-screen control links to the same generated destination. No Search controls are rendered until a destination is configured.
