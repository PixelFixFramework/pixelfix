# Range Component

Renders an HTML range input with configurable minimum, maximum, step, and validation feedback.

**Component:** `form/range.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | Required | Range input name/id. |
| `label` | `''` | Optional label. |
| `min` | `0` | Minimum value. |
| `max` | `100` | Maximum value. |
| `step` | `1` | Range step. |
| `value` | `min` | Initial value; defaults to the configured minimum. |
| `class` | `''` | Additional range classes. |
| `required` | `false` | Adds the HTML `required` attribute. |
| `disabled` | `false` | Adds the HTML `disabled` attribute. |
| `validation_message` | `null` | Custom fallback validation message. |

## Behavior and Notes

The rendered value is resolved using `old(name, value)`.

The component reads field errors from `errors()[name]`.

## Usage

```twig
{% include 'components/form/range.twig' with {
    name: 'progress',
    label: 'Progress',
    min: 0,
    max: 100,
    step: 5,
    value: 50
} %}
```
