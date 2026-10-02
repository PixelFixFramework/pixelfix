# Spinner

> **Component:** `components/feedback/spinner.twig`

## Purpose

Renders an accessible Bootstrap border spinner with a contextual colour, optional small size and a visually-hidden status label.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``type`` | Optional | `primary` | Bootstrap text colour suffix. |
| ``size`` | Optional | `null` | Use `sm` for `spinner-border-sm`. |
| ``label`` | Optional | `Loading...` | Visually-hidden status text. |


## Behavior

The spinner uses `role="status"` and puts the label inside `.visually-hidden`.

## Example

```twig
{% include 'components/feedback/spinner.twig' with {
    type: 'success',
    size: 'sm',
    label: 'Saving changes...'
} %}
```

## Usage

Use while waiting for an operation to complete. Provide a meaningful `label` when the surrounding UI does not already explain the loading state.

## Related Components

- `components/feedback/toast.twig`
