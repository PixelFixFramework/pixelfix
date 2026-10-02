# Header Theme Switcher

> **Component:** `components/layout/header/theme.twig`

## Purpose

Provides the built-in theme selector for light, dark and auto colour schemes.

## API / Properties

This component declares **no configurable properties**.

## Behavior

The source provides Light, Dark and Auto buttons using `data-pixelfix-theme-value` and three corresponding icons. The framework theme JavaScript is responsible for applying the chosen scheme.

## Example

```twig
{% include 'components/layout/header/theme.twig' %}
```

## Usage

Include in the header end area and ensure the PixelFix theme JavaScript is loaded.

## Related Components

- `components/layout/header.twig`
- `components/layout/header/fullscreen.twig`
