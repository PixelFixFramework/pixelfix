# Checkbox Component

Renders a checkbox with optional HTML label content and validation feedback.

**Component:** `form/checkbox.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `name` | Required | Checkbox name/id. |
| `label` | `''` | Plain label text. |
| `label_html` | `null` | Optional raw HTML used instead of `label`. |
| `value` | `1` | Checkbox value. |
| `required` | `false` | Adds the HTML `required` attribute. |
| `checked` | `false` | Initial checked state. |
| `class` | `''` | Additional checkbox classes. |
| `disabled` | `false` | Adds the HTML `disabled` attribute. |
| `validation_message` | `null` | Custom fallback validation message. |

## Behavior and Notes

The checked state is resolved using `old(name, checked ? value : '')`.

A checkbox is considered checked when the resolved old value equals its value or is boolean `true`.

`label_html` is rendered with `|raw`; use only trusted HTML.

The component calls `errors()` and `has_error()` for validation.

## Usage

```twig
{% include 'components/form/checkbox.twig' with {
    name: 'remember',
    label: 'Remember Me',
    value: '1',
    checked: true
} %}
```
