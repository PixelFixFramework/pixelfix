# Badge Component

Renders a small badge using the supplied type and text.

**Component:** `feedback/badge.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `type` | `primary` | Value appended to `text-bg-`. |
| `text` | `Badge` | Badge text. |

## Usage

```twig
{% include 'components/feedback/badge.twig' with {
    type: 'success',
    text: 'Active'
} %}
```
