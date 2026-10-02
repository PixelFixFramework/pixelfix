# Data Table

> **Component:** `components/data/table.twig`

## Purpose

Builds a reusable Bootstrap table from header and row arrays, with optional caption, footer, responsive wrapping, striped/hover/bordered/compact/dark styles and row numbering.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``headers`` | Optional | `[]` | Array of header labels. |
| ``rows`` | Optional | `[]` | Array of row arrays. Cell content is rendered as raw HTML. |
| ``caption`` | Optional | `null` | Table caption. |
| ``footer`` | Optional | `null` | Raw footer HTML inserted inside `<tfoot>`. |
| ``responsive`` | Optional | `true` | Wrap the table in `.table-responsive`. |
| ``striped`` | Optional | `true` | Adds `table-striped`. |
| ``hover`` | Optional | `true` | Adds `table-hover`. |
| ``bordered`` | Optional | `false` | Adds `table-bordered`. |
| ``compact`` | Optional | `false` | Adds `table-sm`. |
| ``dark`` | Optional | `false` | Adds `table-dark`. |
| ``numbered`` | Optional | `false` | Adds a first `#` column with loop indexes. |
| ``emptyMessage`` | Optional | `No records found.` | Message rendered when `rows` is empty. |


## Behavior

Rows are traversed in order. Each cell uses `|raw`, so callers can supply markup such as buttons or links. When `numbered` is true, the component adds a one-based loop index column.

## Example

```twig
{% include 'components/data/table.twig' with {
    headers: ['Name', 'Email', 'Status'],
    rows: [
        ['Jane', 'jane@example.com', '<span class="badge text-bg-success">Active</span>'],
        ['John', 'john@example.com', '<span class="badge text-bg-secondary">Inactive</span>']
    ],
    responsive: true,
    numbered: true
} %}
```

## Usage

Prepare the `headers` and `rows` arrays in the controller/view model, then include the component. Use `raw` cell content only for HTML you trust.

## Notes

The source defaults `emptyMessage` even though it is not shown in the compact normalization block; it is still a supported public input used by the template.

## Related Components

- `components/data/pagination.twig`
- `components/feedback/badge.twig`
