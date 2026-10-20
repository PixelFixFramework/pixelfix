# Fullscreen Header Item

Renders an accessible fullscreen toggle inside PixelFix's application header. It uses a real button instead of a link with `href="#"`, while retaining `data-pixelfix-toggle="fullscreen"` for the existing PixelFix header JavaScript.

**Component:** `components/layout/header/fullscreen.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `show` | `true` | Whether to render the item. Explicit `false` hides it. |
| `id` | `null` | Optional button ID. |
| `item_class` | `'pixelfix-nav-item'` | Class applied to the containing list item. |
| `control_class` | `'pixelfix-nav-link'` | Base class applied to the button. |
| `link_class` | `null` | Backward-friendly alias for `control_class`, used only if `control_class` is not supplied. |
| `class` | `''` | Additional class appended to the button class. |
| `enter_label` | `'Enter fullscreen'` | Accessible label shown when fullscreen is inactive. |
| `exit_label` | `'Exit fullscreen'` | Accessible label shown while fullscreen is active. |
| `enter_title` | Value of `enter_label` | Optional title shown while fullscreen is inactive. |
| `exit_title` | Value of `exit_label` | Optional title shown while fullscreen is active. |
| `enter_icon_class` | `'bi bi-arrows-fullscreen pixelfix-fullscreen-enter'` | Classes for the maximize icon. |
| `exit_icon_class` | `'bi bi-fullscreen-exit pixelfix-fullscreen-exit'` | Classes for the minimize/exit icon. The component adds `d-none` initially. |
| `icon_partial` | `''` | Optional partial that renders both icons. It receives `enter_icon_class` and `exit_icon_class`; retain the `data-pixelfix-icon="maximize"` and `data-pixelfix-icon="minimize"` attributes for the built-in toggle script. |
| `aria_pressed` | `null` | Optional initial `aria-pressed` state. Omit it to leave the attribute unset. |

The built-in JavaScript updates both icons and the button's accessible label/title when fullscreen state changes. The control does not require a destination URL.

---

## Usage

### Default control

```twig
{% include
    'components/layout/header/fullscreen.twig'
%}
```

### Customize labels and styling

```twig
{% include
    'components/layout/header/fullscreen.twig'
    with {
        enter_label:
            'Enter fullscreen',

        exit_label:
            'Exit fullscreen',

        enter_title:
            'Expand the application',

        exit_title:
            'Return to windowed view',

        class:
            'px-3',
    }
    only
%}
```

### Customize the icons with a partial

```twig
{% include
    'components/layout/header/fullscreen.twig'
    with {
        icon_partial:
            'components/layout/header/partials/fullscreen-icons.twig',
    }
    only
%}
```

The partial must preserve the data attributes used by PixelFix's fullscreen script:

```twig
<i
    class="{{ enter_icon_class }}"
    data-pixelfix-icon="maximize"
    aria-hidden="true"
></i>

<i
    class="{{ exit_icon_class }} d-none"
    data-pixelfix-icon="minimize"
    aria-hidden="true"
></i>
```

Every hash entry in the examples uses a trailing comma, including the final entry.
