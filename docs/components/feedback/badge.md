# Badge

> **Component:** `components/feedback/badge.twig`

## Purpose

Renders a compact Bootstrap contextual badge.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``type`` | Optional | `primary` | Bootstrap contextual suffix. |
| ``text`` | Optional | `Badge` | Badge text. |


## Behavior

The component uses Bootstrap's `text-bg-{type}` utility classes.

## Example

```twig
{% include 'components/feedback/badge.twig' with {
    type: 'success',
    text: 'Active'
} %}
```

## Usage

Use badges for statuses, counts and small categorical labels.

## Related Components

- `components/data/table.twig`
- `components/dashboard/tile.twig`
