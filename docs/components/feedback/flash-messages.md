# Flash Messages

Renders session flash messages as reusable Alert components.

**Component:** `components/feedback/flash-messages.twig`

---

## Parameters

This component does not accept explicit parameters.

It reads flash messages using the framework `flash_messages()` helper.

The flash message structure is grouped by message type and then by message text.

---

# Usage

Include the component wherever session flash messages should be displayed.

```twig
{% include
    'components/feedback/flash-messages.twig'
%}
```

---

## Message Types

The component converts a flash type of `error` to the Bootstrap alert type
`danger`. Other types are passed through to the Alert component.

---

## Complete Example

```twig
{% include
    'components/feedback/flash-messages.twig'
%}
```
