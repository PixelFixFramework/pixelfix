# User Menu Header Item

Renders the authenticated-user dropdown with avatar/initial, role/date information, profile links, and optional POST logout.

**Component:** `layout/header/user-menu.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `user_name` | `User` | Displayed user name. |
| `user_email` | `''` | User email value accepted by the component; it is currently not displayed in the markup. |
| `avatar_url` | `null` | Optional avatar image URL. When absent, the first letter of `user_name` is shown. |
| `user_created_at` | `null` | Optional membership date formatted as `M. Y`. |
| `user_role_text` | `''` | Optional role/status text shown after the user name. |
| `profile_url` | `#` | Profile link URL. |
| `logout_url` | `#` | Logout action URL. When truthy, a POST logout form is rendered. |

## Behavior and Notes

The component generates the initial with `user_name|slice(0, 1)|upper` when no avatar URL is supplied.

When `logout_url` is truthy, the template renders `{{ csrf|raw }}` inside the logout form, so a `csrf` value must be available in context.

The `Tasks` and `Settings` links in the user body are hard-coded to `#`.

The `user_email` parameter is defined and passed by the default header but is not displayed by the current markup.

## Usage

```twig
{% include 'components/layout/header/user-menu.twig' with {
    user_name: 'Jane Doe',
    user_email: 'jane@example.com',
    avatar_url: '/images/jane.png',
    user_created_at: '2026-01-15',
    user_role_text: 'Administrator',
    profile_url: route('profile'),
    logout_url: route('logout')
} %}
```
