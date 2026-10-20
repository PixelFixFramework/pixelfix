# Search Header Item

Renders a desktop GET search form and a small-screen search link inside the PixelFix application header. The controls are omitted until a destination is configured, so a fresh application does not emit an empty or `#` action/link.

**Component:** `components/layout/header/search.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `search_url` | `''` | Direct URL used by the desktop form and small-screen link. Accepts `search_href` as an alias. |
| `search_route` | `''` | Named route used to generate the destination. Takes precedence over `search_url`. |
| `search_route_parameters` | `[]` | Parameters passed to `search_route`. |
| `search_url_route` | `''` | Alias for `search_route`. |
| `search_url_route_parameters` | `[]` | Alias for `search_route_parameters`. |
| `search_route_name` | `''` | Alias for `search_route`. |
| `search_query_name` | `'query'` | Name of the search input submitted by the desktop GET form. |
| `search_placeholder` | `'Search...'` | Placeholder displayed in the desktop search input. |
| `search_aria_label` | `'Search'` | Accessible label for the input and small-screen link. |
| `search_title` | `'Search'` | Title attribute on the small-screen link. |
| `icon` | `'search'` | Bootstrap Icon name or full Bootstrap Icon class. Set to `''` to omit the icon. |
| `show` | `true` | Whether to render the search controls. Explicit `false` is respected. A destination is still required. |
| `show_desktop` | `true` | Whether to render the desktop form. |
| `show_mobile` | `true` | Whether to render the small-screen link. |
| `desktop_item_class` | `'pixelfix-nav-item d-none d-md-flex'` | Classes applied to the desktop list item. |
| `mobile_item_class` | `'pixelfix-nav-item d-md-none'` | Classes applied to the small-screen list item. |
| `form_class` | `'pixelfix-header-search'` | Classes applied to the desktop form. |
| `input_class` | `'pixelfix-header-search-input'` | Classes applied to the desktop search input. |
| `desktop_icon_class` | `'pixelfix-header-search-icon'` | Additional class applied to the desktop icon. |
| `mobile_link_class` | `'pixelfix-nav-link'` | Classes applied to the small-screen link. |
| `mobile_icon_class` | `''` | Additional class applied to the small-screen icon. |
| `search_input_id` | `''` | Optional ID for the desktop search input. |
| `mobile_id` | `''` | Optional ID for the small-screen search link. |
| `target` | `''` | Optional target applied to the small-screen link and desktop form. |
| `rel` | `''` | Optional relationship for the small-screen link; defaults to `noopener noreferrer` when `target` is `_blank`. |

---

## Usage

### Direct URL

```twig
{% include
    'components/layout/header/search.twig'
    with {
        search_url:
            '/search',
    }
    only
%}
```

The desktop form sends a GET request to `/search` using the default query field name `query`. The small-screen control links to the same URL.

### Named route

```twig
{% include
    'components/layout/header/search.twig'
    with {
        search_route:
            'search.index',

        search_route_parameters: {
            scope:
                'all',
        },
    }
    only
%}
```

The named route must be registered by the application. PixelFix generates the URL with `route()` and passes the configured parameter array. If both `search_route` and `search_url` are supplied, the named route takes precedence. The desktop query string is then appended through the normal GET form submission.

### Customize the search field

```twig
{% include
    'components/layout/header/search.twig'
    with {
        search_url:
            '/search',

        search_query_name:
            'q',

        search_placeholder:
            'Search the site...',

        search_aria_label:
            'Search the site',

        icon:
            'search',
    }
    only
%}
```

### Show only one layout

```twig
{% include
    'components/layout/header/search.twig'
    with {
        search_route:
            'search.index',

        show_mobile:
            false,
    }
    only
%}
```

All Twig hash entries use trailing commas, including the final entry, so the examples can be extended without modifying the preceding entry.
