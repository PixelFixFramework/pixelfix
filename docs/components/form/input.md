# Input

> **Component:** `components/form/input.twig`

## Purpose

Renders a standard Bootstrap form input with optional label, placeholder, required state, maxlength, autofocus, initial value and validation feedback.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``type`` | Optional | `text` | HTML input type. |
| ``name`` | Optional | `''` | Input name and id. |
| ``label`` | Optional | `null` | Optional label text. |
| ``placeholder`` | Optional | `''` | Placeholder. |
| ``required`` | Optional | `false` | Adds required. |
| ``class`` | Optional | `''` | Additional CSS classes. |
| ``maxlength`` | Optional | `null` | Maximum input length. |
| ``autofocus`` | Optional | `false` | Adds autofocus. |
| ``value`` | Optional | `''` | Fallback value passed to `old()`. |
| ``validationMessage`` | Optional | `null` | Custom fallback validation message; note the exact camelCase input name. |


## Behavior

The component reads `errors()[name]` and uses `old(name, value)` to resolve the displayed value. For password inputs it intentionally renders an empty value. Validation feedback shows the first field error when present.

## Example

```twig
{% include 'components/form/input.twig' with {
    type: 'text',
    name: 'title',
    label: 'Task Title',
    placeholder: 'Enter task title',
    required: true,
    maxlength: 150
} %}
```

## Usage

Use for ordinary form fields when no input-group icon presentation is required.

## Notes

The public validation input is named `validationMessage` in the current component source; it is not `validation_message`.

## Related Components

- `components/form/input-group.twig`
- `components/floating/input.twig`
