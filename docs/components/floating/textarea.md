# Floating Textarea Component

Renders a floating-label textarea with configurable rows and automatic validation state.

**Component:** `floating/textarea.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | Required | Textarea name/id. |
| `label` | `''` | Floating label text. |
| `required` | `false` | Adds the HTML `required` attribute. |
| `rows` | `5` | Used to calculate the inline height (`rows * 30px`). |
| `validation_message` | Contextual default | Custom validation message shown when there is no current field error. |

## Behavior and Notes

The value is taken from `old(name)`; there is no separate `value` parameter.

Validation state is `is-invalid` for errors and `is-valid` when an old value is present.

## Usage

```twig
{% include 'components/floating/textarea.twig' with {
    name: 'description',
    label: 'Description',
    rows: 6
} %}
```
