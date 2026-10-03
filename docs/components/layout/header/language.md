# Language Header Item

Renders the language selection dropdown in the application header.

**Component:** `components/layout/header/language.twig`

---

## Parameters

This component does not accept explicit parameters.

The current implementation provides fixed language entries for English,
Spanish, French, German, and Arabic.

---

# Usage

```twig
{% include
    'components/layout/header/language.twig'
%}
```

---

## Current Languages

The component currently renders:

| Language | Code |
|---|---|
| English | `en` |
| Español | `es` |
| Français | `fr` |
| Deutsch | `de` |
| العربية | `ar` |

The English entry is marked as the active language in the current template.
