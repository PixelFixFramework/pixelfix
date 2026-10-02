# Checkbox

> **Component:** `components/form/checkbox.twig`

## Purpose

Renders a Bootstrap checkbox with optional custom label HTML, validation state, old-value resolution and required/disabled states.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``name`` | Required | `—` | Checkbox name and id. |
| ``label`` | Optional | `''` | Plain-text label. |
| ``label_html`` | Optional | `null` | Raw HTML label content. Used instead of `label` when not null. |
| ``value`` | Optional | `1` | Submitted checkbox value. |
| ``required`` | Optional | `false` | Adds required. |
| ``checked`` | Optional | `false` | Initial checked state. |
| ``class`` | Optional | `''` | Additional input classes. |
| ``disabled`` | Optional | `false` | Adds disabled. |
| ``validation_message`` | Optional | `Auto-generated` | Fallback validation message. |


## Behavior

The checked state is resolved from `old(name, checked ? value : '')`. A field is considered checked when the old value equals the configured value or boolean `true`. Validation uses `errors()` and `has_error()`.

## Example

```twig
{% include 'components/form/checkbox.twig' with {
    name: 'terms',
    label_html: 'I agree to the <a href="/terms">Terms</a>.',
    required: true
} %}
```

## Usage

Use `label_html` when the label must contain a link or other trusted markup. Otherwise prefer the safer plain `label` value.

## Notes

Both `label_html` and input validation content are rendered as raw HTML where the component explicitly uses `|raw`; supply trusted markup.

## Related Components

- `components/auth/register.twig`
- `components/form/radio.twig`
