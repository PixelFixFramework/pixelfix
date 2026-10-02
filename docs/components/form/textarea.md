# Textarea

> **Component:** `components/form/textarea.twig`

## Purpose

Renders a standard Bootstrap textarea with optional label, rows, placeholder, required state, custom classes and validation.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``name`` | Required | `—` | Textarea name and id. |
| ``label`` | Optional | `''` | Visible label. |
| ``rows`` | Optional | `4` | Number of textarea rows. |
| ``placeholder`` | Optional | `''` | Placeholder. |
| ``required`` | Optional | `false` | Adds required. |
| ``class`` | Optional | `''` | Additional classes. |
| ``value`` | Optional | `''` | Fallback value used by `old()`. |
| ``validation_message`` | Optional | `Auto-generated` | Fallback validation message. |


## Behavior

The displayed value comes from `old(name, value)`. When field errors exist, the first error is displayed. The component adds `is-invalid` to the textarea.

## Example

```twig
{% include 'components/form/textarea.twig' with {
    name: 'description',
    label: 'Description',
    rows: 6,
    placeholder: 'Describe the task',
    required: true
} %}
```

## Usage

Use for multi-line text fields such as descriptions, comments and notes.

## Related Components

- `components/floating/textarea.twig`
