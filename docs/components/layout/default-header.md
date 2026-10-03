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
| `user_created_at` | Derived | User creation date. When omitted, the value is read from `user.created_at`. |
| `user_role_text` | `User` | Role text displayed in the user menu. |
| `profile_url` | `#` | URL used by the user profile action. |
| `logout_url` | `#` | URL used by the logout action. |
| `messages` | `[]` | Array of message objects displayed in the Messages component. |
| `message_count` | `messages\|length` | Number of unread messages displayed in the Messages badge. |
| `messages_url` | `#` | URL used by the Messages footer. |
| `messages_footer_text` | `See All Messages` | Text displayed by the Messages footer. |
| `notifications` | `[]` | Array of notification objects displayed in the Notifications component. |
| `notification_count` | `notifications\|length` | Number of unread notifications displayed in the Notifications badge. |
| `notifications_url` | `#` | URL used by the Notifications footer. |
| `notifications_footer_text` | `See All Notifications` | Text displayed by the Notifications footer. |

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

        notifications_url:
            '/notifications',

        notifications_footer_text:
            'See All Notifications'
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
    created_at: '2026-01-15'
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
            '/images/users/john-doe.jpg'
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
            '2026-01-15'
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
            'Administrator'
    }
    only
%}
```

---

## Profile URL

The `profile_url` parameter controls the profile link used by the user
menu.

The default value is `#`.

Example:

```twig
{% include
    'components/layout/default-header.twig'
    with {
        user:
            user,

        profile_url:
            '/profile'
    }
    only
%}
```

---

## Logout URL

The `logout_url` parameter controls the logout link used by the user
menu.

The default value is `#`.

Example:

```twig
{% include
    'components/layout/default-header.twig'
    with {
        user:
            user,

        logout_url:
            '/logout'
    }
    only
%}
```

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
| `messages_url` | `#` | Messages footer URL. |
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
            'View All Messages'
    }
    only
%}
```

---

## Notifications

The Default Header passes the Notifications configuration to:

```text
components/layout/header/notifications.twig
```

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

---

## Complete Dashboard Example

The following example demonstrates the Default Header using the same
type of data commonly supplied by an application dashboard.

```twig
{% set user = {
    name: 'John Doe',
    email: 'john@example.com',
    created_at: '2026-01-15'
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
        url: '#'
    },
    {
        id: 2,
        name: 'John Pierce',
        preview: 'I got your message bro',
        time: '4 Hours Ago',
        avatar: 'https://i.pravatar.cc/96?img=11',
        initials: 'JP',
        star_type: 'text-secondary',
        url: '#'
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
        url: '#'
    }
] %}

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

        notifications_url:
            '/notifications',

        notifications_footer_text:
            'See All Notifications'
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
