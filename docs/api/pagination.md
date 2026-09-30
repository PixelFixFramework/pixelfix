# Pagination

PixelFix provides a paginator for paged query results and exposes both pagination state and JSON-friendly metadata.

## Paginating a query

The Query Builder exposes `paginate()`:

```php
$tasks = Task::query()
    ->where('user_id', auth()->id())
    ->orderBy('created_at', 'desc')
    ->paginate(10);
```

The model API also exposes `paginate()` through the model query builder.

## Paginator state

A paginator provides:

```php
$tasks->total();
$tasks->perPage();
$tasks->currentPage();
$tasks->lastPage();
$tasks->hasPages();
$tasks->hasMorePages();
$tasks->onFirstPage();
$tasks->onLastPage();
$tasks->nextPage();
$tasks->previousPage();
```

The current page items are available through `items()` or `getCollection()`. The paginator is also iterable.

## Page ranges and links

The paginator exposes:

```php
$tasks->pages();
$tasks->pageLinks();
$tasks->links();
$tasks->meta();
```

`meta()` contains current page, page size, total records, and last page. `links()` contains generated navigation links.

## Array and JSON output

Paginators are `JsonSerializable` and provide a JSON representation containing the page data, links, and pagination metadata.

```php
return json($tasks);
```

When using API resources, paginated resource collections can place transformed data under `data` while exposing pagination links and metadata alongside it.

## Working with items

Paginator collections support simple collection operations such as:

```php
$active = $tasks->filter(
    fn ($task) => $task->status === 'active'
);

$names = $tasks->map(
    fn ($task) => $task->title
);
```

These methods return a collection-derived value rather than changing the database query.

## Empty pages

Use:

```php
$tasks->isEmpty();
$tasks->isNotEmpty();
$tasks->count();
$tasks->first();
$tasks->last();
```

`from()` and `to()` expose the first and last displayed record positions when a page has items.

## API responses

For an API endpoint, a common pattern is to combine a paginator with a resource representation. Keep query construction, transformation, and HTTP response generation separate so each concern remains explicit.
