# Floating Select

> **Component:** `components/floating/select.twig`

## Purpose

Renders a Bootstrap floating-label `<select>` with a placeholder option, old-value selection and validation state.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``name`` | Required | `—` | Select name and id. No default is declared. |
| ``label`` | Optional | `''` | Floating label. |
| ``required`` | Optional | `false` | Adds the required attribute. |
| ``options`` | Optional | `{}` | Associative array of option value => option text. |
| ``placeholder`` | Optional | `Select` | Placeholder option text. |


## Behavior

The first option always uses an empty value. Existing input is read with `old(name)`. Validation state is based on `has_error(name)` and the component renders either `error(name)` or an automatically generated validation message.

## Example

```twig
{% include 'components/floating/select.twig' with {
    name: 'programme',
    label: 'Programme',
    options: {
        'ict': 'Information Technology',
        'business': 'Business Studies'
    },
    required: true
} %}
```

## Usage

Use for compact forms where the floating-label layout is preferred.

## Related Components

- `components/floating/input.twig`
- `components/form/select.twig`
