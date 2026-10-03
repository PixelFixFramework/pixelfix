# Modal

Renders a Bootstrap modal with configurable size, scrolling, centering, static behavior, content, and footer.

**Component:** `components/layout/modal.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `id` | Required | Modal id and label target. |
| `title` | `Modal` | Modal title. |
| `content` | `''` | Modal body content rendered as raw HTML. |
| `footer` | `null` | Optional modal footer rendered as raw HTML. |
| `size` | `null` | Modal size. |
| `scrollable` | `false` | Enables a scrollable modal dialog. |
| `centered` | `false` | Centers the modal vertically. |
| `static` | `false` | Prevents closing through backdrop click or keyboard escape. |

---

## Sizes

Supported `size` values are:

- `sm`
- `lg`
- `xl`
- `fullscreen`
- `fullscreen-sm-down`
- `fullscreen-md-down`
- `fullscreen-lg-down`
- `fullscreen-xl-down`
- `fullscreen-xxl-down`

---

# Usage

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
            true
    }
    only
%}
```

---

## Static Modal

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
            true
    }
    only
%}
```
