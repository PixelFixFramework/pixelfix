# Breadcrumb

Renders a Bootstrap breadcrumb trail with direct URL or named-route navigation, an accessible navigation landmark, and a non-clickable current-page item.

**Component:** `components/navigation/breadcrumb.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `items` | `[]` | Ordered breadcrumb items. The final item is always displayed as the current page and is never linked. |
| `show` | `true` | When `false`, suppresses the entire breadcrumb component. An explicit `false` is respected. |
| `show_empty` | `false` | When `true`, renders the navigation landmark even when `items` is empty. |
| `aria_label` | `breadcrumb` | Accessible label for the breadcrumb navigation landmark. |
| `id` / `nav_id` | `''` | Optional ID on the `<nav>` element. `nav_id` takes precedence. |
| `class` / `nav_class` | `''` | Additional class on the `<nav>` element. `nav_class` takes precedence. |
| `list_class` / `breadcrumb_class` | `''` | Additional class on the `<ol>` element. `list_class` takes precedence. |
| `item_class` | `''` | Additional class on every breadcrumb list item. |
| `active_class` | `active` | Additional class applied to the final/current breadcrumb item. |
| `link_class` | `''` | Additional class applied to linked breadcrumb items. |

## Breadcrumb item properties

| Property | Default | Description |
|---|---|---|
| `label` | `''` | Visible label. Rendered as text and escaped by Twig. |
| `url` / `href` | `''` | Direct URL for a non-current breadcrumb. `url` takes precedence over `href` when no named route is configured. |
| `route` | `''` | Named route passed to PixelFix's `route()` helper. A named route takes precedence over a direct URL. |
| `route_parameters` | `{}` | Parameter array passed to the named route. |
| `url_route` / `route_name` | `''` | Compatibility aliases for `route`. |
| `url_route_parameters` / `parameters` | `{}` | Compatibility aliases for `route_parameters`. |
| `target` | `''` | Optional link target. |
| `rel` | `''` | Optional link relationship attribute. If `target` is `_blank` and `rel` is omitted, `noopener noreferrer` is used. |

Items without a URL or named route remain visible as non-clickable text. The component does not create `href="#"` fallback links. The final item is always current, is marked with `aria-current="page"`, and does not resolve its URL or route.

Named routes must be registered in the application. The component calls `route($routeName, $parameters)` for linked items that specify a route.

---

## Minimal usage

```twig
{% include
    'components/navigation/breadcrumb.twig'
%}
```

If `items` is empty, the component renders nothing by default.

## Direct URLs

```twig
{% include
    'components/navigation/breadcrumb.twig'
    with {
        items: [
            {
                label: 'Home',
                url: '/',
            },
            {
                label: 'Students',
                href: '/students',
            },
            {
                label: 'Details',
            },
        ],
    }
    only
%}
```

## Named routes and parameters

```twig
{% include
    'components/navigation/breadcrumb.twig'
    with {
        items: [
            {
                label: 'Home',
                route: 'home',
            },
            {
                label: 'Students',
                route: 'students.index',
                route_parameters: {
                    status: 'active',
                },
            },
            {
                label: 'Details',
            },
        ],
    }
    only
%}
```

## Customization and accessibility

```twig
{% include
    'components/navigation/breadcrumb.twig'
    with {
        id: 'account-breadcrumbs',
        aria_label: 'Account navigation trail',
        nav_class: 'mb-3',
        list_class: 'small mb-0',
        item_class: 'px-1',
        active_class: 'fw-semibold',
        link_class: 'text-decoration-none',
        items: [
            {
                label: 'Home',
                url: '/',
            },
            {
                label: 'Account',
            },
        ],
    }
    only
%}
```

To intentionally render an empty breadcrumb landmark, set `show_empty: true`. To hide a breadcrumb trail that has been configured, set `show: false`.
