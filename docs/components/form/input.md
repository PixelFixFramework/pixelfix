# Input Component

Renders a simple form input with an optional label, standard input attributes, old-value handling, and validation feedback.

**Component:** `form/input.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `type` | `text` | HTML input type. |
| `name` | `''` | Input name/id. |
| `label` | `null` | Optional label. |
| `placeholder` | `''` | Input placeholder. |
| `required` | `false` | Adds the HTML `required` attribute. |
| `class` | `''` | Additional input classes. |
| `maxlength` | `null` | Optional HTML `maxlength`. |
| `autofocus` | `false` | Adds the HTML `autofocus` attribute. |
| `value` | `''` | Initial value before `old()` resolution. |
| `validationMessage` | `null` | Custom fallback validation message. Note the exact camelCase parameter name. |

## Behavior and Notes

The component uses `validationMessage`, not `validation_message`.

The field value is resolved using `old(name, value)`.

Password inputs render an empty value attribute and are not repopulated.

The component uses the first value in `errors()[name]` for validation feedback when errors exist.

## Usage

```twig
{% include 'components/form/input.twig' with {
    type: 'text',
    name: 'title',
    label: 'Title',
    placeholder: 'Enter title',
    value: '',
    required: true
} %}
```
