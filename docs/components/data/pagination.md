# Pagination

Renders accessible pagination controls using Bootstrap's pagination classes, with an optional result summary. PixelFix supplies the component as a Twig template; the application should load Bootstrap CSS for the Bootstrap styling to appear.

**Component:** `components/data/pagination.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `paginator` | Required | PixelFix paginator instance used to generate page links and result counts. If omitted or `null`, the component renders nothing. |
| `alignment` | `'center'` | Pagination alignment: `start`, `center`, or `end`. |
| `size` | `''` | Bootstrap pagination size: `sm`, `lg`, or empty for the default size. |
| `class` | `''` | Additional CSS class applied to the Bootstrap `ul.pagination` element. |
| `nav_class` | `'mt-4'` | Additional CSS class applied to the navigation element. |
| `aria_label` | `'Pagination'` | Accessible label for the pagination navigation landmark. |
| `page_window` | `1` | Number of pages shown on either side of the current page, as passed to `paginator.pages()`. |
| `show_summary` | `true` | Displays the result summary. The older `showSummary` parameter is also supported. |
| `show_first_last` | `true` | Displays First and Last controls. The older `showFirstLast` parameter is also supported. |
| `show_previous_next` | `true` | Displays Previous and Next controls. The older `showPreviousNext` parameter is also supported. |
| `first_text` | `'First'` | Text for the First control. |
| `previous_text` | `'Previous'` | Accessible label for the Previous control. |
| `next_text` | `'Next'` | Accessible label for the Next control. |
| `last_text` | `'Last'` | Text for the Last control. |
| `empty_text` | `'No results found.'` | Summary text when the paginator contains no results. |
| `summary_class` | `'text-center text-muted small mt-2'` | Bootstrap utility classes applied to the result summary. |
| `controls_partial` | `''` | Optional partial that replaces the default `<ul>` controls inside the navigation element. The partial is responsible for its own Bootstrap pagination markup. |
| `controls_partial_context` | `{}` | Extra values explicitly passed to the controls partial, in addition to the paginator, generated link maps, alignment/size classes, and configured control labels. |
| `summary_partial` | `''` | Optional partial that replaces the default result summary. |
| `summary_partial_context` | `{}` | Extra values explicitly passed to the summary partial, in addition to the paginator, summary class, and empty-state text. |

---

## Minimal Usage

Pass the paginator instance. All other parameters have useful defaults:

```twig
{% include
    'components/data/pagination.twig'
    with {
        paginator:
            paginator,
    }
    only
%}
```

The default uses Bootstrap pagination styling, centers the controls, shows First/Previous/page numbers/Next/Last, and displays the result summary. The pagination controls are only rendered when more than one page exists; the summary can still be displayed for a single page.

> Bootstrap's CSS must be loaded by the application. This component does not load external stylesheets itself.

---

## Alignment and Size

Use `alignment` to select a Bootstrap flex alignment class and `size` to select Bootstrap's small or large pagination variant.

```twig
{% include
    'components/data/pagination.twig'
    with {
        paginator:
            users,

        alignment:
            'end',

        size:
            'sm',

        class:
            'mb-0',
    }
    only
%}
```

Supported alignments are `start`, `center`, and `end`. Supported sizes are `sm`, `lg`, or an empty string for the default size.

---

## Configure Controls and Summary

```twig
{% include
    'components/data/pagination.twig'
    with {
        paginator:
            users,

        show_summary:
            true,

        show_first_last:
            false,

        show_previous_next:
            true,

        page_window:
            2,

        aria_label:
            'Student list pages',
    }
    only
%}
```

The preferred option names use `snake_case`. For compatibility, `showSummary`, `showFirstLast`, and `showPreviousNext` remain supported, but new code should use `show_summary`, `show_first_last`, and `show_previous_next`.

---

## Controls and Summary Partials

Use `controls_partial` to replace the default pagination `<ul>`. Your partial is rendered inside the existing `<nav>` element, so it should provide Bootstrap's `ul.pagination`, `li.page-item`, and `a.page-link` / `span.page-link` markup as appropriate.

```twig
{% include
    'components/data/pagination.twig'
    with {
        paginator:
            users,

        controls_partial:
            'students/partials/pagination-controls.twig',

        summary_partial:
            'students/partials/pagination-summary.twig',
    }
    only
%}
```

The controls partial receives `paginator`, `paginationPaginator`, `paginationLinks`, `paginationPageLinks`, `paginationAlignmentClass`, `paginationSizeClass`, `paginationClass`, and the configured label text explicitly. Apply `paginationClass` to the custom `ul.pagination` if you want the same extra class as the default controls. The summary partial receives `paginator` and `paginationPaginator`, which expose `from()`, `to()`, and `total()`. These partials do not inherit arbitrary view variables; pass additional values with `controls_partial_context` or `summary_partial_context`.

When a partial is not configured, PixelFix uses the complete built-in Bootstrap markup.

---

## Complete Example

```twig
{% include
    'components/data/pagination.twig'
    with {
        paginator:
            users,

        alignment:
            'center',

        size:
            'sm',

        class:
            'mb-0',

        nav_class:
            'mt-4',

        aria_label:
            'Student list pages',

        page_window:
            1,

        show_summary:
            true,

        show_first_last:
            true,

        show_previous_next:
            true,

        first_text:
            'First',

        previous_text:
            'Previous',

        next_text:
            'Next',

        last_text:
            'Last',

        empty_text:
            'No students found.',

        summary_class:
            'text-center text-muted small mt-2',

        controls_partial:
            '',

        summary_partial:
            '',
    }
    only
%}
```

Every hash entry in the examples, including the final entry, has a trailing comma so the code can be extended safely.
