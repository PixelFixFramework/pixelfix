# Header

Provides the base PixelFix application header structure, including the default
sidebar toggle and the `header_start`, `header_center`, and `header_end` Twig
extension blocks.

**Component:** `components/layout/header.twig`

---

## Parameters

| Parameter | Default | Purpose |
|---|---|---|
| `header_id` | `null` | Optional ID for the outer `<header>`. |
| `header_class` | `pixelfix-header` | CSS classes for the outer header. |
| `nav_id` | `null` | Optional ID for the navigation element. |
| `nav_class` | `pixelfix-navbar` | CSS classes for the navigation element. |
| `nav_label` | `Main navigation` | Accessible name for the navigation landmark. |
| `container_class` | `pixelfix-navbar-container` | CSS classes for the navbar container. |
| `start_nav_class` | `pixelfix-navbar-nav pixelfix-navbar-start` | Classes for the start navigation list. |
| `end_nav_class` | `pixelfix-navbar-nav pixelfix-navbar-end ms-auto` | Classes for the end navigation list. |
| `show_sidebar_toggle` | `true` | Shows or hides the default sidebar toggle. Explicit `false` is respected. `sidebar_toggle_show` is an alias. |
| `sidebar_toggle_id` | `null` | Optional ID for the sidebar toggle button. |
| `sidebar_toggle_item_class` | `pixelfix-nav-item` | CSS classes for the toggle's list item. |
| `sidebar_toggle_class` | `pixelfix-nav-link` | CSS classes for the toggle button. `control_class` and `link_class` are fallback aliases. |
| `sidebar_toggle_label` | `Toggle sidebar` | Accessible label for the toggle button. |
| `sidebar_toggle_title` | Same as the label | Tooltip title for the toggle button. |
| `sidebar_toggle_icon_class` | `bi bi-list` | CSS classes for the toggle icon. |
| `sidebar_toggle_controls` | `null` | Optional ID of the sidebar controlled by this button. If omitted, `sidebar.js` supplies the sidebar ID during initialization. |

Class and attribute values are escaped by Twig. The visibility flag checks an
explicitly supplied `false` rather than treating it as an absent value.

---

## Basic usage

```twig
{% embed 'components/layout/header.twig' %}

    {% block header_start %}

        {% include
            'components/layout/header/live-preview.twig'
        %}

    {% endblock %}

    {% block header_end %}

        {% include
            'components/layout/header/search.twig'
        %}

    {% endblock %}

{% endembed %}
```

## Customizing the base header

```twig
{% embed
    'components/layout/header.twig'
    with {
        header_id: 'application-header',
        nav_id: 'main-navigation',
        nav_label: 'Application navigation',
        show_sidebar_toggle: true,
        sidebar_toggle_id: 'sidebar-toggle',
        sidebar_toggle_label: 'Open or close sidebar',
        sidebar_toggle_title: 'Toggle navigation sidebar',
        sidebar_toggle_controls: 'application-sidebar',
        sidebar_toggle_icon_class: 'bi bi-list',
    }
%}

    {% block header_start %}
        {% include 'components/layout/header/live-preview.twig' %}
    {% endblock %}

    {% block header_end %}
        {% include 'components/layout/header/search.twig' %}
    {% endblock %}

{% endembed %}
```

To hide only the sidebar control while retaining custom header content, use
`show_sidebar_toggle: false`. The extension blocks continue to render.

---

## Header blocks

| Block | Purpose |
|---|---|
| `header_start` | Content rendered at the start of the navigation, after the sidebar toggle. |
| `header_center` | Optional content rendered between the start and end navigation lists. |
| `header_end` | Content rendered at the end of the navigation. |

The header is designed to be extended with Twig `embed`; the block names are
preserved for existing applications.

---

## JavaScript integration

The sidebar toggle uses a semantic `<button type="button">` and preserves
`data-pixelfix-toggle="sidebar"`, which is the selector consumed by
`public/assets/js/sidebar.js`. The script updates `aria-expanded` and, when
`aria-controls` is not configured, supplies it from the sidebar element's ID.
