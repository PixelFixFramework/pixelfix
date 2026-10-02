# Toast Component

Renders a positioned Bootstrap toast with configurable message, appearance, auto-hide behavior, and optional automatic display on page load.

**Component:** `feedback/toast.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `id` | `toast` | DOM id of the toast. |
| `title` | `Notification` | Toast header title. |
| `message` | `Operation completed successfully.` | Toast body message. |
| `type` | `primary` | Type used for the colored indicator. |
| `time` | `Just now` | Timestamp/status text in the header. |
| `autohide` | `true` | Value written to `data-bs-autohide`. |
| `delay` | `5000` | Value written to `data-bs-delay`, in milliseconds for Bootstrap. |
| `position` | `bottom-end` | Toast container position. |
| `showOnLoad` | `false` | When true, injects a script that calls Bootstrap Toast `.show()` after `DOMContentLoaded`. |
| `theme` | `light` | Supported values are `light` and `dark`. |

## Behavior and Notes

Supported `position` values: `top-start`, `top-center`, `top-end`, `middle-start`, `middle-center`, `middle-end`, `bottom-start`, `bottom-center`, and `bottom-end`.

Unsupported positions fall back to `bottom-end`.

Unsupported themes fall back to the light theme classes.

The `showOnLoad` parameter uses camelCase exactly as written; it is not `show_on_load`.

The auto-show script requires Bootstrap's JavaScript API to be available as `bootstrap.Toast`.

## Usage

```twig
{% include 'components/feedback/toast.twig' with {
    id: 'task-toast',
    title: 'Task Saved',
    message: 'The task was saved successfully.',
    type: 'success',
    time: 'Just now',
    autohide: true,
    delay: 5000,
    position: 'bottom-end',
    showOnLoad: true,
    theme: 'light'
} %}
```
