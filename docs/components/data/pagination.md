# Pagination

Renders Bootstrap pagination controls for a paginator instance.

**Component:** `components/data/pagination.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `paginator` | Required | Paginator object used to generate pages, links, and result summary. |
| `alignment` | `center` | Pagination alignment: `start`, `center`, or `end`. |
| `size` | `null` | Pagination size: `sm`, `lg`, or `null`. |
| `showSummary` | `true` | Determines whether the result summary is displayed. |
| `showFirstLast` | `true` | Determines whether First and Last controls are displayed. |

---

# Paginator API

The component uses the paginator methods:

| Method | Purpose |
|---|---|
| `hasPages()` | Determines whether pagination should be rendered. |
| `onFirstPage()` | Determines whether the current page is the first page. |
| `onLastPage()` | Determines whether the current page is the last page. |
| `links()` | Provides previous and next URLs. |
| `pages()` | Provides the page window, including `...` entries. |
| `currentPage()` | Returns the current page number. |
| `pageLinks()` | Provides URLs keyed by page number. |
| `lastPage()` | Returns the last page number. |
| `from()` | Returns the first result number on the current page. |
| `to()` | Returns the last result number on the current page. |
| `total()` | Returns the total result count. |

---

# Usage

Pass a paginator instance to the component.

```twig
{% include
    'components/data/pagination.twig'
    with {
        paginator:
            paginator

        alignment:
            'center'

        size:
            'sm'

        showSummary:
            true

        showFirstLast:
            true
    }
    only
%}
```

---

## Alignment

Supported values are `start`, `center`, and `end`.

```twig
{% include
    'components/data/pagination.twig'
    with {
        paginator:
            paginator

        alignment:
            'end'
    }
    only
%}
```

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

        showSummary:
            true,

        showFirstLast:
            true
    }
    only
%}
```
