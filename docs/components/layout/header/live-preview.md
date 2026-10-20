# Live Preview Header Item

Renders a Live Preview link inside PixelFix's application header. The item is hidden until a destination is configured, so a fresh application does not display a dead `#` link.

**Component:** `components/layout/header/live-preview.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `live_preview_url` | `''` | Direct URL opened by the Live Preview item. |
| `live_preview_route` | `''` | Named route used to generate the destination. Takes precedence over `live_preview_url` when supplied. |
| `live_preview_route_parameters` | `[]` | Parameters passed to the named route. |
| `text` | `'Live preview'` | Visible link text. |
| `icon` | `'grid-1x2'` | Bootstrap Icon name or complete Bootstrap Icon class. Set to `''` to omit the icon. |
| `show` | `true` | Whether to render the item. The item still requires a destination. |
| `class` | `''` | Additional class appended to the link class. |
| `item_class` | `'pixelfix-nav-item d-none d-md-block'` | Classes applied to the list item. |
| `link_class` | `'pixelfix-nav-link'` | Base classes applied to the link. |
| `id` | `null` | Optional link ID. |
| `aria_label` | `null` | Optional accessible name for the link. |
| `title` | `null` | Optional link title. |
| `target` | `null` | Optional link target. |
| `rel` | `null` | Optional link relationship; defaults to `noopener noreferrer` for `_blank`. |
| `content_partial` | `''` | Optional partial replacing the default icon and text. It receives `text`, `icon` and `icon_class`. |

---

## Usage

### Direct URL

```twig
{% include
    'components/layout/header/live-preview.twig'
    with {
        live_preview_url:
            '/preview',

        text:
            'Live preview',
    }
    only
%}
```

### Named route

Use this when the application has a registered route for the preview page:

```twig
{% include
    'components/layout/header/live-preview.twig'
    with {
        live_preview_route:
            'preview.show',

        live_preview_route_parameters: {
            project:
                project.id,
        },
    }
    only
%}
```

When both `live_preview_route` and `live_preview_url` are provided, the named route takes precedence. Route names and parameters must correspond to routes registered by the application.

### Customization

```twig
{% include
    'components/layout/header/live-preview.twig'
    with {
        live_preview_url:
            '/preview',

        text:
            'Open live preview',

        icon:
            'eye',

        aria_label:
            'Open the live preview',

        target:
            '_blank',

        class:
            'fw-semibold',
    }
    only
%}
```

Every key in a Twig hash ends with a comma, including the final key, so examples can be extended without modifying the preceding entry.
