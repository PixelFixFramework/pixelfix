# Dashboard Tile

> **Component:** `components/dashboard/tile.twig`

## Purpose

Displays a compact dashboard statistic consisting of a value, label, optional Bootstrap icon and a footer link.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``value`` | Optional | `''` | Primary statistic shown in the tile. |
| ``label`` | Optional | `''` | Descriptive label. |
| ``icon`` | Optional | `null` | Bootstrap Icons class suffix. The component prepends `bi `. |
| ``class`` | Optional | `''` | Additional CSS class(es) appended to the tile root. |
| ``url`` | Optional | `#` | Footer link destination. |
| ``footer_text`` | Optional | `More info` | Footer link text. |


## Behavior

The component renders `pixelfix-dashboard-tile` classes supplied by the framework stylesheet. When `icon` is provided, the markup uses `<i class="bi {{ icon }}"></i>`.

## Example

```twig
{% include 'components/dashboard/tile.twig' with {
    value: 42,
    label: 'Open Tasks',
    icon: 'check-circle',
    url: route('tasks.index'),
    footer_text: 'View tasks'
} %}
```

## Usage

Use dashboard tiles for aggregate counts or headline metrics. Pass an icon name such as `check-circle`, not a complete `<i>` tag.

## Related Components

- `components/layout/main.twig`
