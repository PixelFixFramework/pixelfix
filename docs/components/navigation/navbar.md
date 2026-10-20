# Navbar

Renders a Bootstrap navigation bar with optional brand navigation, ordinary links, dropdown menus, search, fixed positioning, Bootstrap theme/background controls, and mobile offcanvas support.

**Component:** `components/navigation/navbar.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `brand` | `PixelFix` | Brand label. |
| `brand_url` | Not configured | Direct brand URL. Without a URL or route, the brand is plain text. |
| `brand_href` | Not configured | Alias for `brand_url`. |
| `brand_route` | Not configured | Named route for the brand; takes precedence over a direct URL. |
| `brand_route_params` | `[]` | Legacy route parameters for `brand_route`. |
| `brand_route_parameters` | `[]` | Alias for the brand route parameters. |
| `brand_url_route` | Not configured | Alias for `brand_route`. |
| `brand_url_route_parameters` | `[]` | Alias for brand route parameters. |
| `brand_class` | `''` | Extra brand link or label classes. |
| `brand_target`, `brand_rel` | `null` | Brand link target and relationship. `_blank` defaults to `noopener noreferrer`. |
| `show_brand` | `true` | Whether to render the brand. Explicit `false` is respected. |
| `items` | `[]` | Top-level navigation item array. |
| `expand` | `lg` | Bootstrap expansion breakpoint (`sm`, `md`, `lg`, `xl`, `xxl`); `false` omits the expansion class. |
| `theme` | `light` | Value for Bootstrap's `data-bs-theme`. |
| `background` | `bg-light` | Bootstrap background class or CSS color value (`#`, `rgb()`, `rgba()`, `hsl()`, `hsla()`). |
| `style` | `null` | Additional inline CSS for the navbar. Supply trusted application configuration only. |
| `fixed` | `null` | Fixed position: `top` or `bottom`. |
| `container` | `container` | Bootstrap container class. |
| `container_class` | — | Alias that takes precedence over `container`. |
| `id` | `navbar` | ID of the collapsible navbar content; used by the default toggler. |
| `collapse_id` | — | Alias for `id`. |
| `nav_id` | `null` | Optional ID for the `<nav>` element itself. |
| `aria_label` | `Main navigation` | Accessible name for the navbar. |
| `class`, `navbar_class` | `''` | Additional navbar classes. `class` takes precedence. |
| `nav_items_class` | `''` | Additional classes for the navigation list. |
| `collapse_class` | `''` | Additional classes for the collapse container. |
| `show_toggler` | `true` | Whether to show the mobile toggle button. Explicit `false` is respected. |
| `toggler_class` | `''` | Extra mobile toggle classes. |
| `toggler_icon_class` | `navbar-toggler-icon` | Classes for the toggle icon span. |
| `toggler_label` | Contextual default | Accessible label for the toggle button. |
| `toggler_title` | `null` | Optional title for the toggle button. |
| `mobile_offcanvas` | `null` | ID of an existing Offcanvas component. A leading `#` is accepted and normalized. |
| `search` | `null` | Optional search configuration object described below. |

## Navigation items

An ordinary item supports these properties:

| Property | Default | Description |
|---|---|---|
| `label` | `''` | Visible item label. |
| `url`, `href` | Not configured | Direct destination; `url` takes precedence when defined. |
| `route`, `url_route`, `route_name` | Not configured | Named route; named routes take precedence over direct URLs. |
| `route_params`, `route_parameters`, `url_route_parameters`, `parameters` | `[]` | Route parameters. Legacy `route_params` takes precedence when supplied. |
| `active` | `false` | Applies active styling and `aria-current="page"`. |
| `disabled` | `false` | Prevents navigation and route resolution. Disabled items render as non-links. |
| `target`, `rel` | — | Link target and relationship. `_blank` defaults to `noopener noreferrer`. |
| `title`, `aria_label` | — | Optional link attributes. |
| `item_class`, `link_class` | `''` | Additional item and link classes. |
| `children` | — | Non-empty array creates a dropdown. The parent renders as a button, not a link. |
| `open` | `active` value | Initial dropdown expanded state. Explicit `false` is respected. |
| `menu_class` | `''` | Additional dropdown menu classes. |

Dropdown child items support the same destination, route, active, disabled, target, rel, title and class properties. A child with `header` renders a dropdown heading; a child with `divider: true` renders a divider. A child without a destination remains a non-clickable label.

