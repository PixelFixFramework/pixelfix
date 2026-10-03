# Button

Renders either a button element or an anchor element using a reusable Bootstrap button API.

**Component:** `components/form/button.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `tag` | `button` | Rendered element. Use `a` for a link. |
| `class` | `btn` | CSS classes applied to the element. |
| `type` | `button` | Button type when `tag` is not `a`. |
| `href` | `null` | Direct href used by an anchor. |
| `route` | `null` | Named route used to resolve the href. |
| `route_parameters` | `[]` | Parameters passed to `route()`. |
| `id` | `null` | Element id. |
| `aria_label` | `null` | Accessible aria-label. |
| `title` | `null` | Element title. |
| `target` | `null` | Anchor target. |
| `rel` | `null` | Anchor rel attribute. |
| `icon` | `null` | Optional icon class or markup rendered before content. |
| `icon_class` | `me-1` | CSS class applied to the icon. |
| `content` | `''` | Button or anchor content. |

---

# Usage

```twig
{% include
    'components/form/button.twig'
    with {
        type:
            'submit'

        class:
            'btn btn-primary'

        content:
            'Save Changes'
    }
    only
%}
```

---

## Link Button

Set `tag` to `a` and provide `href` or `route`.

```twig
{% include
    'components/form/button.twig'
    with {
        tag:
            'a'

        href:
            '/dashboard'

        class:
            'btn btn-secondary'

        content:
            'Dashboard'
    }
    only
%}
```

---

## Named Route

```twig
{% include
    'components/form/button.twig'
    with {
        tag:
            'a'

        route:
            'profile'

        route_parameters:
            { id: 15 }

        content:
            'Profile'
    }
    only
%}
```

When `route` is supplied, it takes precedence over `href`.

---

## Icon

```twig
{% include
    'components/form/button.twig'
    with {
        class:
            'btn btn-primary'

        icon:
            'bi bi-save'

        content:
            'Save'
    }
    only
%}
```
