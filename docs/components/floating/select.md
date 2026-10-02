# Floating Select Component

Renders a floating-label `<select>` with a placeholder option and automatic validation state.

**Component:** `floating/select.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | Required | Select name/id. |
| `label` | `''` | Floating label text. |
| `required` | `false` | Adds the HTML `required` attribute. |
| `options` | `{}` | Map of option values to option text. |
| `placeholder` | `Select` | Text in the initial empty option. |
| `validation_message` | Contextual default | Custom validation message shown when there is no current field error. |

## Behavior and Notes

The selected value is resolved from `old(name)`; there is no separate `value` parameter.

The option whose key matches `old(name)` is marked selected.

Validation state is `is-invalid` for errors and `is-valid` when an old value is present.

## Usage

```twig
{% include 'components/floating/select.twig' with {
    name: 'status',
    label: 'Status',
    options: {
        draft: 'Draft',
        published: 'Published'
    },
    required: true
} %}
```
