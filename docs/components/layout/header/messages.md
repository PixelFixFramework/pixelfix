# Messages Header Item

Renders the messages dropdown with an unread count and a fixed set of sample message entries.

**Component:** `layout/header/messages.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `message_count` | `3` | Unread message count shown in the badge and accessible label. |

## Behavior and Notes

The message list itself is static in the template; only the count is configurable.

## Usage

```twig
{% include 'components/layout/header/messages.twig' with {
    message_count: 5
} %}
```
