# Dashboard Tile

Renders a complete dashboard summary tile with a value, label, icon, optional footer link, and optional content/footer partials.

**Component:** `components/dashboard/tile.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `value` | `'0'` | Main value displayed by the tile. |
| `label` | `'Dashboard Metric'` | Label displayed below the value. |
| `icon` | `'speedometer2'` | Bootstrap Icon name or CSS class string. Set `null` or `''` to hide the icon. Accepts `people-fill`, `bi-people-fill`, `bi bi-people-fill`, or another full icon class string. |
| `class` | `''` | Additional CSS class applied to the tile. |
| `content` | `null` | Optional trusted, application-authored HTML that replaces the default value-and-label content block. Use `value` and `label` for ordinary text. |
| `content_partial` | `''` | Optional partial that replaces the default value-and-label content block. Takes precedence over `content`; the tile body and icon remain in place. |
| `content_partial_context` | `{}` | Extra values explicitly passed to the content partial. It receives the standard `value`, `label`, `icon`, `icon_class`, `class` keys and the matching `tile*` aliases. |
| `url` | `''` | URL used by the default footer link. The footer is hidden when no URL or footer partial is configured. |
| `url_route` | `''` | Named route used to generate the footer URL. Takes precedence over `url` when supplied. |
| `url_route_parameters` | `[]` | Parameters passed to `route()` when resolving `url_route`. |
| `footer_text` | `'More info'` | Text displayed in the default footer link. |
| `footer_partial` | `''` | Optional partial that replaces the complete default footer link. Its markup is responsible for its own footer styling. |
| `footer_partial_context` | `{}` | Extra values explicitly passed to the footer partial. It receives URL, footer text, target, relation, and their `tile*` aliases. |
| `footer_target` | `''` | Optional `target` attribute for the default footer link, such as `_blank`. |
| `footer_rel` | `''` | Optional `rel` attribute for the default footer link, such as `noopener noreferrer` when opening a new tab. |
| `show_footer` | Automatic | The footer is shown when a URL or footer partial is provided. Set `false` to hide it. A default footer link is never rendered without a URL. |

---

## Minimal Usage

The component renders a usable default tile without any parameters:

```twig
{% include
    'components/dashboard/tile.twig'
%}
```

The default tile displays `0`, `Dashboard Metric`, and a speedometer icon. It does not render a footer link until a URL or footer partial is configured.

---

## Usage

```twig
{% include
    'components/dashboard/tile.twig'
    with {
        value:
            '128',

        label:
            'Registered Students',

        icon:
            'people-fill',

        class:
            'bg-primary',

        url:
            '/students',

        footer_text:
            'View Students',
    }
    only
%}
```

### Named Route

Use `url_route` to generate the footer URL from a named route. The route must exist in the application.

```twig
{% include
    'components/dashboard/tile.twig'
    with {
        value:
            '128',

        label:
            'Registered Students',

        icon:
            'bi bi-people-fill',

        url_route:
            'students.index',

        url_route_parameters:
            [],

        footer_text:
            'View Students',
    }
    only
%}
```

---

## Embedded Content and Content Partials

Use `content` for trusted, application-authored HTML when a small customization does not need a separate file. The value-and-label block is replaced by this markup. Because `content` is rendered as raw HTML, do not pass user-supplied or otherwise untrusted data through this parameter; use `value` and `label` for ordinary text.

```twig
{% include
    'components/dashboard/tile.twig'
    with {
        value:
            '128',

        label:
            'Registered Students',

        content:
            '<strong>128</strong><span class="small"> students currently registered</span>',
    }
    only
%}
```

Use `content_partial` when the value-and-label block needs richer markup, such as a comparison, status indicator, or miniature chart. A configured `content_partial` takes precedence over `content`. The component passes a defined context to the partial rather than inheriting arbitrary page variables. It receives the value, label, icon, icon class, tile class, and the legacy `tileValue` / `tileLabel` aliases. Supply additional values through `content_partial_context`.

```twig
{% include
    'components/dashboard/tile.twig'
    with {
        value:
            '128',

        label:
            'Registered Students',

        icon:
            'people-fill',

        content_partial:
            'dashboard/partials/student-summary.twig',
    }
    only
%}
```

Example `dashboard/partials/student-summary.twig`:

```twig
<div class="pixelfix-dashboard-tile-value">
    {{ tileValue }}
</div>

<div class="pixelfix-dashboard-tile-label">
    {{ tileLabel }}
</div>

<p class="small mb-0 text-success">
    <i class="bi bi-arrow-up-right" aria-hidden="true"></i>
    Enrolment is increasing.
</p>
```

---

## Footer Partials

Use `footer_partial` to replace the standard footer link with custom footer markup. The partial is rendered in place of the complete footer link and is responsible for its own markup and classes. It receives `url`, `footer_text`, `target`, and `rel` (plus legacy `tile*` aliases); pass any additional values in `footer_partial_context`. It receives `url`, `footer_text`, `target`, and `rel` (plus legacy `tile*` aliases); pass any additional values in `footer_partial_context`.

```twig
{% include
    'components/dashboard/tile.twig'
    with {
        value:
            'K 25,000',

        label:
            'Total Revenue',

        icon:
            'cash-stack',

        footer_partial:
            'dashboard/partials/revenue-footer.twig',
    }
    only
%}
```

---

## Complete Example

```twig
{% include
    'components/dashboard/tile.twig'
    with {
        value:
            'K 25,000',

        label:
            'Total Revenue',

        icon:
            'cash-stack',

        class:
            'bg-success',

        url_route:
            'reports.revenue',

        url_route_parameters:
            [],

        footer_text:
            'View Report',

        footer_target:
            '',

        footer_rel:
            '',
    }
    only
%}
```

Every entry in Twig hash examples includes a trailing comma so the example can be extended by adding another option.
