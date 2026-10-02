# Input Group

> **Component:** `components/form/input-group.twig`

## Purpose

Renders a Bootstrap input-group control with a label, optional icon on either side, old-value handling and validation.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``type`` | Optional | `text` | HTML input type. |
| ``name`` | Required | `—` | Input name and id. |
| ``label`` | Optional | `''` | Visible label text. |
| ``label_class`` | Optional | `form-label` | Label class. |
| ``placeholder`` | Optional | `''` | Placeholder. |
| ``required`` | Optional | `false` | Adds required. |
| ``icon`` | Optional | `null` | Raw icon markup. |
| ``icon_position`` | Optional | `start` | Use `start` or `end`. |
| ``value`` | Optional | `''` | Fallback value used by `old()`. |
| ``class`` | Optional | `''` | Additional input classes. |
| ``maxlength`` | Optional | `null` | Maximum input length. |
| ``autofocus`` | Optional | `false` | Adds autofocus. |
| ``disabled`` | Optional | `false` | Adds disabled. |
| ``readonly`` | Optional | `false` | Adds readonly. |
| ``validation_message`` | Optional | `Auto-generated` | Fallback validation message. |
| ``autocomplete`` | Optional | `null` | Explicit autocomplete value; inferred for common field names/types. |


## Behavior

The component checks `errors()[name]` and `has_error(name)` and resolves a prior value with `old(name, value)`. Password inputs do not reuse a previous value. Autocomplete is inferred for email, password, name/full_name and username when not explicitly supplied. The component wraps the control in a `.mb-3` container.

## Example

```twig
{% include 'components/form/input-group.twig' with {
    type: 'email',
    name: 'email',
    label: 'Email',
    icon: '<i class="bi bi-envelope"></i>',
    icon_position: 'end',
    required: true,
    autocomplete: 'email'
} %}
```

## Usage

Use when an input needs Bootstrap's input-group presentation, particularly auth or icon-enhanced controls.

## Notes

Unlike `forms/input.twig`, the `icon` value is expected to contain the icon HTML because the component explicitly renders it with `|raw`.

## Related Components

- `components/form/input.twig`
- `components/auth/login.twig`
- `components/auth/register.twig`
