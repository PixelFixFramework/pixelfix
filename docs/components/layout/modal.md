# Modal Component

Renders a Bootstrap modal with configurable size, scrolling, vertical centering, static backdrop behavior, and optional footer content.

**Component:** `layout/modal.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `id` | Required | Unique modal id. |
| `title` | `Modal` | Modal title. |
| `content` | `''` | Modal body content. Rendered as raw HTML. |
| `footer` | `null` | Optional modal footer content. Rendered as raw HTML. |
| `size` | `null` | Optional size. Supported values: `sm`, `lg`, `xl`, `fullscreen`, `fullscreen-sm-down`, `fullscreen-md-down`, `fullscreen-lg-down`, `fullscreen-xl-down`, `fullscreen-xxl-down`. |
| `scrollable` | `false` | Adds Bootstrap's `modal-dialog-scrollable` class. |
| `centered` | `false` | Adds Bootstrap's `modal-dialog-centered` class. |
| `static` | `false` | Uses a static backdrop and disables keyboard closing. |

## Behavior and Notes

`id` is required because it is used by the modal and `aria-labelledby` target.

## Usage

```twig
{% include 'components/layout/modal.twig' with {
    id: 'task-details',
    title: 'Task Details',
    content: '<p>Task information</p>',
    centered: true,
    scrollable: true,
    size: 'lg'
} %}
```
