# Toast

> **Component:** `components/feedback/toast.twig`

## Purpose

Creates a Bootstrap toast with a configurable position, type indicator, theme, title, message, timestamp and automatic show behavior.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``id`` | Optional | `toast` | DOM id of the toast. |
| ``title`` | Optional | `Notification` | Toast title. |
| ``message`` | Optional | `Operation completed successfully.` | Toast message. |
| ``type`` | Optional | `primary` | Bootstrap colour suffix for the status dot. |
| ``time`` | Optional | `Just now` | Timestamp/relative time text. |
| ``autohide`` | Optional | `true` | Bootstrap auto-hide toggle. |
| ``delay`` | Optional | `5000` | Auto-hide delay in milliseconds. |
| ``position`` | Optional | `bottom-end` | One of the supported position keys. |
| ``showOnLoad`` | Optional | `false` | Shows the toast after DOMContentLoaded. |
| ``theme`` | Optional | `light` | Use `light` or `dark`. |


## Behavior

Supported positions are `top-start`, `top-center`, `top-end`, `middle-start`, `middle-center`, `middle-end`, `bottom-start`, `bottom-center` and `bottom-end`. Unsupported values fall back to `bottom-0 end-0`. Unsupported themes fall back to light styling. When `showOnLoad` is true, the component emits inline JavaScript that calls Bootstrap's Toast API.

## Example

```twig
{% include 'components/feedback/toast.twig' with {
    id: 'save-toast',
    title: 'Saved',
    message: 'Changes saved successfully.',
    type: 'success',
    position: 'top-end',
    theme: 'light',
    showOnLoad: true
} %}
```

## Usage

Render the component once per toast instance. Give each toast a unique `id` when multiple toasts are present on the same page.

## Notes

The source uses Bootstrap's JavaScript Toast implementation, so Bootstrap JS must be loaded.

## Related Components

- `components/feedback/alert.twig`
- `components/feedback/spinner.twig`
