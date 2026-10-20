# Theme Header Item

Renders the Light, Dark and Auto theme-selection control in the PixelFix application header. The control uses a semantic button and preserves the `data-pixelfix-theme-icon` and `data-pixelfix-theme-value` hooks consumed by `header.js`.

**Component:** `components/layout/header/theme.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `show` | `true` | Whether to render the component. An explicit `false` hides it. |
| `id` | `'pixelfix-theme-menu'` | ID of the dropdown trigger. |
| `menu_id` | `'pixelfix-theme-menu-items'` | ID of the dropdown menu. |
| `aria_label` | `'Toggle color scheme'` | Accessible label for the trigger button. |
| `title` | `''` | Optional title on the trigger button. |
| `item_class` | `'pixelfix-nav-item dropdown'` | Classes applied to the wrapping list item. |
| `control_class` | `'pixelfix-nav-link'` | Classes applied to the trigger button. |
| `link_class` | `control_class` fallback | Alias for `control_class`. |
| `class` | `''` | Additional classes on the trigger button. |
| `menu_class` | `'dropdown-menu dropdown-menu-end pixelfix-theme-menu'` | Classes applied to the dropdown menu. |
| `option_class` | `'dropdown-item d-flex align-items-center'` | Classes applied to all theme option buttons. |
| `light_label` | `'Light'` | Text for the Light option. |
| `dark_label` | `'Dark'` | Text for the Dark option. |
| `auto_label` | `'Auto'` | Text for the Auto option. |
| `light_icon_class` | `'bi bi-sun-fill'` | Icon classes for the Light mode. |
| `dark_icon_class` | `'bi bi-moon-fill'` | Icon classes for the Dark mode. |
| `auto_icon_class` | `'bi bi-circle-half'` | Icon classes for the Auto mode. |
| `check_icon_class` | `''` | Optional extra classes for each selected-state check icon. The required `bi-check-lg` class remains present for header.js. |

---

## Usage

### Default theme control

```twig
{% include
    'components/layout/header/theme.twig'
%}
```

### Customize labels and accessibility text

```twig
{% include
    'components/layout/header/theme.twig'
    with {
        aria_label:
            'Choose appearance',

        title:
            'Change application appearance',

        light_label:
            'Light mode',

        dark_label:
            'Dark mode',

        auto_label:
            'Use system setting',
    }
    only
%}
```

### Customize styling and icons

```twig
{% include
    'components/layout/header/theme.twig'
    with {
        id:
            'account-theme-menu',

        menu_id:
            'account-theme-options',

        control_class:
            'pixelfix-nav-link px-3',

        menu_class:
            'dropdown-menu dropdown-menu-end shadow',

        light_icon_class:
            'bi bi-sun',

        dark_icon_class:
            'bi bi-moon-stars-fill',
    }
    only
%}
```

To hide the control, set `show: false`.

## Theme values and JavaScript integration

The theme values remain `light`, `dark` and `auto`. The trigger icons keep `data-pixelfix-theme-icon="light|dark|auto"`; the option buttons keep `data-pixelfix-theme-value="light|dark|auto"`. These attributes are integration hooks for the existing `header.js` behavior and should not be renamed or replaced. Each option's `aria-pressed` state, selected styling, check icon and trigger icon are updated by `header.js` at runtime.

All Twig hash entries use trailing commas, including the final entry.
