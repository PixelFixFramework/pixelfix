# Navbar

Renders a Bootstrap navigation bar with brand routing, navigation items, dropdowns, optional search, fixed positioning, theming, and mobile offcanvas support.

**Component:** `components/navigation/navbar.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `brand` | `PixelFix` | Brand text. |
| `brand_url` | `#` | Direct brand URL. |
| `brand_route` | `null` | Named route used for the brand URL. |
| `brand_route_params` | `[]` | Parameters passed to the brand route. |
| `items` | `[]` | Navigation item collection. |
| `expand` | `lg` | Bootstrap navbar expansion breakpoint. |
| `theme` | `light` | Bootstrap navbar color scheme. |
| `background` | `bg-light` | Bootstrap background class or CSS color value. |
| `style` | `null` | Additional inline CSS. |
| `fixed` | `null` | Fixed position: `top` or `bottom`. |
| `container` | `container` | Bootstrap container class. |
| `id` | `navbar` | Navbar collapse id. |
| `search` | `null` | Optional search configuration object. |
| `mobile_offcanvas` | `null` | Offcanvas id used by the mobile toggler. |

---

## Navigation Item

A normal item may contain:

| Property | Default | Description |
|---|---|---|
| `label` | — | Item label. |
| `url` | `#` | Direct URL. |
| `route` | — | Named route. |
| `route_params` | `[]` | Named route parameters. |
| `active` | `false` | Marks the item active. |
| `target` | — | Link target. |
| `rel` | — | Link rel attribute. |
| `children` | — | Presence of this property creates a dropdown. |

Dropdown children may contain `label`, `url`, `route`, `route_params`, `active`,
`target`, `rel`, `header`, and `divider`.

---

## Search Object

| Property | Default | Description |
|---|---|---|
| `route` | — | Named route used for search action. |
| `route_params` | `[]` | Route parameters. |
| `action` | `null` | Direct search action when no route is supplied. |
| `role` | `search` | Form role. |
| `method` | — | Form method when supplied. |
| `type` | `search` | Search input type. |
| `name` | — | Search input name. |
| `placeholder` | `Search` | Search placeholder. |
| `aria_label` | `Search` | Search input aria label. |
| `button_class` | `btn-outline-success` | Search button classes. |
| `button_label` | `Search` | Search button text. |

---

# Usage

```twig
{% set items = [
    {
        label: 'Dashboard',
        route: 'dashboard'
    },
    {
        label: 'Users',
        children: [
            {
                label: 'All Users',
                route: 'users.index'
            },
            {
                label: 'Create User',
                route: 'users.create'
            }
        ]
    }
] %}

{% include
    'components/navigation/navbar.twig'
    with {
        brand:
            'PixelFix',

        brand_route:
            'home',

        items:
            items,

        expand:
            'lg',

        theme:
            'light',

        background:
            'bg-light',

        container:
            'container',

        search:
            {
                route: 'search',
                route_params: [],
                method: 'get',
                name: 'query',
                placeholder: 'Search...',
                button_label: 'Search'
            }
    }
    only
%}
```

---

## Mobile Offcanvas

Set `mobile_offcanvas` to the id of an existing Offcanvas component.

```twig
{% include
    'components/navigation/navbar.twig'
    with {
        brand:
            'PixelFix',

        items:
            items,

        mobile_offcanvas:
            'mobile-menu'
    }
    only
%}
```
