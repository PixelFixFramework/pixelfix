# Floating Textarea

> **Component:** `components/floating/textarea.twig`

## Purpose

Renders a Bootstrap floating-label `<textarea>` with framework-aware old-value and validation state.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``name`` | Required | `—` | Textarea name and id. |
| ``label`` | Optional | `''` | Floating label. |
| ``required`` | Optional | `false` | Adds the required attribute. |
| ``rows`` | Optional | `5` | Controls the component's calculated height. |
| ``validation_message`` | Optional | `Auto-generated` | Custom fallback validation message. |


## Behavior

The source uses `style="height: {{ rows * 30 }}px"` rather than the HTML `rows` attribute. Existing text is loaded with `old(name)` and validation uses `has_error()` / `error()`.

## Example

```twig
{% include 'components/floating/textarea.twig' with {
    name: 'description',
    label: 'Description',
    rows: 6,
    required: true
} %}
```

## Usage

Use when a multi-line field should use Bootstrap's floating-label presentation.

## Notes

The source requires the `name` input. The calculated height is based on the `rows` value.

## Related Components

- `components/form/textarea.twig`
