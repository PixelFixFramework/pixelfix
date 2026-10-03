# Toast

Renders a Bootstrap toast notification with configurable content, position, theme, timing, and optional automatic display.

**Component:** `components/feedback/toast.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `id` | `toast` | HTML id assigned to the toast. |
| `title` | `Notification` | Toast header title. |
| `message` | `Operation completed successfully.` | Toast body message. |
| `type` | `primary` | Bootstrap contextual color used by the toast indicator. |
| `time` | `Just now` | Time text displayed in the toast header. |
| `autohide` | `true` | Controls Bootstrap toast autohide behavior. |
| `delay` | `5000` | Autohide delay in milliseconds. |
| `position` | `bottom-end` | Toast container position. |
| `showOnLoad` | `false` | Automatically shows the toast after DOM content loads. |
| `theme` | `light` | Toast theme: `light` or `dark`. |

---

## Position

Supported `position` values are:

- `top-start`
- `top-center`
- `top-end`
- `middle-start`
- `middle-center`
- `middle-end`
- `bottom-start`
- `bottom-center`
- `bottom-end`

Unknown values use the `bottom-end` position.

---

## Theme

Supported `theme` values are:

- `light`
- `dark`

Unknown values use the light theme.

---

# Usage

```twig
{% include
    'components/feedback/toast.twig'
    with {
        id:
            'save-toast'

        title:
            'Saved'

        message:
            'Your changes have been saved.'

        type:
            'success'

        time:
            'Just now'

        autohide:
            true

        delay:
            5000

        position:
            'bottom-end'

        showOnLoad:
            true

        theme:
            'light'
    }
    only
%}
```

---

## Manual Display

Set `showOnLoad` to `false` when the application will control display using
Bootstrap's Toast API.

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

        showOnLoad:
            false
    }
    only
%}
```
