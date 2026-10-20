# Table Component

Renders a responsive, Bootstrap-styled data table with sensible defaults and optional Twig partials.

**Component:** `components/data/table.twig`

## Quick start

The component can be included without options. It renders a Bootstrap table with the default empty-state message. Normally, supply `headers` and `rows`:

```twig
{% include
    'components/data/table.twig'
    with {
        headers: [
            'Name',
            'Email',
            'Status',
        ],
        rows: [
            [
                'John Doe',
                'john@example.com',
                'Active',
            ],
            [
                'Jane Doe',
                'jane@example.com',
                'Inactive',
            ],
        ],
        caption: 'Users',
    }
    only
%}
```

Every hash entry and array item in the examples has a trailing comma so the example is easy to extend.

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `headers` | `[]` | Array of column header labels. Values are HTML-escaped. |
| `rows` | `[]` | Array of row arrays. Each row contains one cell value per column. |
| `caption` | `''` | Optional table caption. Text is HTML-escaped. |
| `caption_side` | `'top'` | Use `top` for Bootstrap's `caption-top` class; other values use the browser's normal caption placement. |
| `table_id` | `''` | Optional table element ID. |
| `aria_label` | `'Data table'` | Accessible label for the table. |
| `class` | `''` | Additional CSS classes added to the Bootstrap table. |
| `wrapper_class` | `''` | Additional classes added to the responsive wrapper. |
| `responsive` | `true` | Wraps the table in a responsive container. |
| `responsive_breakpoint` | `''` | Optional Bootstrap breakpoint: `sm`, `md`, `lg`, `xl` or `xxl`. Used only when `responsive` is enabled. |
| `striped` | `true` | Adds Bootstrap's `table-striped` class. |
| `hover` | `true` | Adds Bootstrap's `table-hover` class. |
| `bordered` | `false` | Adds `table-bordered`. |
| `compact` | `false` | Adds `table-sm`. |
| `dark` | `false` | Adds `table-dark`. |
| `align_middle` | `true` | Adds Bootstrap's `align-middle` utility. |
| `numbered` | `false` | Adds a numbered column at the beginning of each row. Row numbers start at 1 for the current `rows` array. |
| `show_header` | `true` | Displays the header when headers, a header partial or numbering is provided. |
| `empty_message` | `'No records found.'` | Message displayed when `rows` is empty. The legacy `emptyMessage` option is also accepted. |
| `escape_cells` | `false` | When `true`, HTML in cells is escaped. The default preserves the previous component behavior of rendering cells as raw HTML. |
| `header_partial` | `''` | Optional partial that renders `<th>` cells inside the component's header row. Receives `headers` and `numbered`, plus any other variables passed to the table component. |
| `body_partial` | `''` | Optional partial that renders table rows inside `<tbody>` and replaces the built-in body loop. Receives `headers`, `rows`, `numbered`, `empty_message` and `column_count`, plus any other variables passed to the table component. |
| `row_partial` | `''` | Optional partial rendered once per row. It must output a complete `<tr>`. Receives `row`, `row_index`, `row_number`, `headers` and `numbered`, plus any other variables passed to the table component. |
| `empty_partial` | `''` | Optional partial rendered inside the empty-state `<td>`. Receives `empty_message`, `headers`, `numbered` and `column_count`, plus any other variables passed to the table component. |
| `footer` | `null` | Optional raw HTML rendered inside `<tfoot>`. Retained for compatibility. |
| `footer_partial` | `''` | Optional partial that renders `<tr>` rows inside `<tfoot>`. Receives `headers`, `rows`, `numbered` and `column_count`, plus any other variables passed to the table component. It takes precedence over `footer`. |

Bootstrap CSS must be loaded by the application for the Bootstrap classes to style the table.

## Bootstrap variants

```twig
{% include
    'components/data/table.twig'
    with {
        headers: ['Name', 'Email',],
        rows: [],
        responsive: true,
        responsive_breakpoint: 'md',
        striped: false,
        hover: true,
        bordered: true,
        compact: true,
        dark: false,
        align_middle: true,
        class: 'table-primary',
        wrapper_class: 'mb-3',
    }
    only
%}
```

The table keeps Bootstrap's base `table` class. Additional classes let you use Bootstrap table variants or your own project styling.

## Numbered rows

