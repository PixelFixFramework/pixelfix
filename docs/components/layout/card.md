# Card

Renders a Bootstrap card with optional title, subtitle, content, footer, and additional classes.

**Component:** `components/layout/card.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `title` | `null` | Optional card title. |
| `subtitle` | `null` | Optional card subtitle. |
| `content` | `''` | Card body content. |
| `footer` | `null` | Optional footer content. |
| `class` | `''` | Additional card CSS classes. |

---

# Usage

```twig
{% include
    'components/layout/card.twig'
    with {
        title:
            'Profile',

        subtitle:
            'Account details',

        content:
            '<p>John Doe</p>',

        footer:
            '<a href="/profile">View Profile</a>',

        class:
            'shadow-sm'
    }
    only
%}
```
