# PixelFix Offcanvas Component

Renders an accessible Bootstrap offcanvas panel with configurable placement, backdrop, body scrolling, keyboard dismissal, optional header/footer areas, custom partials, and trusted or escaped content.

**Component:** `components/navigation/offcanvas.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `id` | `pixelfix-offcanvas` | Offcanvas ID. Supply a unique ID when rendering multiple panels on a page. |
| `title` | `Menu` | Optional title, escaped by Twig. |
| `title_tag` | `h5` | Heading level `h1`–`h6`; invalid values fall back to `h5`. |
| `title_id` | `id` + `Label` | ID of the title heading and default `aria-labelledby` target when the title is shown. |
| `content` | `''` | Offcanvas body content. Trusted HTML is rendered by default for compatibility; set `escape_content: true` for plain text. |
| `footer` | `null` | Optional footer. Trusted HTML is rendered by default; set `escape_footer: true` for plain text. |
| `placement` | `start` | Panel placement: `start`, `end`, `top` or `bottom`. Unknown values fall back to `start`. |
| `backdrop` | `true` | Controls whether Bootstrap displays a backdrop. |
| `scroll` | `false` | Controls whether body scrolling is allowed while the offcanvas is open. |
| `keyboard` | `true` | Controls Escape-key dismissal through `data-bs-keyboard`. |
| `show` | `true` | When `false`, renders nothing. |
| `show_header` | `true` | When `false`, omits the entire header, including its title and close button. |
| `show_title` | `true` | Shows/hides the built-in title. When hidden, provide `aria_label` or `aria_labelledby` to name the offcanvas accessibly. |
| `show_close_button` | `true` | Shows/hides the built-in close button. |
| `close_label` | `Close` | Accessible label on the close button. |
| `show_body` | `true` | When `false`, omits the `.offcanvas-body` wrapper and its content. |
| `show_footer` | Automatic | Footer appears for non-empty `footer` or a configured `footer_partial`. Set `false` to suppress it. |
| `header_partial` | `''` | Replaces the complete default header. Receives the title, title ID/tag/classes and close-button settings as `offcanvas*` variables. |
| `body_partial` | `''` | Replaces the content inside `.offcanvas-body`. `content_partial` is accepted as an alias. Receives `offcanvasId`, `offcanvasTitle`, `offcanvasContent` and `offcanvasFooter`. |
| `footer_partial` | `''` | Replaces the complete footer area, including its wrapper. Receives `offcanvasId`, `offcanvasTitle`, `offcanvasContent` and `offcanvasFooter`. |
| `escape_content` | `false` | Escapes `content` instead of rendering trusted HTML. Does not change rendering inside `body_partial`. |
| `escape_footer` | `false` | Escapes `footer` instead of rendering trusted HTML. Does not change rendering inside `footer_partial`. |
| `class` | `''` | Additional classes on the root `.offcanvas`. |
| `header_class` | `''` | Additional classes on the default `.offcanvas-header`. |
| `title_class` | `''` | Additional classes on the title heading. |
| `body_class` | `''` | Additional classes on `.offcanvas-body`. |
| `footer_class` | `''` | Additional classes on the default `.offcanvas-footer`. |
| `close_button_class` | `''` | Additional classes on the built-in close button. |
| `body_id` | `''` | Optional ID for `.offcanvas-body`; can be referenced by `aria_describedby`. |
| `tabindex` | `-1` | Root element tabindex. |
| `role` | `dialog` | Role on the root element. |
| `aria_label` | `''` | Optional accessible name, especially useful when the title is hidden. |
| `aria_labelledby` | Title ID when shown | Explicit ID of the element that labels the offcanvas. |
| `aria_describedby` | `''` | Optional ID of an element describing the offcanvas. |
| `aria_hidden` | `true` | Initial `aria-hidden` state. Bootstrap updates visibility state when showing or hiding the panel. |
| `aria_modal` | Not rendered | Optional explicit `aria-modal` value. By default Bootstrap manages modal state during the offcanvas lifecycle. |

---

## Minimal usage

```twig
{% include
    'components/navigation/offcanvas.twig'
%}
```

## Typical usage

```twig
{% include
    'components/navigation/offcanvas.twig'
    with {
        id:
            'mobile-menu',

        title:
            'Navigation',

        content:
            '<nav>...</nav>',

        placement:
            'start',

        backdrop:
            true,

        scroll:
            false,

        keyboard:
            true,
    }
    only
%}
```

## Placement

Supported values are `start`, `end`, `top` and `bottom`. Unknown values use `start`.

## Escaped plain-text content

```twig
{% include
    'components/navigation/offcanvas.twig'
    with {
        id:
            'announcement-panel',

        title:
            'Announcement',

        content:
            user_supplied_message,

        escape_content:
            true,

        footer:
            user_supplied_note,

        escape_footer:
            true,
    }
    only
%}
```

**Security:** The legacy `content` and `footer` parameters intentionally retain their trusted-HTML defaults for compatibility. Do not pass untrusted values through those parameters without enabling the appropriate escaping option. For richer dynamic markup, use application-authored Twig partials and escape untrusted values within the partial.

## Body partial

```twig
{% include
    'components/navigation/offcanvas.twig'
    with {
        id:
            'mobile-navigation',

        title:
            'Navigation',

        body_partial:
            'navigation/partials/offcanvas-body.twig',
    }
    only
%}
```

The body partial replaces only the content inside `.offcanvas-body` and receives `offcanvasId`, `offcanvasTitle`, `offcanvasContent` and `offcanvasFooter`.

## Header and footer partials

```twig
{% include
    'components/navigation/offcanvas.twig'
    with {
        id:
            'custom-panel',

        title:
            'Custom Panel',

        header_partial:
            'offcanvas/partials/custom-header.twig',

        footer_partial:
            'offcanvas/partials/custom-footer.twig',
    }
    only
%}
```

A header partial replaces the complete header and receives `offcanvasId`, `offcanvasTitle`, `offcanvasTitleId`, `offcanvasTitleTag`, `offcanvasTitleClass`, `offcanvasShowTitle`, `offcanvasShowCloseButton`, `offcanvasCloseLabel` and `offcanvasCloseButtonClass`. A footer partial replaces the complete footer area and owns its wrapper and styling.

## Accessibility and options

```twig
{% include
    'components/navigation/offcanvas.twig'
    with {
        id:
            'account-panel',

        title:
            'Account details',

        title_tag:
            'h2',

        aria_label:
            'Account navigation panel',

        aria_describedby:
            'account-panel-help',

        backdrop:
            false,

        scroll:
            true,

        keyboard:
            false,
    }
    only
%}
```

Bootstrap manages focus, backdrop interaction and the live `aria-hidden`/modal state when the panel opens and closes. Keep the `data-bs-*` attributes intact when customizing the markup.
