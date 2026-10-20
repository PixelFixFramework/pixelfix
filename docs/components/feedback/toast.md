# Toast

Renders a complete Bootstrap toast notification with a configurable message, position, theme, timing, and optional header, content, and footer partials. The toast is shown automatically by default; set `show_on_load: false` when your application will control display through Bootstrap's Toast API.

**Component:** `components/feedback/toast.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `id` | `''` | Optional HTML ID. No fixed ID is generated, so multiple toast instances do not create duplicate IDs. Set an ID when controlling the toast manually from JavaScript. |
| `title` | `Notification` | Header title. |
| `message` | `Operation completed successfully.` | Default message text. `content` is an alias that takes precedence when supplied. |
| `type` | `primary` | Bootstrap contextual color for the indicator: `primary`, `secondary`, `success`, `danger`, `warning`, `info`, `light`, or `dark`. Invalid values fall back to `primary`. |
| `time` | `Just now` | Small text displayed in the header. Pass an empty value to omit it. |
| `theme` | `light` | Header and body theme: `light` or `dark`. Invalid values fall back to `light`. |
| `position` | `bottom-end` | Fixed position. Supported values are listed below. |
| `autohide` | `true` | Allows Bootstrap to hide the toast automatically. Explicit `false` is respected. |
| `delay` | `5000` | Autohide delay in milliseconds. Non-integer values fall back to `5000`. |
| `show_on_load` | `true` | Shows the toast after the document is ready. The legacy `showOnLoad` parameter is also supported. Explicit `false` is respected. |
| `show_header` | `true` | Shows the header. Explicit `false` is respected. |
| `show_close` | `true` | Shows the close button. Explicit `false` is respected. |
| `show_indicator` | `true` | Shows the contextual-color dot in the header. |
| `show_time` | `true` | Shows the time when a non-empty `time` is provided. |
| `aria_live` | `assertive` | Announcement urgency: `assertive`, `polite`, or `off`. Invalid values fall back to `assertive`. |
| `close_label` | `Close` | Accessible label for the close button. |
| `class` | `''` | Additional classes on the toast element. |
| `container` | `true` | Creates the fixed-position wrapper. Set to `false` to place the toast inside an existing shared Bootstrap `toast-container`. |
| `container_class` | `''` | Additional classes on the fixed-position wrapper when `container` is enabled. |
| `header_class` | `''` | Additional classes on the header. |
| `body_class` | `''` | Additional classes on the body. |
| `footer_class` | `''` | Additional classes on the optional footer wrapper. |
| `escape_content` | `true` | Escapes `message`/`content` as text. Set to `false` only for trusted, application-authored HTML. |
| `header_partial` | `''` | Replaces the complete default header. Receives `id`, `title`, `message`, `type`, `time`, `theme`, `show_close`, and `close_label`. |
| `content_partial` | `''` | Replaces the body content. Receives `id`, `title`, `message`, `content`, `type`, `time`, and `theme`. |
| `footer_partial` | `''` | Adds a footer area. Receives `id`, `title`, `message`, `type`, `time`, and `theme`. |

All Boolean options preserve an explicitly supplied `false`; they do not revert to their defaults when disabled.

---

## Position

Supported `position` values:

- `top-start`
- `top-center`
- `top-end`
- `middle-start`
- `middle-center`
- `middle-end`
- `bottom-start`
- `bottom-center`
- `bottom-end`

Unknown values use `bottom-end`.

## Theme

Supported `theme` values are `light` and `dark`. The close button is also adjusted to remain visible with the dark theme.

---

## Basic Usage

The component provides a complete notification with defaults. It automatically displays after the document is ready and hides after five seconds unless the user closes it first.

```twig
{% include
    'components/feedback/toast.twig'
%}
```

## Customize the Toast

```twig
{% include
    'components/feedback/toast.twig'
    with {
        id:
            'save-toast',

        title:
            'Saved',

        message:
            'Your changes have been saved.',

        type:
            'success',

        time:
            'Just now',

        autohide:
            true,

        delay:
            5000,

        position:
            'bottom-end',

        show_on_load:
            true,

        theme:
            'light',
    }
    only
%}
```

## Keep the Toast Visible Until Dismissed

```twig
{% include
    'components/feedback/toast.twig'
    with {
        id:
            'persistent-toast',

        title:
            'Attention Required',

        message:
            'Please review the outstanding items.',

        type:
            'warning',

        autohide:
            false,

        show_on_load:
            true,
    }
    only
%}
```

## Manual Display

Set `show_on_load` to `false` and give the toast an ID when the application will control display using Bootstrap's Toast API.

```twig
{% include
    'components/feedback/toast.twig'
    with {
        id:
            'notification-toast',

        title:
            'Notification',

        message:
            'A new notification is available.',

        show_on_load:
            false,
    }
    only
%}
```

Then, after Bootstrap's JavaScript bundle is available:

```javascript
const toastElement = document.getElementById('notification-toast');

if (toastElement && window.bootstrap?.Toast) {
    window.bootstrap.Toast.getOrCreateInstance(toastElement).show();
}
```

## Stack Several Toasts in One Container

```twig
<div class="toast-container position-fixed bottom-0 end-0 p-3">

    {% include
        'components/feedback/toast.twig'
        with {
            id:
                'saved-toast',

            title:
                'Saved',

            message:
                'Your changes have been saved.',

            type:
                'success',

            container:
                false,
        }
        only
    %}

    {% include
        'components/feedback/toast.twig'
        with {
            id:
                'sync-toast',

            title:
                'Sync Complete',

            message:
                'Your records are synchronized.',

            type:
                'info',

            container:
                false,
        }
        only
    %}

</div>
```

## Use Content Partials

`header_partial` replaces the full header, `content_partial` replaces the message body, and `footer_partial` adds a footer. Partials receive only the documented variables listed in the Parameters table.

```twig
{% include
    'components/feedback/toast.twig'
    with {
        title:
            'Student Created',

        message:
            'Student details are ready.',

        content_partial:
            'students/partials/toast-content.twig',

        footer_partial:
            'students/partials/toast-actions.twig',
    }
    only
%}
```

Example `students/partials/toast-content.twig`:

```twig
<p class="mb-0">{{ message }}</p>
```

Every hash entry in the documentation, including the final entry, ends with a comma so developers can extend examples without editing the previous line.

---

## Bootstrap Requirements

Load Bootstrap CSS and its JavaScript bundle. Toast display, transitions, dismissal, and autohide are provided by Bootstrap's Toast API. The automatic-display script safely does nothing if Bootstrap's JavaScript API is not loaded; a toast will remain hidden until it is shown by Bootstrap.

A single Toast component creates its own fixed-position container by default. For several toasts that must stack together, create one shared Bootstrap `toast-container` and pass `container: false` to each Toast component. Avoid rendering multiple independent containers at the same fixed position if they should be stacked.
