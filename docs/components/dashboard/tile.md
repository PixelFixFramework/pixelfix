# Dashboard Tile Component

Renders a dashboard summary tile with a value, label, optional Bootstrap icon, and footer link.

**Component:** `dashboard/tile.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `value` | `''` | Primary value shown in the tile. |
| `label` | `''` | Text shown below the value. |
| `icon` | `null` | Optional Bootstrap icon name. The template prefixes it with `bi `. |
| `class` | `''` | Additional CSS classes for the tile. |
| `url` | `#` | Footer link URL. |
| `footer_text` | `More info` | Footer link text. |

## Behavior and Notes

The icon is rendered only when `icon` has a value. The footer link is always rendered.

## Usage

```twig
{% include 'components/dashboard/tile.twig' with {
    value: '42',
    label: 'Tasks',
    icon: 'check2-square',
    class: 'my-tile',
    url: route('tasks.index'),
    footer_text: 'View tasks'
} %}
```
