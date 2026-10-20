# Card

Renders a Bootstrap card with an optional title, subtitle, body content, footer, custom classes and partials.

**Component:** `components/layout/card.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `title` | `null` | Optional title displayed in the card body. Escaped by Twig. |
| `subtitle` | `null` | Optional subtitle displayed under the title. Escaped by Twig. |
| `content` | `''` | Card body content. For backward compatibility, trusted HTML is rendered by default. Set `escape_content: true` to render it as escaped text. |
| `footer` | `null` | Optional footer content. For backward compatibility, trusted HTML is rendered by default. Set `escape_footer: true` to render it as escaped text. |
| `class` | `''` | Additional CSS classes on the root `.card`. |
| `id` | `''` | Optional root element ID. |
| `role` | `''` | Optional ARIA role. |
| `aria_label` | `''` | Optional accessible name for the card. |
| `aria_labelledby` | `''` | ID of an element that labels the card. |
| `aria_describedby` | `''` | ID of an element that describes the card. |
| `body_class` | `''` | Additional classes on `.card-body`. |
| `title_class` | `''` | Additional title classes. |
| `title_id` | `''` | Optional ID on the title heading, useful with `aria_labelledby`. |
| `subtitle_class` | `''` | Additional subtitle classes. |
| `subtitle_id` | `''` | Optional ID on the subtitle heading. |
| `footer_class` | `''` | Additional classes on the default `.card-footer`. |
| `title_tag` | `'h5'` | Heading tag for the title. Only `h1` through `h6` are accepted; unsupported values fall back to `h5`. |
| `subtitle_tag` | `'h6'` | Heading tag for the subtitle. Only `h1` through `h6` are accepted; unsupported values fall back to `h6`. |
| `content_partial` | `''` | Optional Twig partial that replaces the embedded body content. It receives `cardTitle`, `cardSubtitle`, `cardContent` and `cardFooter`. The title and subtitle remain rendered before the partial. |
| `footer_partial` | `''` | Optional Twig partial that replaces the complete default footer. It receives `cardTitle`, `cardSubtitle`, `cardContent` and `cardFooter`. |
| `escape_content` | `false` | When `true`, renders `content` as escaped text instead of trusted HTML. |
| `escape_footer` | `false` | When `true`, renders `footer` as escaped text instead of trusted HTML. |
| `show_footer` | Automatic | The footer appears when `footer` is non-empty or `footer_partial` is configured. Set `false` to suppress it. |

---

## Minimal usage

The component renders a Bootstrap card without any parameters:

```twig
{% include
    'components/layout/card.twig'
%}
```

## Typical usage

```twig
{% include
    'components/layout/card.twig'
    with {
        title:
            'Profile',

        subtitle:
            'Account details',

        content:
            '<p>John Doe</p>',

        footer:
            '<a href="/profile">View Profile</a>',

        class:
            'shadow-sm',
    }
    only
%}
```

## Plain text content

Use `escape_content` and `escape_footer` when values should be displayed as text rather than interpreted as HTML:

```twig
{% include
    'components/layout/card.twig'
    with {
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

**Security:** The legacy `content` and `footer` parameters intentionally retain their trusted-HTML default for compatibility. Never pass user-supplied or otherwise untrusted strings through them without enabling escaping. For richer dynamic markup, prefer an application-authored Twig partial and escape any untrusted variables inside that partial.

## Content partial

Use `content_partial` when the card body needs custom application-authored markup. The partial replaces only the embedded content; configured title and subtitle still appear before it. The partial receives `cardTitle`, `cardSubtitle`, `cardContent` and `cardFooter`.

```twig
{% include
    'components/layout/card.twig'
    with {
        title:
            'Student Summary',

        content_partial:
            'students/partials/summary-card-content.twig',

        class:
            'shadow-sm',
    }
    only
%}
```

Example `students/partials/summary-card-content.twig`:

```twig
<p class="mb-0">
    Current enrolment:
    <strong>{{ student_count }}</strong>
</p>
```

## Footer partial

Use `footer_partial` to replace the complete default footer. The partial is responsible for its own wrapper and classes, and receives the same `card*` values as the content partial.

```twig
{% include
    'components/layout/card.twig'
    with {
        title:
            'Profile',

        footer_partial:
            'students/partials/profile-card-footer.twig',
    }
    only
%}
```

## Accessibility and heading levels

Use the ARIA parameters when a card needs an accessible name or description. Choose heading levels that fit the surrounding page structure:

```twig
{% include
    'components/layout/card.twig'
    with {
        id:
            'account-card',

        title:
            'Account details',

        title_tag:
            'h2',

        title_id:
            'account-card-title',

        aria_labelledby:
            'account-card-title',

        body_class:
            'p-4',
    }
    only
%}
```

If `aria_labelledby` is used, the referenced ID should exist in the rendered markup. For a matching custom heading ID, include a suitable partial or provide the accessible label with `aria_label`.
