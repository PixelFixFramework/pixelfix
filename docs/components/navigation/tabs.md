# Tabs

Renders Bootstrap tabs or pills and their associated tab panels from a collection. The component keeps the tab triggers and panels linked by generated IDs and uses Bootstrap's `tab` or `pill` toggle integration as appropriate.

**Component:** `components/navigation/tabs.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `id` | `tabs` | Base ID used for the tab navigation, trigger IDs and panel IDs. Use a unique value when rendering multiple tab groups. |
| `tabs` | `[]` | Collection of tab definitions. |
| `style` | `tabs` | Navigation style. Accepts `tabs` or `pills`; invalid values fall back to `tabs`. |
| `active_tab_id` | `null` | Optional tab ID that overrides the per-tab `active` flags. |
| `show` | `true` | Set to `false` to hide the complete component. |
| `fade` | `true` | Controls Bootstrap's `fade` and `show` classes. Explicit `false` is respected. |
| `orientation` | `horizontal` | Tab-list orientation: `horizontal` or `vertical`. |
| `vertical` | `false` | Alias for `orientation: 'vertical'` when `orientation` is not supplied. |
| `fill` | `false` | Adds Bootstrap's `nav-fill` class. |
| `justified` | `false` | Adds Bootstrap's `nav-justified` class. |
| `aria_label` | `Tabs navigation` | Accessible name for the tab list. |
| `nav_class` | `''` | Additional tab-list classes. |
| `tab_item_class` | `''` | Additional classes for each navigation list item. |
| `tab_button_class` | `''` | Additional classes for each tab button. |
| `tab_panel_class` | `''` | Additional classes for each panel. |
| `content_class` | `''` | Additional classes for the panel container. |
| `wrapper_id` | `null` | Optional ID for the outer wrapper. |
| `wrapper_class` | `''` | Additional classes for the outer wrapper. |
| `active_class` | `active` | Class used on the selected tab button and its panel. |
| `disabled_class` | `disabled` | Class used on disabled tab buttons. |
| `escape_content` | `false` | Renders tab content as escaped plain text instead of trusted HTML. Per-tab `escape_content` overrides this setting. |
| `escape_icons` | `false` | Escapes raw icon strings. Per-tab `escape_icon` overrides this setting. |

## Tab object

Each tab may contain:

| Property | Default | Description |
|---|---|---|
| `id` | Generated from position | Stable identifier used to link the tab button and panel. Prefer explicit, selector-safe IDs such as `profile` or `settings`. |
| `label` | `''` | Visible, escaped tab label. |
| `active` | `false` | Marks this tab as initially selected unless `active_tab_id` is supplied. Set only one tab active. |
| `disabled` | `false` | Disables the tab button and prevents it from being selected by the initial state. |
| `title` | — | Optional title attribute on the tab button. |
| `icon` | — | Trusted raw icon markup rendered before the label. Enable `escape_icons` or set `escape_icon: true` for plain text. |
| `icon_class` | — | CSS classes for a generated decorative `<i>` icon when no raw icon or icon partial is supplied. |
| `icon_partial` | — | Optional Twig partial that renders the icon. Receives `tab`, `tabsId`, `tabId` and `panelId`. |
| `content` | `''` | Trusted HTML rendered inside the tab panel by default. |
| `escape_content` | Component setting | When set, escapes this tab's content as plain text. |
| `content_partial` | — | Optional Twig partial for the panel. Receives `tab`, `tabsId`, `tabId`, `panelId` and `tabIsActive`. |
| `item_class` | `''` | Additional classes on this tab's `<li>`. |
| `button_class` | `''` | Additional classes on this tab button. |
| `panel_class` | `''` | Additional classes on this panel. |
| `panel_aria_label` | — | Optional accessible label for the panel. |

---

## Standard tabs

```twig
{% set tabs = [
    {
        id: 'profile',
        label: 'Profile',
        active: true,
        icon: '<i class="bi bi-person me-1" aria-hidden="true"></i>',
        content: '<p>Profile information.</p>',
    },
    {
        id: 'settings',
        label: 'Settings',
        icon_class: 'bi bi-gear me-1',
        content: '<p>Account settings.</p>',
    },
] %}

{% include
    'components/navigation/tabs.twig'
    with {
        id: 'account-tabs',
        tabs: tabs,
        style: 'tabs',
        aria_label: 'Account sections',
    }
    only
%}
```

## Pills and layout options

```twig
{% include
    'components/navigation/tabs.twig'
    with {
        id: 'account-tabs',
        tabs: tabs,
        style: 'pills',
        orientation: 'vertical',
        fill: false,
        justified: true,
        fade: false,
    }
    only
%}
```

## Choose the active tab by ID

```twig
{% include
    'components/navigation/tabs.twig'
    with {
        id: 'account-tabs',
        tabs: tabs,
        active_tab_id: 'settings',
    }
    only
%}
```

When `active_tab_id` is supplied, it takes precedence over each tab's `active` flag. Disabled tabs are never rendered as active. If neither `active_tab_id` nor an active tab is supplied, the component leaves all tabs inactive so the caller controls the initial selection explicitly.

## Content partials

```twig
{% include
    'components/navigation/tabs.twig'
    with {
        id: 'account-tabs',
        tabs: [
            {
                id: 'profile',
                label: 'Profile',
                active: true,
                content_partial: 'account/partials/profile-tab.twig',
            },
        ],
    }
    only
%}
```

The tab content partial receives the complete `tab` definition plus `tabsId`, `tabId`, `panelId` and `tabIsActive`. Application-authored partials should escape any untrusted variables they render.

## Plain-text content

```twig
{% include
    'components/navigation/tabs.twig'
    with {
        id: 'announcement-tabs',
        escape_content: true,
        tabs: [
            {
                id: 'updates',
                label: 'Updates',
                active: true,
                content: user_supplied_message,
            },
        ],
    }
    only
%}
```

## Compatibility and security

The legacy `icon` and `content` values continue to render as trusted HTML by default so existing templates remain compatible. Do not pass untrusted values through those properties without enabling the escaping options. Use `icon_class` for ordinary icon classes, or use a trusted application-authored partial for richer markup.

The component produces Bootstrap's tab markup and data attributes. Include Bootstrap's JavaScript for interactive tab switching. IDs should be unique within the document and should use selector-safe characters.
