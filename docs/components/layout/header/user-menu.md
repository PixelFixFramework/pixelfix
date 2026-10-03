# User Menu Header Item

Renders the authenticated user dropdown in the application header.

**Component:** `components/layout/header/user-menu.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `user_name` | `User` | User name displayed in the header and menu. |
| `user_email` | `''` | User email value supplied to the component API. |
| `avatar_url` | `null` | User avatar URL. |
| `user_created_at` | `null` | User creation date displayed as the membership date. |
| `user_role_text` | `''` | Role text displayed beside the user name. |
| `profile_url` | `#` | Profile URL. |
| `logout_url` | `#` | Logout form action. |

---

# Usage

```twig
{% include
    'components/layout/header/user-menu.twig'
    with {
        user_name:
            'John Doe'

        user_email:
            'john@example.com'

        avatar_url:
            '/images/users/john.jpg'

        user_created_at:
            '2026-01-15'

        user_role_text:
            'Administrator'

        profile_url:
            '/profile'

        logout_url:
            route('logout')
    }
    only
%}
```

---

## Avatar Fallback

When `avatar_url` is not supplied, the component displays the first character
of `user_name` as the user avatar.

---

## User Menu Links

The component currently renders Profile, Tasks, and Settings links in the
menu body. The Profile and Sign out controls use the supplied `profile_url`
and `logout_url` values.
