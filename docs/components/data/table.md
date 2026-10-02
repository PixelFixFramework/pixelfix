# Table Component

Renders a data table from header and row arrays, with optional caption, footer, responsive wrapping, and common table style classes.

**Component:** `data/table.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `headers` | `[]` | Array of column header values. |
| `rows` | `[]` | Array of row arrays. Each cell is rendered as raw HTML. |
| `caption` | `null` | Optional table caption. |
| `footer` | `null` | Optional raw HTML rendered inside `<tfoot>`. |
| `responsive` | `true` | Wraps the table in `.table-responsive`. |
| `striped` | `true` | Adds `.table-striped`. |
| `hover` | `true` | Adds `.table-hover`. |
| `bordered` | `false` | Adds `.table-bordered`. |
| `compact` | `false` | Adds `.table-sm`. |
| `dark` | `false` | Adds `.table-dark`. |
| `numbered` | `false` | Adds a `#` column and row numbers. |
| `emptyMessage` | `No records found.` | Message shown when `rows` is empty. |

## Behavior and Notes

The `rows` array is expected to contain arrays whose values correspond to the `headers` order.

Cell values and footer content are rendered with `|raw`; pass trusted HTML only.

When `numbered=true`, the empty-state colspan includes the additional number column.

## Usage

```twig
{% include 'components/data/table.twig' with {
    headers: ['Name', 'Status'],
    rows: [
        ['Task One', '<span class="badge text-bg-success">Done</span>'],
        ['Task Two', '<span class="badge text-bg-warning">Pending</span>']
    ],
    caption: 'Tasks',
    numbered: true
} %}
```
