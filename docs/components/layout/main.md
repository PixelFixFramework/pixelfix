# Main Content

Renders the application main content area with an optional page title, breadcrumb trail, configurable containers, accessibility attributes and trusted or escaped content.

**Component:** `components/layout/main.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `class` / `main_class` | `''` | Additional CSS classes applied to the main element. `main_class` takes precedence. |
| `id` / `main_id` | `pixelfix-main` | Main element ID. `main_id` takes precedence. |
| `role` | `''` | Optional ARIA role. The native `<main>` landmark is used by default. |
| `aria_label` | `''` | Optional accessible name for the main landmark. |
| `aria_labelledby` | `''` | ID of the element that labels the main landmark. |
| `aria_describedby` | `''` | ID of the element that describes the main landmark. |
| `title` | `null` | Optional page title. Escaped by Twig. |
| `title_tag` | `h1` | Page title heading. Only `h1` through `h6` are accepted; unsupported values fall back to `h1`. |
| `title_id` | `''` | Optional ID on the page title heading. |
| `title_class` | `''` | Additional CSS class on the page title heading. |
| `breadcrumbs` | `[]` | Breadcrumb collection rendered in the page header. |
| `content` | `''` | Main content. For backward compatibility, trusted HTML is rendered by default. Set `escape_content: true` to render it as escaped text. |
| `content_partial` / `main_content_partial` | `''` | Twig partial that replaces the embedded content. Receives `mainTitle`, `mainBreadcrumbs`, `mainContent`, `mainId`, `mainContainerClass` and `mainContentClass`. |
| `escape_content` | `false` | Renders `content` as escaped text instead of trusted HTML. This does not alter rendering inside a configured `content_partial`. |
| `container_class` | `''` | Additional class applied to both main containers, preserving existing behavior. |
| `header_container_class` | Value of `container_class` | Optional class override for the header container. |
| `content_container_class` | Value of `container_class` | Optional class override for the content container. |
| `content_class` | `''` | Additional CSS class on the main content wrapper. |
| `content_wrapper_class` | `''` | Additional CSS class on the main content wrapper. |
| `header_class` | `''` | Additional CSS class on the header wrapper. |
| `header_row_class` | `''` | Additional CSS class on the header row. |
| `header_title_class` | `''` | Additional CSS class on the title wrapper. |
| `header_breadcrumb_class` | `''` | Additional CSS class on the breadcrumb wrapper. |
| `show_header` | `true` | When `false`, suppresses the entire title/breadcrumb header. |
| `show_title` | `true` | When `false`, suppresses the page title. |
| `show_breadcrumbs` | `true` | When `false`, suppresses the breadcrumb trail. |
| `breadcrumb_aria_label` | `breadcrumb` | Accessible label for the breadcrumb navigation. |
| `breadcrumb_nav_id` | `''` | Optional ID for the breadcrumb `<nav>`. |
| `breadcrumb_nav_class` | `''` | Additional CSS class on the breadcrumb `<nav>`. |
| `breadcrumb_list_class` | `''` | Additional CSS class on the breadcrumb `<ol>`. |
| `breadcrumb_item_class` | `''` | Additional CSS class on each breadcrumb item. |
| `breadcrumb_active_class` | `active` | Additional class on the last breadcrumb item. |

---

## Breadcrumb object

Each breadcrumb item may contain:

| Property | Default | Description |
|---|---|---|
| `label` | `''` | Breadcrumb label, escaped by Twig. |
| `url` / `href` | `''` | Direct URL. |
| `route` | `''` | Named route passed to PixelFix's `route()` helper. When configured, it takes precedence over `url`/`href`. |
| `route_parameters` | `[]` | Parameter array passed to the named route. |
| `url_route` / `route_name` | `''` | Compatibility aliases for `route`. |
| `url_route_parameters` / `parameters` | `[]` | Compatibility aliases for `route_parameters`. |
| Final breadcrumb | — | Always rendered as current-page text with `aria-current="page"`, even if a URL or route is configured. |

Breadcrumb route names must exist in the application. When a named route is used, the component calls `route($routeName, $parameters)`.

---

## Minimal usage

```twig
{% include
    'components/layout/main.twig'
%}
```

## Typical usage

```twig
{% set breadcrumbs = [
    {
        label: 'Home',
        url: '/',
    },
    {
        label: 'Students',
        route: 'students.index',
        route_parameters: {
            status: 'active',
        },
    },
    {
        label: 'Details',
    },
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
            'py-4',
    }
    only
%}
```

## Plain-text content

Use `escape_content` when the content should be displayed as text rather than interpreted as HTML:

```twig
{% include
    'components/layout/main.twig'
    with {
        title:
            'Announcement',

        content:
            user_supplied_message,

        escape_content:
            true,
    }
    only
%}
```

**Security:** The legacy `content` parameter intentionally retains its trusted-HTML default for compatibility. Do not pass untrusted strings through it without enabling escaping. For richer dynamic markup, use an application-authored Twig partial and escape untrusted variables inside that partial.

## Content partial

Use `content_partial` when the main content area needs custom application-authored markup. The partial replaces only the content inside the inner main container. It receives `mainTitle`, `mainBreadcrumbs`, `mainContent`, `mainId`, `mainContainerClass` and `mainContentClass`.

```twig
{% include
    'components/layout/main.twig'
    with {
        title:
            'Student Summary',

        content_partial:
            'students/partials/main-content.twig',

        container_class:
            'container',
    }
    only
%}
```

## Accessibility and layout customization

```twig
{% include
    'components/layout/main.twig'
    with {
        id:
            'account-main',

        aria_label:
            'Account page content',

        title:
            'Account details',

        title_tag:
            'h1',

        title_id:
            'account-title',

        breadcrumb_aria_label:
            'Account navigation trail',

        header_container_class:
            'container',

        content_container_class:
            'container-lg',

        content_wrapper_class:
            'py-4',
    }
    only
%}
```

Choose heading levels and ARIA associations that fit the surrounding document. If `aria_labelledby` or `aria_describedby` is supplied, its referenced element should exist in the rendered page.
