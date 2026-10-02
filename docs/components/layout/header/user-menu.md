# Header User Menu

> **Component:** `components/layout/header/user-menu.twig`

## Purpose

Displays the authenticated user's avatar/initial, name, email and account actions such as profile and logout.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``user_name`` | Optional | `User` | Display name. |
| ``user_email`` | Optional | `''` | Email address. |
| ``avatar_url`` | Optional | `null` | Avatar image URL. |
| ``user_created_at`` | Optional | `null` | Account creation date/time. |
| ``user_role_text`` | Optional | `''` | Role text shown in the menu. |
| ``profile_url`` | Optional | `#` | Profile destination. |
| ``logout_url`` | Optional | `#` | Logout destination. |


## Behavior

When `avatar_url` is absent, the component can fall back to an initial-based representation. The menu includes the account information and profile/logout actions defined by the current source.

## Example

```twig
{% include 'components/layout/header/user-menu.twig' with {
    user_name: 'Neene Ned',
    user_email: 'neene@example.com',
    user_role_text: 'Administrator',
    profile_url: route('profile'),
    logout_url: route('logout')
} %}
```

## Usage

Use with authenticated user data. The `default-header.twig` component already normalizes a user object and forwards the appropriate values.

## Related Components

- `components/layout/default-header.twig`
- `components/layout/header.twig`
