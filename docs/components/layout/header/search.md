# Search Header Item

Renders the desktop search form and the small-screen search link in the application header.

**Component:** `components/layout/header/search.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `search_url` | `#` | URL used by the desktop search form and small-screen search link. |

---

# Usage

```twig
{% include
    'components/layout/header/search.twig'
    with {
        search_url:
            route('search')
    }
    only
%}
```

---

## Search Request

The desktop search form submits using `GET` and uses the field name `query`.

The small-screen control links directly to the supplied `search_url`.
