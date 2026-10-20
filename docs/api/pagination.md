# Pagination

Pagination splits a long result set into smaller pages. If a task list has thousands of records, retrieving every row for a single HTML page or API response can consume unnecessary memory and bandwidth. Pagination asks the database for only the records needed for the current page and provides information to move to another page.

## Paginate a model query

```php
$tasks = Task::query()
    ->where('user_id', '=', auth()->id())
    ->orderBy('created_at', 'desc')
    ->paginate(10);
```

The query first limits the records to the signed-in user's tasks, orders them newest first, and then requests ten rows for the current page. `paginate(10)` returns a `Paginator`. Unless a page is supplied explicitly, the paginator can read the `page` query parameter from the current request URL.

For example, `/tasks?page=2` requests the second page. If the first page contains ten tasks, page two contains the next ten matching tasks.

## Show the current page in a Twig view

Pass the paginator to a view:

```php
return view('tasks/index', [
    'tasks' => $tasks,
]);
```

You can iterate over the paginator in Twig/PHP and use its state to render navigation controls. For reusable navigation markup, see the [Data Pagination Component](../components/data/pagination.md).

## Understand paginator values

| Method | What it means |
|---|---|
| `items()` / `getCollection()` | Records loaded for this page only. |
| `total()` | Total number of records matching the query across all pages. |
| `perPage()` | Requested page size. |
| `currentPage()` | Current page number, starting at 1. |
| `lastPage()` | Last page number based on the total and page size. |
| `hasPages()` | Whether more than one page is available. |
| `hasMorePages()` | Whether a next page exists. |
| `onFirstPage()` | Whether the current page is page 1. |
| `onLastPage()` | Whether this is the final page. |
| `nextPage()` / `previousPage()` | Adjacent page numbers when available. |
| `links()` / `pageLinks()` | Link data for rendering page navigation. |
| `meta()` | Pagination metadata. |

**Important:** `count()` tells you how many records are in the current page. It is not the total number of matching rows. Use `total()` when showing a total-result count.

## Return a paginated JSON response

A route can return the paginator as JSON:

```php
Route::get('/tasks', function () {
    $tasks = Task::query()
        ->where('user_id', '=', auth()->id())
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return response()->json($tasks);
});
```

The paginator serializes into an object with `data`, `links`, and `meta` keys. `data` contains the current page's records, `links` contains first/last/next/previous and page-number links, and `meta` contains values such as the current page, page size, total records, and last page. The response shape is similar to the following (record values and totals depend on the actual request). PixelFix currently generates relative query links such as `?page=2`; the `pages` field is keyed by page number, so JSON represents it as an object rather than a zero-based list:

```json
{
    "data": [
        {"id": 31, "title": "Write documentation"},
        {"id": 30, "title": "Review changes"}
    ],
    "links": {
        "first": "?page=1",
        "last": "?page=4",
        "next": "?page=3",
        "prev": "?page=1",
        "pages": {
            "1": "?page=1",
            "2": "?page=2",
            "3": "?page=3",
            "4": "?page=4"
        }
    },
    "meta": {
        "current_page": 2,
        "per_page": 10,
        "total": 37,
        "last_page": 4,
        "from": 11,
        "to": 20
    }
}
```

This is the paginator's JSON shape; it is not the same as a resource collection's JSON format. Treat the shown field values and URL form as illustrative; use the serialized paginator from your application as the contract for your endpoint.

If the API must expose only selected fields, map the current page's records through an API resource while preserving the pagination information in the response. See [API Resources](resources.md) and [JSON Responses](../http/json-responses.md).

## Empty pages and filtering

A page may be empty because no records match the query or because the requested page is beyond the last available page. `isEmpty()`, `isNotEmpty()`, `first()`, and `last()` inspect the current page's collection. When a filter comes from the user, apply it to the query before calling `paginate()` so both the page records and total count describe the same filtered result.

## Common mistakes

- **Calling `get()` before `paginate()`:** `get()` has already fetched the rows and does not create a paginator. Add conditions and ordering, then call `paginate()`.
- **Showing the page count as the total:** use `total()`, not `count()`.
- **Loading all rows and slicing them in PHP:** paginate at the query level so the database returns only the requested page.
