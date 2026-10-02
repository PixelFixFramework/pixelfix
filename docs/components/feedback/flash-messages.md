# Flash Messages Component

Reads flash messages through the `flash_messages()` helper and renders each message through the Alert component.

**Component:** `feedback/flash-messages.twig`

## Behavior and Notes

No component parameters are defined.

The `flash_messages()` helper is called internally.

A flash message type of `error` is converted to the alert type `danger`; other types are passed through unchanged.

Each message is rendered by `components/feedback/alert.twig`.

## Usage

```twig
{% include 'components/feedback/flash-messages.twig' %}
```
