# Validation Errors Component

Reads the current validation errors through `errors()` and displays them in a danger Alert.

**Component:** `feedback/validation-errors.twig`

## Behavior and Notes

No component parameters are defined.

The `errors()` helper is called internally.

Each field is rendered with its field name in bold followed by its messages.

Iterable messages are joined with `, `; non-iterable values are rendered directly.

The resulting content is passed to `components/feedback/alert.twig` with `type: 'danger'`.

## Usage

```twig
{% include 'components/feedback/validation-errors.twig' %}
```
