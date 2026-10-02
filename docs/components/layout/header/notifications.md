# Header Notifications

> **Component:** `components/layout/header/notifications.twig`

## Purpose

Displays a header notifications control with a numeric count.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``notification_count`` | Optional | `15` | Number displayed on the notifications badge. |


## Behavior

The component is intentionally small: the public API is the notification count only.

## Example

```twig
{% include 'components/layout/header/notifications.twig' with {
    notification_count: 7
} %}
```

## Usage

Use as part of the default application header. Detailed notification content belongs in the surrounding application logic.

## Related Components

- `components/layout/header.twig`
- `components/layout/header/messages.twig`
