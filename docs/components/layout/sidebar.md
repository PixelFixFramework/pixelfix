# Sidebar

Renders the PixelFix application sidebar with branding, searchable recursive navigation, optional user information, a CSRF-protected logout form, persistence, and responsive behavior.

**Component:** `components/layout/sidebar.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `brand` | `PixelFix` | Sidebar brand text. |
| `logo` | `P` | Sidebar logo text. |
| `brand_url` | `/` | Direct brand URL. |
| `brand_route` | `null` | Named route for the brand link; takes precedence over `brand_url`. |
| `brand_route_parameters` | `{}` | Parameters passed to `route()` for the brand destination. |
| `items` | `[]` | Recursive sidebar navigation items. |
| `user` | `null` | User object displayed in the sidebar footer. |
| `logout_url` | `null` | Direct POST logout action. |
| `logout_route` | `null` | Named route for the logout POST action; takes precedence over `logout_url`. |
| `logout_route_parameters` | `{}` | Parameters passed to `route()` for logout. |
| `logout_text` | `Logout` | Logout button label. |
| `csrf` | `''` | Framework-generated CSRF field markup rendered inside the logout form. |
| `class` | `''` | Additional sidebar CSS classes. |
| `id` | `pixelfix-sidebar` | Sidebar ID. |
| `aria_label` | `Sidebar navigation` | Accessible label for the sidebar landmark. |
| `aria_describedby` | `null` | ID of descriptive text associated with the sidebar. |
| `navigation_label` | `Main navigation` | Accessible label for the navigation landmark. |
| `search` | `true` | Enables the sidebar menu filter. |
| `search_label` | `Filter menu` | Accessible label for the search input. |
| `search_id` | `{id}-search` | Search input ID. |
| `search_placeholder` | `Filter menu…` | Search placeholder. |
| `search_empty_text` | `No matching pages.` | Empty search result message. |
| `breakpoint` | `991.98` | Responsive breakpoint used by sidebar behavior. |
| `persistence` | `false` | Enables sidebar state persistence. |
| `mini` | `false` | Enables mini sidebar mode. |
| `collapsed` | `false` | Starts the sidebar collapsed. |
| `without_hover` | `false` | Disables hover expansion behavior. |
| `accordion` | `true` | Enables accordion behavior for nested navigation. |
| `animation_speed` | `300` | Sidebar animation speed. |
| `brand_class` | `''` | Additional brand wrapper classes. |
| `brand_link_class` | `''` | Additional brand link/static brand classes. |
| `navigation_class` | `''` | Additional navigation landmark classes. |
| `menu_class` | `''` | Additional menu list classes. |
| `search_class` | `''` | Additional search wrapper classes. |
| `search_input_class` | `''` | Additional search input classes. |
| `wrapper_class` | `''` | Additional navigation wrapper classes. |
| `footer_class` | `''` | Additional footer classes. |
| `user_class` | `''` | Additional user summary classes. |
| `logout_form_class` | `''` | Additional logout form classes. |
| `logout_button_class` | `''` | Additional logout button classes. |
| `logout_class` | `''` | Additional logout button classes. |
| `logout_icon` | `↪` | Logout icon/text rendered before its label. |

Route compatibility aliases are accepted: `brand_url_route`, `brand_route_name`, `brand_url_route_parameters`, `brand_parameters`, `logout_url_route`, `logout_route_name`, `logout_url_route_parameters`, and `logout_parameters`.

---

## Navigation Items

Each item may contain these properties:

| Property | Default | Description |
|---|---|---|
| `label` | `''` | Visible item label. |
| `url` | not set | Direct destination URL. `href` is accepted as an alias. |
| `route` | not set | Named route; takes precedence over `url`/`href`. |
| `route_parameters` | `{}` | Route parameters. |
| `icon` | `•` | Text or icon mark rendered before the label. |
| `active` | `false` | Marks the item as the current page and sets `aria-current="page"`. |
| `disabled` | `false` | Renders the item as a non-clickable disabled entry. |
| `open` | `false` | Starts its child navigation tree open. |
| `header` | `false` | Renders the item as a section heading. |
| `badge` | `null` | Optional badge text, including `0`. |
| `badge_class` | `''` | Additional badge CSS classes. |
| `children` | `[]` | Nested items; the same schema is used recursively. |
| `item_class` | `''` | Additional list item classes. |
| `link_class` | `''` | Additional link/static label classes. |
| `toggle_class` | `''` | Additional child-toggle button classes. |
| `toggle_label` | `Toggle {label}` | Accessible label for the child-toggle button. |
| `tree_class` | `''` | Additional child list classes. |
| `target` | not set | Optional link target. |
| `rel` | automatic for `_blank` | Link relationship. Defaults to `noopener noreferrer` for `_blank`. |
| `title` | not set | Optional link title. |
| `aria_label` | not set | Optional accessible label for the item link. |
| `id` | not set | Optional item identifier. |

Item route aliases are also supported: `url_route`, `route_name`, `url_route_parameters`, and `parameters`. If a named route is set, it takes precedence over a direct URL. If an item has no destination, it renders as a non-link label rather than a dead `href="#"` link. Disabled items are never clickable. Section-header items use `header: true` and are not links.

---

## Basic Usage

```twig
{% set items = [
    {
        label: 'Dashboard',
        icon: '⌂',
        url: '/dashboard',
        active: true,
    },
    {
        label: 'Users',
        icon: '👥',
        children: [
            {
                label: 'All Users',
                url: '/users',
            },
            {
                label: 'Create User',
                route: 'users.create',
            },
        ],
    },
] %}

