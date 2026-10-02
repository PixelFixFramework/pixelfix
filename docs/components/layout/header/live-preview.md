# Header Live Preview Link

> **Component:** `components/layout/header/live-preview.twig`

## Purpose

Adds a header navigation item for opening the application's live preview.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``live_preview_url`` | Optional | `#` | Live preview destination. |


## Behavior

The current component is a fixed navigation item with the Bootstrap `bi-eye` icon and a link target.

## Example

```twig
{% include 'components/layout/header/live-preview.twig' with {
    live_preview_url: route('preview')
} %}
```

## Usage

Include in the header start area when the application exposes a preview route.

## Related Components

- `components/layout/header.twig`
- `components/layout/default-header.twig`
