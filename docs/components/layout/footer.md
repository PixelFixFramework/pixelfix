# Footer Component

Renders the standard PixelFix application footer with copyright information and optional right-side content.

**Component:** `layout/footer.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `footer_company_name` | `config('app.name')` | Company/application name shown in the copyright link. |
| `footer_company_url` | `#` | URL of the copyright company/application link. |
| `footer_right` | `null` | Optional raw HTML rendered on the right side. |
| `container` | `container-fluid` | CSS container class wrapping footer content. |

## Behavior and Notes

The current year is generated internally with `"now"|date('Y')`; there is no year parameter.

## Usage

```twig
{% include 'components/layout/footer.twig' with {
    footer_company_name: 'PixelFix',
    footer_company_url: route('home'),
    footer_right: '<span>Version 0.1.10</span>'
} %}
```
