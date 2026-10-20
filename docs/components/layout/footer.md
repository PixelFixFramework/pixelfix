# Footer

Renders the application footer with configurable company identity, optional company navigation, right-side content, and container styling.

**Component:** `components/layout/footer.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `footer_company_name` | `config('app.name')` | Company or application name. |
| `footer_company_url` | `''` | Optional direct destination for the company name. The company name renders as plain text when no destination is configured. |
| `footer_company_href` | `''` | Compatibility alias for `footer_company_url`. |
| `footer_company_route` | `''` | Optional named route used for the company link. Takes precedence over a direct URL. |
| `footer_company_route_parameters` | `[]` | Parameters passed to PixelFix's `route()` helper. |
| `footer_company_url_route` / `footer_company_route_name` | `''` | Compatibility aliases for the named route. |
| `footer_company_url_route_parameters` / `footer_company_parameters` | `[]` | Compatibility aliases for route parameters. |
| `footer_company_target` | `''` | Optional target for the company link. |
| `footer_company_rel` | `''` | Optional relationship attribute. `_blank` links default to `noopener noreferrer` when no `rel` is supplied. |
| `footer_right` | `null` | Optional right-side footer content. Trusted HTML remains supported for backward compatibility. |
| `escape_footer_right` | `false` | Escapes `footer_right` as plain text when enabled. |
| `footer_right_partial` | `''` | Optional Twig partial replacing the default right-side content. |
| `container` | `container-fluid` | Bootstrap container class. `container_class` is an alias with precedence. |
| `footer_class` | `''` | Additional class names on the footer element. |
| `footer_id` | `''` | Footer element ID. `id` is a compatibility alias. |
| `footer_aria_label` | `''` | Optional accessible label for the footer landmark. `aria_label` is an alias. |
| `footer_content_class` | `''` | Additional class names on the content wrapper. |
| `footer_copyright_class` | `''` | Additional class names on the copyright wrapper. |
| `footer_company_link_class` | `text-decoration-none` | Class names on the company link. |
| `footer_right_class` | `''` | Additional class names on the right-side wrapper. |
| `rights_reserved_text` | `All rights reserved.` | Text shown after the copyright statement. |
| `show` | `true` | Controls whether the footer renders. `show_footer` is a compatibility alias. |
| `current_year` | Current year | Optional explicit year override for testing or special use cases. |

---

## Direct URL

```twig
{% include
    'components/layout/footer.twig'
    with {
        footer_company_name:
            config('app.name'),

        footer_company_url:
            '/about',

        footer_right:
            'Version 0.1.16',

        container:
            'container',
    }
    only
%}
```

## Named route

```twig
{% include
    'components/layout/footer.twig'
    with {
        footer_company_name:
            config('app.name'),

        footer_company_route:
            'home',

        footer_company_route_parameters: {
            locale:
                'en',
        },

        footer_right:
            'Version 0.1.16',

        container:
            'container',
    }
    only
%}
```

When both `footer_company_route` and `footer_company_url` are supplied, the named route takes precedence. The named route must be registered in the application.

When neither a route nor a URL is configured, the company name is displayed as plain text rather than an anchor with a placeholder `href`.

## Right-side content

`footer_right` preserves the legacy trusted-HTML behavior. Only pass application-authored/trusted HTML to it. For plain text, enable `escape_footer_right`:

```twig
{% include
    'components/layout/footer.twig'
    with {
        footer_right:
            user_supplied_footer_note,

        escape_footer_right:
            true,
    }
    only
%}
```

Alternatively, use `footer_right_partial` for structured markup. The partial receives `footerCurrentYear`, `footerCompanyName`, `footerCompanyUrl`, and `footerRight` as explicit variables.

## Current year

The component derives its year from Twig's `now` date value. `current_year` can override it when a fixed year is required.
