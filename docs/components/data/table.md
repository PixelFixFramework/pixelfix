# Table

Renders a responsive Bootstrap table from header and row collections.

**Component:** `components/data/table.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `headers` | `[]` | Array of column header labels. |
| `rows` | `[]` | Array of row arrays. Each cell is rendered as raw HTML. |
| `caption` | `null` | Optional table caption. |
| `footer` | `null` | Optional raw HTML table footer. |
| `responsive` | `true` | Wraps the table in a responsive container when enabled. |
| `striped` | `true` | Applies Bootstrap striped rows. |
| `hover` | `true` | Applies Bootstrap hover rows. |
| `bordered` | `false` | Applies Bootstrap borders. |
| `compact` | `false` | Applies Bootstrap compact table styling. |
| `dark` | `false` | Applies the Bootstrap dark table theme. |
| `numbered` | `false` | Adds a numbered column before the supplied headers. |
| `emptyMessage` | `No records found.` | Message displayed when `rows` is empty. |

---

## Row Data

Each item in `rows` is an array of cells.

Cell values are rendered using `|raw`.

Example:

```twig
{% set rows = [
    [
        'John Doe',
        'john@example.com',
        '<span class="badge text-bg-success">Active</span>'
    ],
    [
        'Jane Doe',
        'jane@example.com',
        '<span class="badge text-bg-secondary">Inactive</span>'
    ]
] %}
```

---

# Usage

```twig
{% set headers = [
    'Name',
    'Email',
    'Status'
] %}

{% set rows = [
    [
        'John Doe',
        'john@example.com',
        '<span class="badge text-bg-success">Active</span>'
    ],
    [
        'Jane Doe',
        'jane@example.com',
        '<span class="badge text-bg-secondary">Inactive</span>'
    ]
] %}

{% include
    'components/data/table.twig'
    with {
        headers:
            headers,

        rows:
            rows,

        caption:
            'Users',

        responsive:
            true,

        striped:
            true,

        hover:
            true,

        bordered:
            false,

        compact:
            false,

        dark:
            false,

        numbered:
            true,

        emptyMessage:
            'No users found.'
    }
    only
%}
```

---

## Footer

The `footer` parameter accepts raw HTML and is rendered inside `<tfoot>`.

```twig
{% set footer %}
<tr>
    <td colspan="4">Total: 2 users</td>
</tr>
{% endset %}
```

---

## Empty State

When `rows` is empty, the component displays `emptyMessage`.

```twig
{% include
    'components/data/table.twig'
    with {
        headers:
            ['Name', 'Email']

        rows:
            []

        emptyMessage:
            'No users found.'
    }
    only
%}
```
