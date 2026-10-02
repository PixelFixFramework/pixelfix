# Footer

> **Component:** `components/layout/footer.twig`

## Purpose

Renders the canonical PixelFix application footer with copyright attribution and an optional right-side content area.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``footer_company_name`` | Optional | `config('app.name')` | Company/application name. |
| ``footer_company_url`` | Optional | `#` | Copyright link destination. |
| ``footer_right`` | Optional | `null` | Optional right-side HTML. |
| ``container`` | Optional | `container-fluid` | Footer container class. |


## Behavior

The current year is derived inside the component with `"now"|date('Y')`. The right-side block is hidden on small screens using `d-none d-sm-inline`.

## Example

```twig
{% include 'components/layout/footer.twig' with {
    footer_company_name: config('app.name'),
    footer_company_url: route('home'),
    footer_right: ''
} %}
```

## Usage

Include the footer at page level when the page needs it. The neutral `layouts/app.twig` does not automatically include the footer.

## Notes

Do not pass `footer_start_year`; the current component API does not define it.

## Related Components

- `components/layout/main.twig`
