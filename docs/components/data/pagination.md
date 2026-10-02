# Pagination Component

Renders pagination controls from a `paginator` object. The component renders nothing when `paginator.hasPages()` is false.

**Component:** `data/pagination.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `alignment` | `center` | Controls pagination alignment. Supported values: `start`, `center`, `end`. |
| `size` | `null` | Optional size. Supported values: `sm` and `lg`. |
| `showSummary` | `true` | Shows the “Showing X to Y of Z results” summary. |
| `showFirstLast` | `true` | Shows the First and Last links. |

## Behavior and Notes

The component requires a `paginator` variable in the rendering context; it does not define a default.

The paginator is expected to provide `hasPages()`, `onFirstPage()`, `onLastPage()`, `links()`, `pages()`, `pageLinks()`, `currentPage()`, `from()`, `to()`, `total()`, and `lastPage()` methods.

`alignment` values outside `start`, `center`, and `end` fall back to centered alignment.

`size` values other than `sm` and `lg` render with no size class.

## Usage

```twig
{% include 'components/data/pagination.twig' with {
    alignment: 'center',
    size: 'sm',
    showSummary: true,
    showFirstLast: true
} %}
```
