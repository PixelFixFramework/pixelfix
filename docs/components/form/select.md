# Select Component

Renders a standard `<select>` element with a placeholder option, selectable options map, old-value resolution, and validation feedback.

**Component:** `form/select.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | Required | Select name/id. |
| `label` | `''` | Optional label. |
| `required` | `false` | Adds the HTML `required` attribute. |
| `options` | `{}` | Map of option values to option text. |
| `placeholder` | `Select` | Text used for the initial empty option. |
| `value` | `''` | Initial selected value before `old()` resolution. |
| `validation_message` | `null` | Custom fallback validation message. |

## Behavior and Notes

The selected value is resolved with `old(name, value)`.

The `options` map is expected as `value => text`.

The first option always has an empty value.

## Usage

```twig
{% include 'components/form/select.twig' with {
    name: 'status',
    label: 'Status',
    options: {
        draft: 'Draft',
        published: 'Published'
    },
    placeholder: 'Choose a status',
    required: true
} %}
```
