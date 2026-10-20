# User Menu Header Item

Renders the authenticated user's dropdown in the PixelFix application header. It uses a semantic button for the dropdown trigger, supports direct URLs and named routes for navigation, and omits links or forms until their destinations are configured.

**Component:** `components/layout/header/user-menu.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `show` | `true` | Whether to render the entire user menu. Explicit `false` is respected. |
| `user_name` | `'User'` | Name shown in the trigger and user header. |
| `user_email` | `''` | Optional email shown in the user header. |
| `avatar_url` | `null` | Optional avatar image URL. If omitted, the component displays an initial. |
| `avatar_alt` | `user_name` | Alternative text for the avatar image. |
| `user_initial` | First character of `user_name` | Custom initial shown when no avatar is configured. |
| `user_created_at` | `null` | Optional membership date, formatted as `M. Y`. |
| `user_role_text` | `''` | Optional role or status shown beside the user's name. |
| `id` | `'pixelfix-user-menu-toggle'` | ID of the trigger button. |
| `menu_id` | `'pixelfix-user-menu-dropdown'` | ID of the dropdown menu. |
| `aria_label` | `'User menu for ' ~ user_name` | Accessible name for the trigger button. |
| `title` | `''` | Optional title attribute on the trigger. |
| `item_class` | `'pixelfix-nav-item dropdown pixelfix-user-menu'` | Classes applied to the wrapper list item. |
| `control_class` | Bootstrap-compatible button classes | Classes applied to the trigger button. `link_class` is an alias. |
| `class` | `''` | Additional trigger-button classes. |
| `menu_class` | `'dropdown-menu dropdown-menu-lg dropdown-menu-end'` | Classes applied to the dropdown. |
| `user_header_class` | `'pixelfix-user-header text-bg-primary'` | Classes applied to the user information header. |
| `user_body_class` | `'pixelfix-user-body'` | Classes applied to the navigation row. |
| `user_footer_class` | `'pixelfix-user-footer'` | Classes applied to the footer. |
| `profile_url` | `''` | Direct profile URL. Accepts `profile_href` as an alias. |
| `profile_route` | `''` | Named profile route. Takes precedence over `profile_url`. |
| `profile_route_parameters` | `[]` | Parameters passed to the profile route. |
| `tasks_url` | `''` | Direct Tasks URL. Accepts `tasks_href` as an alias. |
| `tasks_route` | `''` | Named Tasks route. Takes precedence over `tasks_url`. |
| `tasks_route_parameters` | `[]` | Parameters passed to the Tasks route. |
| `settings_url` | `''` | Direct Settings URL. Accepts `settings_href` as an alias. |
| `settings_route` | `''` | Named Settings route. Takes precedence over `settings_url`. |
| `settings_route_parameters` | `[]` | Parameters passed to the Settings route. |
| `logout_url` | `''` | Direct URL used as the POST logout form action. Accepts `logout_action` as an alias. |
| `logout_route` | `''` | Named route used as the POST logout form action. Takes precedence over `logout_url`. |
| `logout_route_parameters` | `[]` | Parameters passed to the logout route. |
| `profile_label` | `'Profile'` | Label used for both Profile links. |
| `tasks_label` | `'Tasks'` | Label for the Tasks link. |
| `settings_label` | `'Settings'` | Label for the Settings link. |
| `logout_text` | `'Sign out'` | Label on the logout button. `sign_out_text` is an alias. |
| `profile_target`, `tasks_target`, `settings_target` | `''` | Optional link targets. A target of `_blank` receives `rel="noopener noreferrer"` unless a corresponding `*_rel` value is supplied. |
| `profile_rel`, `tasks_rel`, `settings_rel` | Automatic or `''` | Optional explicit `rel` attribute for each navigation link. |
| `profile_button_class` | `'btn btn-outline-secondary'` | Classes for the footer Profile link. |
| `logout_form_class` | `'pixelfix-user-logout-form'` | Classes for the logout form. |
| `logout_button_class` | `'btn btn-outline-danger'` | Classes for the Sign out button. |

For Profile, Tasks, Settings and Logout route configuration, the component also accepts `*_url_route`, `*_route_name`, `*_url_route_parameters` and `*_parameters` aliases. Logout additionally accepts `logout_action_route` and `logout_action_route_parameters`.

---

## Usage

### Direct URLs

```twig
{% include
    'components/layout/header/user-menu.twig'
    with {
        user_name: 'John Doe',
        user_email: 'john@example.com',
        avatar_url: '/images/users/john.jpg',
        user_created_at: '2026-01-15',
        user_role_text: 'Administrator',
        profile_url: '/profile',
        tasks_url: '/tasks',
        settings_url: '/settings',
        logout_url: '/logout',
    }
    only
%}
```

### Named routes

```twig
{% include
    'components/layout/header/user-menu.twig'
    with {
        user_name: 'John Doe',
        profile_route: 'profile.show',
        profile_route_parameters: {
            id: user.id,
        },
        tasks_route: 'tasks.index',
        settings_route: 'settings.index',
        logout_route: 'logout',
    }
    only
%}
```

Named routes must be registered by the application. PixelFix generates their URLs through `route()` and passes the corresponding parameter arrays. If both a route and a direct URL are provided for the same action, the named route takes precedence.

### Configure only the links that exist

```twig
{% include
    'components/layout/header/user-menu.twig'
    with {
        user_name: 'John Doe',
        profile_route: 'profile.show',
        profile_route_parameters: {
            id: user.id,
        },
        logout_route: 'logout',
        aria_label: 'Account menu for John Doe',
    }
    only
%}
```

Tasks and Settings are omitted unless their URLs or named routes are configured. The Profile buttons are omitted when no Profile destination exists. The footer itself is omitted when neither a Profile destination nor a Logout destination exists. This prevents dead `href="#"` links and empty forms.

## Logout and CSRF

Logout always submits a `POST` form. If the `csrf` variable is provided by the application, the component renders it as the trusted CSRF field markup, consistent with PixelFix's other form components. Ensure the application supplies the framework-generated CSRF field and registers a logout endpoint that accepts POST requests. The component does not change authentication state itself.

## Avatar fallback

When `avatar_url` is not supplied, the component displays the first character of `user_name`, or `user_initial` when explicitly configured. The avatar URL, alternative text, labels and other rendered attribute values are escaped.

All Twig hash entries use trailing commas, including the final entry.
