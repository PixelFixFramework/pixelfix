# Default Application Header

> **Component:** `components/layout/default-header.twig`

## Purpose

Composes the main PixelFix header with the standard start and end controls: live preview, documentation, search, messages, notifications, language, fullscreen, theme and user menu.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``user`` | Optional | `null` | User object used to derive name, email and created-at metadata. |
| ``avatar_url`` | Optional | `null` | Avatar URL passed to the user menu. |
| ``user_role_text`` | Optional | `User` | Role/status text shown by the user menu. |
| ``profile_url`` | Optional | `#` | Profile destination. |
| ``logout_url`` | Optional | `#` | Logout destination. |


## Behavior

The component embeds `components/layout/header.twig`. It supplies the start/end blocks and includes the eight specialised header controls. The user menu is passed normalized user information.

## Example

```twig
{% include 'components/layout/default-header.twig' with {
    user: auth_user(),
    avatar_url: '/assets/images/avatar.png',
    profile_url: route('profile'),
    logout_url: route('logout')
} %}
```

## Usage

Use when an application needs the standard PixelFix application header with the complete built-in control set.

## Notes

The component depends on the child header components and the surrounding PixelFix header CSS/JavaScript.

## Related Components

- `components/layout/header.twig`
- `components/layout/header/user-menu.twig`
