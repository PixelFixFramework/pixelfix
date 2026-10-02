# Spinner Component

Renders a Bootstrap-style spinner with a visually hidden loading label.

**Component:** `feedback/spinner.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `type` | `primary` | Spinner text type appended to `text-`. |
| `size` | `null` | Use `sm` for the small spinner variant. |
| `label` | `Loading...` | Visually hidden status text. |

## Usage

```twig
{% include 'components/feedback/spinner.twig' with {
    type: 'primary',
    size: 'sm',
    label: 'Loading tasks...'
} %}
```
