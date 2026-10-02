# Radio Component

Renders a group of radio buttons from an options map with optional inline display and validation state.

**Component:** `form/radio.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | Required | Radio group name. |
| `label` | `''` | Optional group label. |
| `options` | `{}` | Map of option values to option text. |
| `inline` | `false` | Renders each radio as `.form-check-inline` when true. |
| `required` | `false` | Adds `required` to each radio input. |
| `value` | `''` | Initial selected value before `old()` resolution. |
| `class` | `''` | Additional classes applied to each radio input. |
| `disabled` | `false` | Disables every radio input when true. |
| `validation_message` | Contextual default | Custom fallback validation message. |

## Behavior and Notes

The selected value is resolved with `old(name, value)`.

Each option receives an id in the form `{name}_{optionValue}`.

The `options` map is expected as `value => text`.

The component calls `has_error(name)` and `error(name)` for validation.

## Usage

```twig
{% include 'components/form/radio.twig' with {
    name: 'priority',
    label: 'Priority',
    options: {
        low: 'Low',
        medium: 'Medium',
        high: 'High'
    },
    value: 'medium',
    inline: true
} %}
```
