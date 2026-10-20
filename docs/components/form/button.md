# Button

Renders a Bootstrap-styled button or link with a clear, dedicated `text` parameter for its visible label.

**Component:** `components/form/button.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `tag` | `button` | Rendered element. Use `a` for a link. |
| `text` | `Button` | Visible button or link text. Text is escaped by Twig. |
| `class` | `btn` | CSS classes applied to the element. |
| `type` | `button` | Native button type when `tag` is not `a`. |
| `href` | `null` | Direct URL used by an anchor. If omitted, no dead `#` link is generated. |
| `route` | `null` | Named route used to resolve the anchor URL. |
| `route_parameters` | `[]` | Parameters passed to `route()`. |
| `id` | `null` | Element ID. |
| `name` | `null` | Native button name. |
| `value` | `null` | Native button value. |
| `form` | `null` | ID of the form associated with a button outside that form. |
| `aria_label` | `null` | Accessible label for the element. |
| `title` | `null` | Element title. |
| `target` | `null` | Anchor target. |
| `rel` | `null` | Anchor relationship; defaults to `noopener noreferrer` for `_blank`. |
| `disabled` | `false` | Disables a native button, or marks an anchor as disabled. |
| `icon` | `null` | Optional icon CSS class rendered before the text. |
| `icon_class` | `me-1` | Additional CSS class applied to the icon. |
| `content_partial` | `''` | Optional Twig partial that replaces the default text area. It receives `text`, `icon` and `icon_class`. |

The visible label uses `text`, **not `content`**. The component does not use `content` for its button label. For complex inner markup, provide a `content_partial` rather than passing unescaped HTML as text.

---

## Basic Button

```twig
{% include
    'components/form/button.twig'
    with {
        type:
            'submit',

        class:
            'btn btn-primary',

        text:
            'Save Changes',
    }
    only
%}
```

The component also works with no parameters and renders a standard Bootstrap button labelled `Button`.

---

## Link Button

Set `tag` to `a` and provide an `href` or a named `route`.

```twig
{% include
    'components/form/button.twig'
    with {
        tag:
            'a',

        href:
            '/dashboard',

        class:
            'btn btn-secondary',

        text:
            'Dashboard',
    }
    only
%}
```

If a link has no `href` or `route`, the component omits `href` instead of generating a dead `#` link.

---

## Named Route

```twig
{% include
    'components/form/button.twig'
    with {
        tag:
            'a',

        route:
            'profile',

        route_parameters: {
            id:
                15,
        },

        text:
            'Profile',
    }
    only
%}
```

When `route` is supplied, it takes precedence over `href`.

---

## Icon Button

```twig
{% include
    'components/form/button.twig'
    with {
        class:
            'btn btn-primary',

        icon:
            'bi bi-save',

        text:
            'Save',
    }
    only
%}
```

---

## Disabled Button

```twig
{% include
    'components/form/button.twig'
    with {
        text:
            'Submitting...',

        disabled:
            true,
    }
    only
%}
```

---

## Custom Text Partial

Use a partial when the button label needs more than plain text. The partial is included in the label position, after the optional icon, and receives the `text`, `icon` and `icon_class` variables.

```twig
{% include
    'components/form/button.twig'
    with {
        text:
            'Save',

        content_partial:
            'forms/partials/save-button-label.twig',
    }
    only
%}
```

---

## Security and Accessibility

- `text` is escaped by Twig.
- Use `content_partial` for trusted, application-authored markup instead of passing HTML through `text`.
- Icons receive `aria-hidden="true"` because the visible text labels the button.
- When an anchor opens in a new tab, `rel="noopener noreferrer"` is added unless a custom `rel` is provided.
- Bootstrap CSS must be loaded by the application for Bootstrap button styling.
