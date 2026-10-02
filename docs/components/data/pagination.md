# Pagination

> **Component:** `components/data/pagination.twig`

## Purpose

Renders Bootstrap pagination controls from the framework paginator. The component includes previous/next navigation, optional first/last links, a page window and an optional result summary.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``alignment`` | Optional | `center` | Accepted values are `start`, `center` or `end`. |
| ``size`` | Optional | `null` | Accepted values are `sm` or `lg`. |
| ``showSummary`` | Optional | `true` | Whether to show the `Showing … to … of … results` summary. |
| ``showFirstLast`` | Optional | `true` | Whether to render First and Last controls. |


## Behavior

The component does not accept the paginator as a component parameter. It expects a `paginator` object to already be available in the template context and first checks `paginator.hasPages()`. It uses `onFirstPage()`, `onLastPage()`, `links()`, `pages()`, `pageLinks()`, `currentPage()`, `lastPage()`, `from()`, `to()` and `total()`.

## Example

```twig
{% include 'components/data/pagination.twig' with {
    alignment: 'end',
    size: 'sm',
    showSummary: true,
    showFirstLast: true
} %}
```

## Usage

Call the component after a paginated result list. Ensure the framework paginator is available in the view context before rendering it.

## Notes

The exact variable name expected by the component is `paginator`.

## Related Components

- `components/data/table.twig`
