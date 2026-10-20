# Badge

Renders a Bootstrap badge with sensible defaults, an optional icon, pill styling, a link, and replaceable content through a partial.

**Component:** `components/feedback/badge.twig`

Bootstrap CSS is required. Bootstrap Icons are needed only when the `icon` option is used.

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `type` | `'primary'` | Bootstrap contextual variant: `primary`, `secondary`, `success`, `danger`, `warning`, `info`, `light`, or `dark`. Unknown variants fall back to `primary`. |
| `text` | `'Badge'` | Escaped text shown inside the badge when `content` and `content_partial` are not supplied. |
| `class` | `''` | Additional CSS classes applied to the badge. |
| `id` | `''` | Optional HTML ID applied to the badge element. |
| `pill` | `false` | Adds Bootstrap's `rounded-pill` class. |
| `icon` | `''` | Optional Bootstrap Icon name or full class string. Accepts `check-circle`, `bi-check-circle`, or `bi bi-check-circle`. |
| `title` | `''` | Optional HTML title attribute. |
| `aria_label` | `''` | Optional accessible label. When `url` is supplied, it is applied to the link. |
| `url` | `''` | Optional URL. When present, the badge is wrapped in a link. No link is rendered by default. |
| `url_route` | `''` | Optional named route used to generate the link URL. Takes precedence over `url`. |
| `url_route_parameters` | `[]` | Parameters passed to the route helper when `url_route` is supplied. |
| `target` | `''` | Optional link target, such as `_blank`. When `_blank` is used and `rel` is omitted, `noopener noreferrer` is applied. |
| `rel` | `''` | Optional link `rel` attribute. |
| `content` | Not set | Optional embedded content. It renders as trusted HTML by default for flexibility; use `escape_content: true` to render it as text. |
| `escape_content` | `false` | Escapes `content` instead of rendering it as raw HTML. Use this for untrusted or user-supplied content. |
| `content_partial` | `''` | Optional partial replacing the default icon/text or embedded content. Takes precedence over `content`. |
| `content_partial_context` | `{}` | Extra values explicitly passed to the partial, in addition to `text`, `type`, `class`, `icon` and the matching `badge*` aliases. |

---

## Minimal Usage

The component renders a complete Bootstrap badge without parameters:

```twig
{% include
    'components/feedback/badge.twig'
%}
```

This displays a primary badge with the text `Badge`.

---

## Standard Usage

```twig
{% include
    'components/feedback/badge.twig'
    with {
        type:
            'success',

        text:
            'Active',
    }
    only
%}
```

---

## Pill Badge with Icon

```twig
{% include
    'components/feedback/badge.twig'
    with {
        type:
            'success',

        text:
            'Verified',

        icon:
            'check-circle-fill',

        pill:
            true,
    }
    only
%}
```

---

## Linked Badge

```twig
{% include
    'components/feedback/badge.twig'
    with {
        type:
            'info',

        text:
            'View students',

        url_route:
            'students.index',

        aria_label:
            'View all students',
    }
    only
%}
```

You may use a direct `url` instead of `url_route`. The badge is not a link when neither option is supplied; it never creates a dead `href="#"` by default.

---

## Embedded Content

Use `content` for trusted, application-authored markup. By default it is rendered as raw HTML to support inline markup and nested Bootstrap elements.

```twig
{% include
    'components/feedback/badge.twig'
    with {
        type:
            'warning',

        content:
            '<i class="bi bi-exclamation-triangle me-1"></i> Needs review',

        escape_content:
            false,
    }
    only
%}
```

For plain text or untrusted content, use `text` or set `escape_content: true`:

```twig
{% include
    'components/feedback/badge.twig'
    with {
        type:
            'secondary',

        content:
            user_status,

        escape_content:
            true,
    }
    only
%}
```

Never render unsanitized user-supplied HTML as raw content.

---

## Content Partial

Use `content_partial` when the badge needs custom Twig logic. The partial replaces the default icon/text or embedded content and receives `text`, `type`, `class`, `icon`, plus the `badgeType`, `badgeText`, and `badgeClass` aliases. It does not inherit arbitrary view variables; use `content_partial_context` for extra values.

```twig
{% include
    'components/feedback/badge.twig'
    with {
        type:
            'success',

        text:
            'Active',

        content_partial:
            'students/partials/status-badge.twig',
    }
    only
%}
```

Example `resources/views/students/partials/status-badge.twig`:

```twig
<i class="bi bi-check-circle-fill me-1" aria-hidden="true"></i>
{{ badgeText }}
```

Every configurable hash entry in these examples, including the final entry, has a trailing comma so the examples are easy to extend.
