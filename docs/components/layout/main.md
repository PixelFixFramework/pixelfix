# Main Content

Renders the application main content area with an optional title, breadcrumb trail, container classes, and raw content.

**Component:** `components/layout/main.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `class` | `''` | Additional CSS class applied to the main element. |
| `id` | `pixelfix-main` | Main element id. |
| `title` | `null` | Optional page title. |
| `breadcrumbs` | `[]` | Breadcrumb collection rendered in the page header. |
| `content` | `''` | Main content rendered as raw HTML. |
| `container_class` | `''` | Additional class applied to the main containers. |
| `content_class` | `''` | Additional class applied to the main content wrapper. |

---

## Breadcrumb Object

Each breadcrumb item may contain:

| Property | Default | Description |
|---|---|---|
| `label` | `''` | Breadcrumb label. |
| `url` | `null` | Link URL. The final breadcrumb is rendered without a link. |

---

# Usage

```twig
{% set breadcrumbs = [
    {
        label: 'Home',
        url: '/'
    },
    {
        label: 'Students',
        url: '/students'
    },
    {
        label: 'Details'
    }
] %}

{% include
    'components/layout/main.twig'
    with {
        id:
            'students-main',

        title:
            'Student Details',

        breadcrumbs:
            breadcrumbs,

        content:
            '<p>Student information goes here.</p>',

        container_class:
            'container',

        content_class:
            'py-4'
    }
    only
%}
```
