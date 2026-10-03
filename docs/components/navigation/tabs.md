# Tabs

Renders Bootstrap tabs and their associated tab panels from a collection.

**Component:** `components/navigation/tabs.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `id` | `tabs` | Base id used for tab and panel identifiers. |
| `tabs` | `[]` | Tab definition collection. |
| `style` | `tabs` | Navigation style. Use `tabs` or `pills`. |

---

## Tab Object

Each tab may contain:

| Property | Default | Description |
|---|---|---|
| `id` | Required | Unique tab identifier. |
| `label` | Required | Tab label. |
| `active` | `false` | Determines whether the tab is initially active. |
| `icon` | — | Raw icon markup rendered before the label. |
| `content` | Required | Raw HTML content rendered inside the tab panel. |

---

# Usage

```twig
{% set tabs = [
    {
        id: 'profile',
        label: 'Profile',
        active: true,
        icon: '<i class="bi bi-person me-1"></i>',
        content: '<p>Profile information.</p>'
    },
    {
        id: 'settings',
        label: 'Settings',
        content: '<p>Account settings.</p>'
    }
] %}

{% include
    'components/navigation/tabs.twig'
    with {
        id:
            'account-tabs',

        tabs:
            tabs,

        style:
            'tabs'
    }
    only
%}
```

---

## Pills

Set `style` to `pills` to render Bootstrap pill navigation.

```twig
{% include
    'components/navigation/tabs.twig'
    with {
        id:
            'account-tabs',

        tabs:
            tabs,

        style:
            'pills'
    }
    only
%}
```
