# Header Fullscreen Toggle

> **Component:** `components/layout/header/fullscreen.twig`

## Purpose

Adds the header control used to enter/exit fullscreen mode.

## API / Properties

This component declares **no configurable properties**.

## Behavior

The control emits `data-pixelfix-toggle="fullscreen"` and swaps the enter/exit icons using the classes `pixelfix-fullscreen-enter` and `pixelfix-fullscreen-exit`.

## Example

```twig
{% include 'components/layout/header/fullscreen.twig' %}
```

## Usage

Include it in the header end area. The framework's JavaScript must implement the fullscreen toggle behaviour.

## Related Components

- `components/layout/header.twig`
- `components/layout/header/theme.twig`
