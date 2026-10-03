# Theme Header Item

Renders the light, dark, and automatic theme selection control in the application header.

**Component:** `components/layout/header/theme.twig`

---

## Parameters

This component does not accept explicit parameters.

The component provides the theme values `light`, `dark`, and `auto` through
`data-pixelfix-theme-value` attributes.

---

# Usage

```twig
{% include
    'components/layout/header/theme.twig'
%}
```

---

## Theme Values

| Value | Label |
|---|---|
| `light` | Light |
| `dark` | Dark |
| `auto` | Auto |