{% include
    'components/layout/sidebar.twig'
    with {
        brand: 'PixelFix',
        logo: 'P',
        items: items,
        brand_url: '/dashboard',
        search: true,
        accordion: true,
    }
    only
%}
```

## Named Routes and Parameters

```twig
{% set items = [
    {
        label: 'Dashboard',
        route: 'dashboard.index',
    },
    {
        label: 'User',
        route: 'users.show',
        route_parameters: {
            id: user.id,
        },
    },
] %}

{% include
    'components/layout/sidebar.twig'
    with {
        items: items,
        brand_route: 'dashboard.index',
        logout_route: 'logout',
        logout_text: 'Sign out',
        csrf: csrf,
    }
    only
%}
```

The named routes shown are examples and must exist in the application. The component calls PixelFix's `route()` helper to generate URLs.

## Section Headers

Set `header: true` to render an item as a navigation section heading.

```twig
{% set items = [
    {
        label: 'MAIN NAVIGATION',
        header: true,
    },
    {
        label: 'Dashboard',
        url: '/dashboard',
    },
] %}
```

## Active and Disabled Items

```twig
{% set items = [
    {
        label: 'Dashboard',
        url: '/dashboard',
        active: true,
    },
    {
        label: 'Reports',
        url: '/reports',
        disabled: true,
    },
    {
        label: 'Not Yet Available',
    },
] %}
```

The disabled and destination-less items render without a clickable link. Active items expose `aria-current="page"`.

## Badges and Nested Navigation

```twig
{% set items = [
    {
        label: 'Administration',
        open: true,
        children: [
            {
                label: 'Users',
                url: '/admin/users',
                badge: '12',
                badge_class: 'bg-primary',
            },
            {
                label: 'Roles',
                route: 'admin.roles.index',
            },
        ],
    },
] %}
```

Each child toggle has an `aria-controls` relationship to a unique nested list ID. The established `pixelfix-sidebar-nav-*` classes and `data-pixelfix-sidebar-*` attributes remain available to `sidebar.js` and the existing styles.

## Search

```twig
{% include
    'components/layout/sidebar.twig'
    with {
        items: items,
        search: true,
        search_label: 'Filter navigation',
        search_placeholder: 'Search navigation…',
        search_empty_text: 'No matching pages.',
    }
    only
%}
```

The search input is associated with its visible screen-reader label and preserves `data-pixelfix-sidebar-search` and `data-pixelfix-target` for the existing filtering script.

## User and Logout

The sidebar displays the supplied user's name and email. Logout is a POST form and requires a registered POST logout endpoint.

```twig
{% include
    'components/layout/sidebar.twig'
    with {
        user: user,
        logout_route: 'logout',
        logout_text: 'Sign out',
        csrf: csrf,
    }
    only
%}
```

`csrf` must contain framework-generated CSRF field markup. It is rendered as raw HTML because the field must contain an input element. Do not pass user-controlled markup as `csrf`.

## Customization

```twig
{% include
    'components/layout/sidebar.twig'
    with {
        id: 'app-sidebar',
        aria_label: 'Application sidebar',
        navigation_label: 'Workspace navigation',
        brand: 'PixelFix Admin',
        brand_route: 'dashboard.index',
        brand_target: '_self',
        class: 'shadow-sm',
        navigation_class: 'pt-2',
        menu_class: 'small',
        breakpoint: 991.98,
        persistence: true,
        mini: false,
        collapsed: false,
        without_hover: false,
        accordion: true,
        animation_speed: 300,
    }
    only
%}
```

---

## Compatibility and Security Notes

- Existing `pixelfix-sidebar-*` classes and `data-sidebar-*`/`data-pixelfix-sidebar-*` hooks are preserved for CSS and JavaScript integration.
- `brand_url` retains `/` as its default; supply an empty `brand_url` explicitly to render the brand as non-clickable text, or configure `brand_route`.
- Navigation items no longer default to `href="#"`. Configure `url`, `href` or a named route when an item should navigate.
- The logout action remains a POST form. CSRF markup should come from the application/framework, not user input.
- Twig escapes item labels, brand text, search labels, user details and normal attributes. Avoid passing untrusted markup in configurable icon or CSRF values.
