# Textarea Component

Renders a standard textarea with optional label, row count, placeholder, and validation feedback.

**Component:** `form/textarea.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | Required | Textarea name/id. |
| `label` | `''` | Optional label. |
| `rows` | `4` | HTML textarea row count. |
| `placeholder` | `''` | Textarea placeholder. |
| `required` | `false` | Adds the HTML `required` attribute. |
| `class` | `''` | Additional textarea classes. |
| `value` | `''` | Initial value before `old()` resolution. |
| `validation_message` | `null` | Custom fallback validation message. |

## Behavior and Notes

The value is resolved with `old(name, value)`.

## Usage

```twig
{% include 'components/form/textarea.twig' with {
    name: 'description',
    label: 'Description',
    rows: 6,
    placeholder: 'Enter a description'
} %}
```
