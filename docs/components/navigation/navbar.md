# Navbar Component

Renders a Bootstrap-style responsive navigation bar with route-aware brand and links, dropdown children, optional search, configurable theme/background, and optional mobile offcanvas integration.

**Component:** `navigation/navbar.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `brand` | `PixelFix` | Brand text. |
| `brand_url` | `#` | Brand URL when no `brand_route` is supplied. |
| `brand_route` | `null` | Optional route name used to resolve the brand URL. |
| `brand_route_params` | `[]` | Parameters passed to `brand_route`. |
| `items` | `[]` | Navigation item array. |
| `expand` | `lg` | Breakpoint used in `navbar-expand-*`. |
| `theme` | `light` | Value written to `data-bs-theme`. |
| `background` | `bg-light` | Bootstrap background class, a CSS color value, or another value that becomes `bg-{background}`. |
| `style` | `null` | Optional inline style appended to the navbar. |
| `fixed` | `null` | Use `top` or `bottom` for Bootstrap fixed positioning. |
| `container` | `container` | Container class. |
| `id` | `navbar` | Collapse target id. |
| `search` | `null` | Optional search configuration object. |
| `mobile_offcanvas` | `null` | Optional offcanvas id used by the mobile toggler instead of Bootstrap collapse. |

## Behavior and Notes

When `brand_route` is supplied, its resolved URL takes precedence over `brand_url`.

Top-level items support `label`, `url` or `route` plus optional `route_params`, `active`, `target`, `rel`, and `children`.

Items with `children` render a dropdown. Each child can be a `header`, a `divider`, or a link with `label`, `url` or `route`, optional `route_params`, `active`, `target`, and `rel`.

The `background` value is treated specially: values beginning with `bg-` become classes; CSS color values beginning with `#`, `rgb(`, `rgba(`, `hsl(`, or `hsla(` become inline background color; other values become `bg-{background}`.

`fixed` recognizes `top` and `bottom`; other values result in no fixed-position class.

The optional `search` object supports `route`, `route_params`, `action`, `role`, `method`, `type`, `name`, `placeholder`, `aria_label`, `button_class`, and `button_label`.

When `mobile_offcanvas` is set, the navbar toggler targets that offcanvas id; otherwise it targets the navbar collapse id.

## Usage

```twig
{% include 'components/navigation/navbar.twig' with {
    brand: config('app.name'),
    brand_route: 'home',
    brand_route_params: [],
    expand: 'lg',
    theme: 'light',
    background: 'bg-light',
    container: 'container',
    items: [
        {
            label: 'Home',
            route: 'home',
            active: true
        },
        {
            label: 'Tasks',
            children: [
                { label: 'All Tasks', route: 'tasks.index' },
                { divider: true },
                { label: 'Create Task', route: 'tasks.create' }
            ]
        }
    ]
} %}
```
