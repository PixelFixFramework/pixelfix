# Sidebar

Renders the PixelFix application sidebar with branding, searchable navigation, nested items, optional user information, logout, persistence, and responsive behavior.

**Component:** `components/layout/sidebar.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `brand` | `PixelFix` | Sidebar brand text. |
| `logo` | `P` | Sidebar logo text. |
| `items` | `[]` | Sidebar navigation item collection. |
| `user` | `null` | User object used by the sidebar footer. |
| `logout_url` | `null` | Logout form action. |
| `logout_text` | `Logout` | Logout button text. |
| `class` | `''` | Additional sidebar CSS classes. |
| `id` | `pixelfix-sidebar` | Sidebar id. |
| `brand_url` | `/` | Brand link URL. |
| `search` | `true` | Enables the sidebar menu filter. |
| `search_placeholder` | `Filter menu…` | Search input placeholder. |
| `search_empty_text` | `No matching pages.` | Empty search result message. |
| `breakpoint` | `991.98` | Responsive breakpoint used by sidebar behavior. |
| `persistence` | `false` | Enables sidebar state persistence. |
| `mini` | `false` | Enables mini sidebar mode. |
| `collapsed` | `false` | Starts the sidebar collapsed. |
| `without_hover` | `false` | Disables hover expansion behavior. |
| `accordion` | `true` | Enables accordion behavior for nested navigation. |
| `animation_speed` | `300` | Sidebar animation speed. |

---

## Navigation Item

Each item may contain:

| Property | Default | Description |
|---|---|---|
| `label` | `''` | Item label. |
| `url` | `#` | Destination URL. |
| `icon` | `•` | Icon or text rendered before the label. |
| `active` | `false` | Marks the item active. |
| `disabled` | `false` | Renders the item as disabled. |
| `open` | `false` | Opens the nested navigation tree. |
| `header` | `false` | Renders the item as a navigation section header. |
| `badge` | `null` | Optional badge text. |
| `badge_class` | `''` | Additional CSS class applied to the badge. |
| `children` | `[]` | Nested navigation items. |

Child items use the same item structure recursively.

---

# Usage

```twig
{% set items = [
    {
        label: 'Dashboard',
        icon: '⌂',
        url: '/dashboard',
        active: true
    },
    {
        label: 'Users',
        icon: '👥',
        children: [
            {
                label: 'All Users',
                url: '/users'
            },
            {
                label: 'Create User',
                url: '/users/create'
            }
        ]
    }
] %}

{% include
    'components/layout/sidebar.twig'
    with {
        brand:
            'PixelFix',

        logo:
            'P',

        items:
            items,

        brand_url:
            '/dashboard',

        search:
            true,

        accordion:
            true
    }
    only
%}
```

---

## Navigation Header

Set `header` to `true` to render an item as a section heading.

```twig
{% set items = [
    {
        label: 'MAIN NAVIGATION',
        header: true
    },
    {
        label: 'Dashboard',
        url: '/dashboard'
    }
] %}
```

---

## Active and Disabled Items

```twig
{% set items = [
    {
        label: 'Dashboard',
        url: '/dashboard',
        active: true
    },
    {
        label: 'Reports',
        url: '/reports',
        disabled: true
    }
] %}
```

---

## Badges

Use `badge` and `badge_class` to display a badge beside a navigation item.

```twig
{% set items = [
    {
        label: 'Messages',
        url: '/messages',
        badge: '4',
        badge_class: 'bg-danger'
    }
] %}
```

---

## Nested Navigation

The `children` property creates a nested navigation tree.

```twig
{% set items = [
    {
        label: 'Administration',
        open: true,
        children: [
            {
                label: 'Users',
                url: '/admin/users'
            },
            {
                label: 'Roles',
                url: '/admin/roles'
            }
        ]
    }
] %}
```

---

## Search

The sidebar search can be configured independently.

```twig
{% include
    'components/layout/sidebar.twig'
    with {
        items:
            items,

        search:
            true,

        search_placeholder:
            'Search navigation…',

        search_empty_text:
            'No matching pages.'
    }
    only
%}
```

---

## User and Logout

The sidebar displays the user's name and email when `user` is supplied.

```twig
{% include
    'components/layout/sidebar.twig'
    with {
        user:
            user,

        logout_url:
            route('logout'),

        logout_text:
            'Sign out'
    }
    only
%}
```

The logout form outputs the framework `csrf` value as raw HTML.

---

## Complete Example

```twig
{% set items = [
    {
        label: 'MAIN NAVIGATION',
        header: true
    },
    {
        label: 'Dashboard',
        icon: '⌂',
        url: '/dashboard',
        active: true
    },
    {
        label: 'Users',
        icon: '👥',
        badge: '12',
        badge_class: 'bg-primary',
        children: [
            {
                label: 'All Users',
                url: '/users'
            },
            {
                label: 'Create User',
                url: '/users/create'
            }
        ]
    },
    {
        label: 'Reports',
        icon: '▣',
        url: '/reports'
    },
    {
        label: 'Disabled Page',
        icon: '•',
        url: '#',
        disabled: true
    }
] %}

{% include
    'components/layout/sidebar.twig'
    with {
        brand:
            'PixelFix',

        logo:
            'P',

        items:
            items,

        user:
            user,

        logout_url:
            route('logout'),

        logout_text:
            'Sign out',

        brand_url:
            '/dashboard',

        search:
            true,

        search_placeholder:
            'Filter menu…',

        search_empty_text:
            'No matching pages.',

        persistence:
            true,

        mini:
            false,

        collapsed:
            false,

        without_hover:
            false,

        accordion:
            true,

        animation_speed:
            300
    }
    only
%}
