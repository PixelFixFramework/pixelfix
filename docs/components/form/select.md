# Select

> **Component:** `components/form/select.twig`

## Purpose

Renders a standard Bootstrap `<select>` with an empty placeholder option, option mapping, old-value preservation and validation.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``name`` | Required | `—` | Select name and id. |
| ``label`` | Optional | `''` | Visible label. |
| ``required`` | Optional | `false` | Adds required. |
| ``options`` | Optional | `{}` | Associative array of option value => option text. |
| ``placeholder`` | Optional | `Select` | Empty placeholder option text. |
| ``value`` | Optional | `''` | Fallback selected value. |
| ``validation_message`` | Optional | `Auto-generated` | Fallback validation message. |


## Behavior

The selected value is resolved with `old(name, value)`. Option values are compared directly to that resolved value. Validation uses the first field error when available.

## Example

```twig
{% include 'components/form/select.twig' with {
    name: 'status',
    label: 'Status',
    options: {
        'pending': 'Pending',
        'completed': 'Completed'
    },
    value: 'pending',
    required: true
} %}
```

## Usage

Prepare an associative map where the array key is the submitted value and the array value is the user-facing label.

## Related Components

- `components/floating/select.twig`
- `components/form/radio.twig`
