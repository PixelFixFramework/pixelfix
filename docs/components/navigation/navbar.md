# Navbar

> **Component:** `components/navigation/navbar.twig`

## Purpose

Renders a Bootstrap responsive navigation bar with brand, route-aware items, dropdowns, optional search, optional fixed positioning and optional mobile offcanvas integration.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``brand`` | Optional | `PixelFix` | Brand text. |
| ``brand_url`` | Optional | `#` | Direct brand URL. |
| ``brand_route`` | Optional | `null` | Named route used for the brand URL when supplied. |
| ``brand_route_params`` | Optional | `[]` | Parameters passed to `brand_route`. |
| ``items`` | Optional | `[]` | Top-level navigation item array. |
| ``expand`` | Optional | `lg` | Bootstrap navbar expand breakpoint. |
| ``theme`` | Optional | `light` | Bootstrap colour scheme value. |
| ``background`` | Optional | `bg-light` | Bootstrap bg class or CSS colour function. |
| ``style`` | Optional | `null` | Additional inline CSS. |
| ``fixed`` | Optional | `null` | `top` or `bottom`. |
| ``container`` | Optional | `container` | Bootstrap container class. |
| ``id`` | Optional | `navbar` | Collapse target id. |
| ``search`` | Optional | `null` | Search configuration object. |
| ``mobile_offcanvas`` | Optional | `null` | Id of an offcanvas target used instead of collapse on mobile. |


## Behavior

Top-level items accept `label`, `url`, `route`, `route_params`, `active`, `target`, `rel` and optional `children`. Dropdown children can also define `header` or `divider`. Search accepts `route`, `route_params`, `action`, `method`, `type`, `name`, `placeholder`, `aria_label`, `role`, `button_class` and `button_label`. When `background` begins with `rgb(`, `rgba(`, `hsl(` or `hsla(`, the value is emitted as inline `background-color`; otherwise the component prepends `bg-`.

## Example

```twig
{% include 'components/navigation/navbar.twig' with {
    brand: config('app.name'),
    brand_route: 'home',
    items: [
        {label: 'Home', route: 'home', active: true},
        {
            label: 'Resources',
            children: [
                {header: 'Documentation'},
                {label: 'Guides', url: '/guides'},
                {divider: true},
                {label: 'API', url: '/api'}
            ]
        }
    ],
    search: {
        route: 'search',
        method: 'get',
        name: 'q',
        placeholder: 'Search'
    }
} %}
```

## Usage

Use this component for public/starter application navigation. For mobile navigation backed by Bootstrap Offcanvas, set `mobile_offcanvas` to the offcanvas element's id.

## Notes

The current component renders item and child labels as trusted template values, while search is configured through a nested object.

## Related Components

- `components/navigation/offcanvas.twig`
- `components/navigation/breadcrumb.twig`