```twig
{% include
    'components/data/table.twig'
    with {
        headers: ['Name', 'Email',],
        rows: [
            ['John Doe', 'john@example.com',],
            ['Jane Doe', 'jane@example.com',],
        ],
        numbered: true,
    }
    only
%}
```

The component adds a `#` header and numbers each row.

## HTML cells and escaping

For backward compatibility, cell values are rendered as raw HTML by default. This is useful for trusted application markup such as Bootstrap badges:

```twig
{% include
    'components/data/table.twig'
    with {
        headers: ['Name', 'Status',],
        rows: [
            [
                'John Doe',
                '<span class="badge text-bg-success">Active</span>',
            ],
        ],
    }
    only
%}
```

Only use raw cells with markup controlled by your application. Do not pass unsanitized user input as a cell value. For plain text or user-supplied values, use `escape_cells: true` so Twig escapes each cell:

```twig
{% include
    'components/data/table.twig'
    with {
        headers: ['Comment',],
        rows: user_comments,
        escape_cells: true,
    }
    only
%}
```

Header labels and captions are escaped by Twig. The legacy `footer` parameter and partials intentionally support authored markup and must also not contain unsanitized user input.

## Partials

Partials are optional. Without them, the component renders the complete header, rows, empty state and footer as appropriate.

### Header partial

`header_partial` supplies the `<th>` cells inside the existing `<tr>`; do not put a `<thead>` or `<tr>` in this partial.

```twig
{% include
    'components/data/table.twig'
    with {
        headers: ['Name', 'Status',],
        rows: [],
        header_partial: 'students/partials/table-header.twig',
    }
    only
%}
```

Example `students/partials/table-header.twig`:

```twig
<th scope="col">Student</th>
<th scope="col" class="text-end">Status</th>
```

### Row partial

`row_partial` is included once for each item in `rows`. It must render a complete `<tr>`. The `row_index` and `row_number` values start at 1 for the first item.

```twig
{% include
    'components/data/table.twig'
    with {
        headers: ['Name', 'Status',],
        rows: students,
        row_partial: 'students/partials/table-row.twig',
        numbered: true,
    }
    only
%}
```

Example `students/partials/table-row.twig`:

```twig
<tr>
    {% if numbered %}
        <td>{{ row_index }}</td>
    {% endif %}
    <td>{{ row.name }}</td>
    <td>
        {% if row.active %}
            <span class="badge text-bg-success">Active</span>
        {% else %}
            <span class="badge text-bg-secondary">Inactive</span>
        {% endif %}
    </td>
</tr>
```

For a row partial, access row fields using the shape of your data. The component does not assume that `rows` contains model objects or associative arrays.

### Body partial

Use `body_partial` when you need complete control over `<tbody>`. It must render rows or a custom empty state; the component supplies the surrounding `<tbody>` tags.

```twig
{% include
    'components/data/table.twig'
    with {
        headers: ['Name', 'Actions',],
        rows: students,
        body_partial: 'students/partials/table-body.twig',
    }
    only
%}
```

The body partial receives `headers`, `rows`, `numbered`, `empty_message` and `column_count`.

### Empty-state partial

`empty_partial` renders the content inside the empty-state table cell. The component provides the `<tr>`, `<td>`, correct `colspan` and Bootstrap empty-state classes.

```twig
{% include
    'components/data/table.twig'
    with {
        headers: ['Name', 'Email',],
        rows: [],
        empty_partial: 'students/partials/table-empty.twig',
    }
    only
%}
```

### Footer partial

`footer_partial` renders the `<tr>` rows inside `<tfoot>`. It takes precedence over the `footer` raw-HTML parameter.

```twig
{% include
    'components/data/table.twig'
    with {
        headers: ['Item', 'Amount',],
        rows: invoice_rows,
        footer_partial: 'invoices/partials/table-footer.twig',
    }
    only
%}
```

Example footer partial:

```twig
<tr>
    <td>Total</td>
    <td class="text-end">{{ total|number_format(2) }}</td>
</tr>
```

## Empty table

```twig
{% include
    'components/data/table.twig'
    with {
        headers: ['Name', 'Email',],
        rows: [],
        empty_message: 'No students match your search.',
        numbered: true,
    }
    only
%}
```

The empty-state cell's `colspan` is at least 1, even when no headers are supplied. Bootstrap styling and the responsive wrapper are included by default.
