# Header Documentation Link

> **Component:** `components/layout/header/documentation.twig`

## Purpose

Adds a header navigation item that links to application/framework documentation.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``documentation_url`` | Optional | `#` | Documentation destination. |


## Behavior

The current component is a fixed `<li>`/link item with a documentation icon and accessible label/title.

## Example

```twig
{% include 'components/layout/header/documentation.twig' with {
    documentation_url: route('docs')
} %}
```

## Usage

Include within the `header_start` block of `components/layout/header.twig` or through `default-header.twig`.

## Related Components

- `components/layout/header.twig`
- `components/layout/default-header.twig`
