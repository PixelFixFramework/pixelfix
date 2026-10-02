# Radio

> **Component:** `components/form/radio.twig`

## Purpose

Renders a group of Bootstrap radio inputs from an associative options array, with optional inline layout and validation.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``name`` | Required | `—` | Shared radio group name. |
| ``label`` | Optional | `''` | Group label. |
| ``options`` | Optional | `{}` | Associative array of option value => option text. |
| ``inline`` | Optional | `false` | Renders each option as `form-check-inline`. |
| ``required`` | Optional | `false` | Adds required to each radio input. |
| ``value`` | Optional | `''` | Fallback selected value used by `old()`. |
| ``class`` | Optional | `''` | Additional input classes. |
| ``disabled`` | Optional | `false` | Disables all options. |


## Behavior

Each option receives an id of `name_optionValue`. The selected value is resolved with `old(name, value)`. Validation uses `has_error(name)` and `error(name)`.

## Example

```twig
{% include 'components/form/radio.twig' with {
    name: 'gender',
    label: 'Gender',
    options: {
        'male': 'Male',
        'female': 'Female'
    },
    inline: true,
    required: true
} %}
```

## Usage

Use for a small, mutually exclusive set of choices. Keep the same `name` for the entire group.

## Related Components

- `components/form/checkbox.twig`
- `components/form/select.twig`
