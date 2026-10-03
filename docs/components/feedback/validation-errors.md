# Validation Errors

Renders the current validation errors as a list grouped by field.

**Component:** `components/feedback/validation-errors.twig`

---

## Parameters

This component does not accept explicit parameters.

It reads validation errors using the framework `errors()` helper.

---

# Usage

```twig
{% include
    'components/feedback/validation-errors.twig'
%}
```

---

## Error Output

Each validation field is rendered with its field name followed by its first
available validation message.

The component renders nothing when there are no validation errors.