## Search object

| Property | Default | Description |
|---|---|---|
| `route`, `url_route`, `route_name` | — | Named route for the form action. Takes precedence over direct actions. |
| `route_params`, `route_parameters`, `url_route_parameters`, `parameters` | `[]` | Search-route parameters. |
| `form_action`, `action`, `url`, `href` | Not configured | Direct form action when a named route is not supplied. An omitted action submits to the current URL. |
| `method` | `get` | Form submission method. |
| `role` | `search` | Form role. |
| `id` | — | Optional search form ID. |
| `type` | `search` | Input type. |
| `name` | `query` | Input name. Explicit empty string omits the `name` attribute. |
| `input_id` | — | Optional input ID. |
| `placeholder` | `Search` | Input placeholder. |
| `aria_label` | `Search` | Form accessible label and, unless overridden, input accessible label. |
| `input_aria_label` | `Search` | Input-specific accessible label. |
| `form_class`, `input_class` | `''` | Additional form and input classes. |
| `required` | `false` | Marks the search input as required. |
| `autocomplete` | — | Optional input autocomplete value. |
| `disabled` | `false` | Disables the search input. |
| `show_button` | `true` | Controls the submit button; explicit `false` is respected. |
| `button_class` | `btn-outline-success` | Submit button class suffix. |
| `button_label` | `Search` | Submit button text. |
| `button_title` | — | Optional submit button title. |

---

## Direct URL usage

```twig
{% set items = [
    {
        label: 'Dashboard',
        url: '/dashboard',
        active: true,
    },
    {
        label: 'Users',
        href: '/users',
    },
    {
        label: 'Reports',
        children: [
            {
                label: 'Annual reports',
                url: '/reports/annual',
            },
            {
                label: 'Monthly reports',
                url: '/reports/monthly',
            },
        ],
    },
] %}

{% include
    'components/navigation/navbar.twig'
    with {
        brand: 'PixelFix',
        brand_url: '/',
        items: items,
        expand: 'lg',
        theme: 'light',
        background: 'bg-light',
        container: 'container',
        search: {
            action: '/search',
            method: 'get',
            name: 'query',
            placeholder: 'Search...',
            button_label: 'Search',
        },
    }
    only
%}
```

## Named routes

```twig
{% set items = [
    {
        label: 'Dashboard',
        route: 'dashboard.index',
    },
    {
        label: 'Users',
        route: 'users.index',
        route_parameters: {
            status: 'active',
        },
    },
    {
        label: 'Reports',
        children: [
            {
                label: 'Annual reports',
                route: 'reports.annual',
                route_params: {
                    year: 2026,
                },
            },
        ],
    },
] %}

{% include
    'components/navigation/navbar.twig'
    with {
        brand: 'PixelFix',
        brand_route: 'home',
        items: items,
        search: {
            route: 'search.index',
            route_params: [],
            method: 'get',
            name: 'query',
            placeholder: 'Search...',
            button_label: 'Search',
        },
    }
    only
%}
```

Route names in these examples are illustrative and must exist in the application. The component calls PixelFix's `route()` helper and passes the supplied parameters. A route takes precedence over a direct URL when both are configured. Links without destinations are rendered as text; the component does not create `href="#"` fallbacks.

## Mobile Offcanvas

Set `mobile_offcanvas` to the ID of an existing Offcanvas component. The navbar toggler will target that component rather than the collapse container.

```twig
{% include
    'components/navigation/navbar.twig'
    with {
        brand: 'PixelFix',
        brand_url: '/',
        items: items,
        mobile_offcanvas: 'mobile-menu',
    }
    only
%}
```

The component preserves Bootstrap's `data-bs-toggle`, `data-bs-target`, `aria-controls` and `aria-expanded` attributes. It does not create the offcanvas component itself.

## Security and compatibility notes

- Labels and attribute values are escaped by Twig when the application's Twig environment uses HTML autoescaping.
- `style` is intended for trusted application configuration only.
- Navigation items and dropdown children without configured destinations render without links. Disabled items never resolve their named routes.
- A dropdown parent with children renders as a toggle button; its own URL or route is not used as a destination.
- Search defaults to `GET` with the input name `query`; supply a custom `name` when the receiving endpoint expects another field.
- A `_blank` target receives `rel="noopener noreferrer"` unless a custom `rel` is supplied.
