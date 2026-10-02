# Validation Errors

> **Component:** `components/feedback/validation-errors.twig`

## Purpose

Reads the framework validation error bag and renders all field messages as a danger alert.

## API / Properties

This component declares **no configurable component properties**. It reads `errors()` and builds a list where each field name is shown in bold followed by its messages.

## Behavior

When there are no validation errors, the component renders nothing. When an error value is iterable, its messages are joined with `, `.

## Example

```twig
{% include 'components/feedback/validation-errors.twig' %}
```

## Usage

Place this component near the top of a form page when you want a single summary of all validation errors.

## Notes

The component depends on the framework `errors()` helper.

## Related Components

- `components/feedback/alert.twig`
- `components/form/input.twig`
