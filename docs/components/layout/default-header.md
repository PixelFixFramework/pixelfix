# Default Header Component

Renders the standard PixelFix application header by embedding `components/layout/header.twig` and supplying the default navigation components.

**Component:** `layout/default-header.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `user` | `null` | Optional user object. `name`, `email`, and `created_at` are read when available. |
| `avatar_url` | `null` | Optional user avatar URL. |
| `user_created_at` | Derived | Optional member date; when omitted, `user.created_at` is used when available. |
| `user_role_text` | `User` | Role/status text passed to the user menu. |
| `profile_url` | `#` | Profile URL passed to the user menu. |
| `logout_url` | `#` | Logout URL passed to the user menu. |

## Behavior and Notes

The component includes Live Preview and Documentation in the start region.

The end region includes Search, Messages, Notifications, Language, Fullscreen, Theme, and User Menu.

The user object is expected to expose `name`, `email`, and optionally `created_at` when those values are used.

The computed user email is passed to the user-menu component, although the current user-menu markup does not display that value.

## Usage

```twig
{% include 'components/layout/default-header.twig' with {
    user: app.user,
    avatar_url: '/images/avatar.png',
    user_role_text: 'Administrator',
    profile_url: route('profile'),
    logout_url: route('logout')
} %}
```
