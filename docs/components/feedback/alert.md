# Alert Component

Renders a Bootstrap-style alert with an optional title and optional dismiss button.

**Component:** `feedback/alert.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `type` | `primary` | Alert type appended to `alert-`. |
| `title` | `null` | Optional alert heading. |
| `dismissible` | `false` | When true, adds dismissible classes and a close button. |
| `content` | `''` | Alert body content. Rendered as raw HTML. |

## Behavior and Notes

`content` is rendered with `|raw`.

The dismiss button uses Bootstrap's `data-bs-dismiss="alert"` behavior.

## Usage

```twig
{% include 'components/feedback/alert.twig' with {
    type: 'success',
    title: 'Saved',
    dismissible: true,
    content: '<strong>Task saved successfully.</strong>'
} %}
```
