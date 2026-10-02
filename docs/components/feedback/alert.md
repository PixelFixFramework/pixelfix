# Alert

> **Component:** `components/feedback/alert.twig`

## Purpose

Displays a Bootstrap alert message with an optional heading and optional dismiss button.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``type`` | Optional | `primary` | Bootstrap contextual class, producing `alert-{type}`. |
| ``title`` | Optional | `null` | Optional alert heading. |
| ``dismissible`` | Optional | `false` | Adds Bootstrap dismissible alert behavior. |
| ``content`` | Optional | `''` | Alert body. Rendered as raw HTML. |


## Behavior

When `dismissible` is true, the component adds `alert-dismissible fade show` and a close button. `content` is rendered with `|raw`.

## Example

```twig
{% include 'components/feedback/alert.twig' with {
    type: 'success',
    title: 'Saved',
    content: 'The record was updated successfully.',
    dismissible: true
} %}
```

## Usage

Use for prominent feedback that belongs in the page content rather than transient toast notifications.

## Related Components

- `components/feedback/flash-messages.twig`
- `components/feedback/validation-errors.twig`
- `components/feedback/toast.twig`
