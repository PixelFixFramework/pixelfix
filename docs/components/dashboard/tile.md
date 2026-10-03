# Dashboard Tile

Renders a dashboard summary tile with a value, label, optional icon, and footer link.

**Component:** `components/dashboard/tile.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `value` | `''` | Main value displayed by the tile. |
| `label` | `''` | Label displayed below the value. |
| `icon` | `null` | Optional icon class or markup rendered by the tile. |
| `class` | `''` | Additional CSS class applied to the tile. |
| `url` | `#` | URL used by the footer link. |
| `footer_text` | `More info` | Footer link text. |

---

# Usage

```twig
{% include
    'components/dashboard/tile.twig'
    with {
        value:
            '128'

        label:
            'Registered Students'

        icon:
            'bi bi-people-fill'

        class:
            'bg-primary'

        url:
            '/students'

        footer_text:
            'View Students'
    }
    only
%}
```

---

## Complete Example

```twig
{% include
    'components/dashboard/tile.twig'
    with {
        value:
            'K 25,000'

        label:
            'Total Revenue'

        icon:
            'bi bi-cash-stack'

        url:
            '/reports/revenue'

        footer_text:
            'View Report'
    }
    only
%}
```
