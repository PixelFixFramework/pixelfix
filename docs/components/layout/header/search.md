# Header Search

> **Component:** `components/layout/header/search.twig`

## Purpose

Adds a compact header search control with a configurable destination.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``search_url`` | Optional | `#` | Search destination. |


## Behavior

The current component is a fixed header search affordance. Its public API contains only the destination URL.

## Example

```twig
{% include 'components/layout/header/search.twig' with {
    search_url: route('search')
} %}
```

## Usage

Use inside the `header_end` block of the application header.

## Related Components

- `components/layout/header.twig`
- `components/navigation/navbar.twig`
