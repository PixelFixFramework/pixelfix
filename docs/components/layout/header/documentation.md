# Documentation Header Item

Renders a Documentation link inside PixelFix's application header. The item is hidden until a destination is configured, so a fresh application does not display a dead `#` link.

**Component:** `components/layout/header/documentation.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `documentation_url` | `''` | Direct URL to the documentation page. |
| `documentation_route` | `''` | Named route to generate the documentation URL. Takes precedence over `documentation_url` when supplied. |
| `documentation_route_parameters` | `[]` | Parameters passed to the named route. |
| `text` | `'Documentation'` | Visible link text. |
| `icon` | `'book'` | Bootstrap Icon name or complete Bootstrap Icon class. Set to `''` to omit the icon. |
| `show` | `true` | Whether to render the item. The item still requires a destination. |
| `class` | `''` | Additional class appended to the link class. |
| `item_class` | `'pixelfix-nav-item d-none d-md-block'` | Classes applied to the list item. |
| `link_class` | `'pixelfix-nav-link'` | Base classes applied to the link. |
| `id` | `null` | Optional link ID. |
| `aria_label` | `null` | Optional accessible name for the link. |
| `title` | `null` | Optional link title. |
| `target` | `null` | Optional link target. |
| `rel` | `null` | Optional link relationship; defaults to `noopener noreferrer` for `_blank`. |
| `content_partial` | `''` | Optional partial that replaces the default icon and text. It receives `text`, `icon` and `icon_class`. |

---

## Usage

### Direct URL

```twig
{% include
    'components/layout/header/documentation.twig'
    with {
        documentation_url:
            '/docs',

        text:
            'Documentation',
    }
    only
%}
```

### Named route

Use this when your application has a registered documentation route:

```twig
{% include
    'components/layout/header/documentation.twig'
    with {
        documentation_route:
            'documentation.index',

        documentation_route_parameters: {
            section:
                'getting-started',
        },
    }
    only
%}
```

### Customization

```twig
{% include
    'components/layout/header/documentation.twig'
    with {
        documentation_url:
            '/docs',

        text:
            'Developer Guide',

        icon:
            'journal-bookmark-fill',

        target:
            '_blank',

        class:
            'fw-semibold',

        content_partial:
            'components/layout/header/partials/documentation-link.twig',
    }
    only
%}
```

Every key in a Twig hash ends with a comma, including the final key, so examples can be extended without modifying the preceding entry.
