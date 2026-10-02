# Floating Input

> **Component:** `components/floating/input.twig`

## Purpose

Renders a Bootstrap floating-label input with framework-aware old-value and validation handling.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``type`` | Optional | `text` | HTML input type. |
| ``name`` | Required | `—` | Input name and id. No default is declared. |
| ``label`` | Optional | `''` | Floating label. |
| ``required`` | Optional | `false` | Adds the required attribute. |
| ``autocomplete`` | Optional | `null` | Explicit autocomplete value; inferred for common email/password/name/username fields. |


## Behavior

The component reads `has_error()`, `old()` and `error()`. It assigns `is-invalid` when an error exists and `is-valid` when a non-empty old value exists. Password inputs intentionally render an empty value.

## Example

```twig
{% include 'components/floating/input.twig' with {
    type: 'email',
    name: 'email',
    label: 'Email Address',
    required: true
} %}
```

## Usage

Use when you want Bootstrap's floating-label pattern without the separate visible label above the control.

## Notes

The source does not expose `placeholder`, `disabled`, `readonly`, `maxlength` or `class` inputs. The floating input uses the label as its placeholder.

## Related Components

- `components/floating/select.twig`
- `components/floating/textarea.twig`
- `components/form/input.twig`
