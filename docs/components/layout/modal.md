# PixelFix Modal Component

Renders an accessible Bootstrap modal with configurable size, scrolling, centering, backdrop and keyboard behavior, optional header/footer areas, custom partials, and trusted or escaped content.

**Component:** `components/layout/modal.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `id` | `pixelfix-modal` | Modal ID. Supply a unique ID when rendering more than one modal on a page. |
| `title` | `Modal` | Optional modal title. Escaped by Twig. |
| `title_tag` | `h5` | Heading level `h1`–`h6`; invalid values fall back to `h5`. |
| `title_id` | `id` + `Label` | ID of the title heading, used as the default `aria-labelledby` target when the title is shown. |
| `content` | `''` | Modal body content. Trusted HTML is rendered by default for compatibility; set `escape_content: true` for plain text. |
| `footer` | `null` | Optional modal footer. Trusted HTML is rendered by default; set `escape_footer: true` for plain text. |
| `size` | `null` | Supported size: `sm`, `lg`, `xl`, `fullscreen`, `fullscreen-sm-down`, `fullscreen-md-down`, `fullscreen-lg-down`, `fullscreen-xl-down` or `fullscreen-xxl-down`. Other values add no size class. |
| `scrollable` | `false` | Adds `modal-dialog-scrollable`. |
| `centered` | `false` | Adds `modal-dialog-centered`. |
| `static` | `false` | Uses a static backdrop and disables keyboard dismissal. This overrides `backdrop` and `keyboard`. |
| `backdrop` | Bootstrap default | Optional `true`, `false` or `static`, represented as a valid Bootstrap `data-bs-backdrop` value. |
| `keyboard` | Bootstrap default | Optional boolean controlling Escape-key dismissal through `data-bs-keyboard`. |
| `fade` | `true` | Adds/removes Bootstrap's `fade` class. |
| `show_header` | `true` | When `false`, omits the entire header. This also omits the built-in close button. |
| `show_title` | `true` | When `false`, omits the built-in title. Use `aria_label` or `aria_labelledby` to give the modal an accessible name when no title is shown. |
| `show_close_button` | `true` | Shows/hides the built-in close button. |
| `close_label` | `Close` | Accessible label on the close button. |
| `show_footer` | Automatic | Footer appears for non-empty `footer` or a configured `footer_partial`. Set `false` to suppress it. |
| `header_partial` | `''` | Replaces the complete default modal header. The partial owns the title and close-button markup and receives modal header variables. |
| `body_partial` | `''` | Replaces the content inside `.modal-body`. Receives `modalId`, `modalTitle`, `modalContent` and `modalFooter`. |
| `footer_partial` | `''` | Replaces the complete default modal footer, including its wrapper. Receives `modalId`, `modalTitle`, `modalContent` and `modalFooter`. |
| `escape_content` | `false` | Escapes `content` rather than rendering it as trusted HTML. Does not change rendering inside `body_partial`. |
| `escape_footer` | `false` | Escapes `footer` rather than rendering it as trusted HTML. Does not change rendering inside `footer_partial`. |
| `class` | `''` | Extra classes on the root `.modal`. |
| `dialog_class` | `''` | Extra classes on `.modal-dialog`. |
| `content_class` | `''` | Extra classes on `.modal-content`. |
| `header_class` | `''` | Extra classes on the default `.modal-header`. |
| `title_class` | `''` | Extra classes on the title heading. |
| `body_class` | `''` | Extra classes on `.modal-body`. |
| `footer_class` | `''` | Extra classes on the default `.modal-footer`. |
| `close_button_class` | `''` | Extra classes on the built-in close button. |
| `body_id` | `''` | Optional ID for `.modal-body`. Can be used as `aria_describedby`. |
| `role` | `dialog` | Role on the root modal element. |
| `aria_label` | `''` | Optional accessible name, especially useful when the built-in title is hidden. |
| `aria_labelledby` | Title ID when shown | Explicit ID of the element that labels the modal. Overrides the default title association. |
| `aria_describedby` | `''` | Optional ID of an element describing the modal. |
| `aria_modal` | `true` | Controls the root `aria-modal` value. |
| `aria_hidden` | `true` | Initial `aria-hidden` state. Bootstrap updates modal visibility state when shown/hidden. |

---

## Minimal usage

```twig
{% include
    'components/layout/modal.twig'
%}
```

## Typical usage

```twig
{% include
    'components/layout/modal.twig'
    with {
        id:
            'edit-user',

        title:
            'Edit User',

        content:
            '<p>User form goes here.</p>',

        footer:
            '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>',

        size:
            'lg',

        scrollable:
            true,

        centered:
            true,
    }
    only
%}
```

## Static modal

```twig
{% include
    'components/layout/modal.twig'
    with {
        id:
            'confirmation',

        title:
            'Confirm Action',

        content:
            '<p>This action requires confirmation.</p>',

        static:
            true,
    }
    only
%}
```

## Escaped plain-text content

```twig
{% include
    'components/layout/modal.twig'
    with {
        id:
            'announcement',

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

**Security:** The legacy `content` and `footer` parameters intentionally retain their trusted-HTML defaults for compatibility. Do not pass untrusted values through those parameters without enabling the appropriate escaping option. For rich dynamic markup, use application-authored Twig partials and escape untrusted values within the partial.

## Body partial

```twig
{% include
    'components/layout/modal.twig'
    with {
        id:
            'student-summary',

        title:
            'Student Summary',

        body_partial:
            'students/partials/modal-body.twig',
    }
    only
%}
```

The body partial replaces only the content inside `.modal-body` and receives `modalId`, `modalTitle`, `modalContent` and `modalFooter`.

## Footer partial

```twig
{% include
    'components/layout/modal.twig'
    with {
        id:
            'edit-user',

        title:
            'Edit User',

        footer_partial:
            'users/partials/modal-footer.twig',
    }
    only
%}
```

The footer partial replaces the complete default `.modal-footer` area and owns its wrapper and classes. A footer partial can render even when `footer` is empty.

## Header partial

```twig
{% include
    'components/layout/modal.twig'
    with {
        id:
            'custom-modal',

        title:
            'Custom Modal',

        header_partial:
            'modals/partials/custom-header.twig',
    }
    only
%}
```

The header partial replaces the complete header. It receives `modalId`, `modalTitle`, `modalTitleId`, `modalTitleTag`, `modalTitleClass`, `modalShowTitle`, `modalShowCloseButton`, `modalCloseLabel` and `modalCloseButtonClass`. Ensure custom header markup preserves an accessible name and a working dismiss button where needed.

## Accessibility and layout customization

```twig
{% include
    'components/layout/modal.twig'
    with {
        id:
            'account-details',

        title:
            'Account details',

        title_tag:
            'h2',

        title_id:
            'account-details-title',

        aria_labelledby:
            'account-details-title',

        aria_describedby:
            'account-details-description',

        body_id:
            'account-details-description',

        dialog_class:
            'modal-xl',

        body_class:
            'p-4',
    }
    only
%}
```

Choose heading levels and ARIA associations to fit the surrounding page. IDs must be unique when multiple modal instances are present. Bootstrap's JavaScript and CSS are required for show/hide interactions and dismissal.
