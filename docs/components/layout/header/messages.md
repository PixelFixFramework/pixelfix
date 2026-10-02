# Header Messages

> **Component:** `components/layout/header/messages.twig`

## Purpose

Displays a header messages control with a numeric count.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``message_count`` | Optional | `3` | Number displayed on the messages badge. |


## Behavior

The current component uses the count value to render the header badge/control. No message collection is accepted by this component.

## Example

```twig
{% include 'components/layout/header/messages.twig' with {
    message_count: 5
} %}
```

## Usage

Use the component for the navigation affordance; application-specific message lists are outside this component's current API.

## Related Components

- `components/layout/header.twig`
- `components/layout/header/notifications.twig`
