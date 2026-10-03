# Footer

Renders the application footer with configurable company identity, URL, right-side content, and container class.

**Component:** `components/layout/footer.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `footer_company_name` | `config('app.name')` | Company or application name. |
| `footer_company_url` | `#` | URL used by the company name. |
| `footer_right` | `null` | Optional right-side footer content. |
| `container` | `container-fluid` | Bootstrap container class. |

---

# Usage

```twig
{% include
    'components/layout/footer.twig'
    with {
        footer_company_name:
            config('app.name'),

        footer_company_url:
            route('home'),

        footer_right:
            'Version 0.1.16',

        container:
            'container'
    }
    only
%}
```

---

## Current Year

The component obtains the current year from Twig's `now` date value. No
parameter is required for the year.
