# Offcanvas

> **Component:** `components/navigation/offcanvas.twig`

## Purpose

Renders a Bootstrap Offcanvas panel with configurable placement, title, content, backdrop and scrolling behaviour.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``id`` | Required | `—` | Offcanvas id; used by Bootstrap and label linkage. |
| ``title`` | Optional | `Menu` | Header title. |
| ``content`` | Optional | `''` | Body HTML rendered raw. |
| ``placement`` | Optional | `start` | `start`, `end`, `top` or `bottom`. |
| ``backdrop`` | Optional | `true` | Whether Bootstrap should show a backdrop. |
| ``scroll`` | Optional | `false` | Whether body scrolling is allowed while open. |


## Behavior

The placement map converts the public value into Bootstrap classes. Invalid values fall back to `offcanvas-start`. The component emits `data-bs-scroll` and `data-bs-backdrop` attributes.

## Example

```twig
{% include 'components/navigation/offcanvas.twig' with {
    id: 'mobileNavigation',
    title: 'Navigation',
    placement: 'end',
    backdrop: true,
    scroll: false,
    content: '<a class="dropdown-item" href="/">Home</a>'
} %}
```

## Usage

Pair the offcanvas id with the `mobile_offcanvas` option of `components/navigation/navbar.twig` when using the navbar toggler to open it.

## Notes

`content` is raw HTML. Supply trusted markup.

## Related Components

- `components/navigation/navbar.twig`
