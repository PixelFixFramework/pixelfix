# Breadcrumb

Renders a Bootstrap breadcrumb trail from an ordered collection of items.

**Component:** `components/navigation/breadcrumb.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `items` | `[]` | Ordered breadcrumb item collection. |

---

## Breadcrumb Item

Each item must provide:

| Property | Description |
|---|---|
| `label` | Text displayed for the breadcrumb. |
| `url` | URL used for non-final breadcrumb items. |

The final item is rendered as the current page and is not linked.

---

# Usage

```twig
{% set items = [
    {
        label: 'Home',
        url: '/'
    },
    {
        label: 'Students',
        url: '/students'
    },
    {
        label: 'Details',
        url: '/students/1'
    }
] %}

{% include
    'components/navigation/breadcrumb.twig'
    with {
        items:
            items
    }
    only
%}
```
