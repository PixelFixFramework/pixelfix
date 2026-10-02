# Floating Input Component

Renders a Bootstrap floating-label text input with automatic validation state and optional autocomplete.

**Component:** `floating/input.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `type` | `text` | HTML input type. |
| `name` | Required | Input name/id. |
| `label` | `''` | Floating label text. |
| `required` | `false` | Adds the HTML `required` attribute and an empty danger marker in the label. |
| `validation_message` | Contextual default | Custom validation message shown when there is no current field error. |
| `autocomplete` | `null` | Autocomplete value. When omitted, the component infers `email`, `current-password`, `name`, or `username` for matching fields. |

## Behavior and Notes

The value is taken from `old(name)`; there is no separate `value` parameter.

Password inputs deliberately render an empty value attribute instead of repopulating a password.

The component calls `has_error(name)` and `error(name)`.

Unsupported or missing autocomplete inference leaves the autocomplete attribute unset.

Validation state is `is-invalid` when the field has an error and `is-valid` when an old value is present without an error.

## Usage

```twig
{% include 'components/floating/input.twig' with {
    type: 'email',
    name: 'email',
    label: 'Email',
    required: true,
    autocomplete: 'email'
} %}
```
