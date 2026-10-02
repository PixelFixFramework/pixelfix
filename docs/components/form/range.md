# Range

> **Component:** `components/form/range.twig`

## Purpose

Renders an HTML range slider with min/max/step values, validation and framework old-value handling.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``name`` | Required | `—` | Range input name and id. |
| ``label`` | Optional | `''` | Visible label. |
| ``min`` | Optional | `0` | Minimum value. |
| ``max`` | Optional | `100` | Maximum value. |
| ``step`` | Optional | `1` | Step value. |
| ``value`` | Optional | `min` | Fallback initial value. |
| ``class`` | Optional | `''` | Additional classes. |
| ``required`` | Optional | `false` | Adds required. |
| ``disabled`` | Optional | `false` | Adds disabled. |
| ``validation_message`` | Optional | `Auto-generated` | Fallback validation message. |


## Behavior

The initial value is resolved using `old(name, value)`. Field errors are loaded from `errors()[name]`. The default value expression is the component's `min` value, so changing `min` also changes the default starting position.

## Example

```twig
{% include 'components/form/range.twig' with {
    name: 'priority',
    label: 'Priority',
    min: 1,
    max: 10,
    step: 1,
    value: 5
} %}
```

## Usage

Use for numeric values naturally represented on a continuous or bounded scale.

## Related Components

- `components/form/input.twig`
