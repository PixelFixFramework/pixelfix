# Flash Messages

> **Component:** `components/feedback/flash-messages.twig`

## Purpose

Reads framework flash messages and renders each message through the alert component. It is designed for page-level success, error and other session-flash feedback.

## API / Properties

This component declares **no configurable component properties**. It reads the framework `flash_messages()` helper and passes each message into `components/feedback/alert.twig`. The special `error` type is normalized to Bootstrap `danger`.

## Behavior

The component loops through flash message groups by type and message. Multiple messages are rendered as multiple alerts.

## Example

```twig
{% include 'components/feedback/flash-messages.twig' %}
```

## Usage

Place the component near the top of a page or content area where post-redirect flash feedback should appear.

## Notes

The component depends on the framework `flash_messages()` helper being available. It does not take a `messages` parameter.

## Related Components

- `components/feedback/alert.twig`
