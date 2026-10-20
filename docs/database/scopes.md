# Query Scopes

A **scope** adds a reusable rule to a database query. PixelFix supports global scopes, which are applied automatically to a model's queries, and ordinary query conditions, which you add only when a particular operation needs them.

## Global scopes

Use a global scope for a rule that should apply whenever a model is queried—for example, hiding inactive records by default. A model can register a named scope with `addGlobalScope()`:

```php
use PixelFix\Framework\Database\Query\QueryBuilder;

class Task extends Model
{
    protected static string $table = 'tasks';

    protected static function boot(): void
    {
        static::addGlobalScope(
            'active',
            function (QueryBuilder $query) {
                $query->where('active', '=', true);
            }
        );
    }
}
```

The registered callback receives a query builder and adds a condition to it. With this scope, a normal `Task::query()->get()` includes only rows where `active` is true. Confirm the model lifecycle hook and `addGlobalScope()` signature against your installed version when registering scopes in a custom base model.

## Why a global scope affects results

Suppose the `tasks` table contains active and archived rows. A global scope causes ordinary model queries to hide the archived rows even when the call site does not explicitly mention `active`. This is convenient for a rule that should always apply, but it can surprise a developer who expects every database row to be returned.

Use global scopes only for genuinely model-wide rules. A tenant boundary or soft-delete rule may need to apply everywhere; a filter like “show pending tasks on this screen” usually belongs in that screen's query instead.

## Remove a named scope deliberately

The query builder exposes:

```php
$allTasks = Task::query()
    ->withoutGlobalScope('active')
    ->get();
```

`withoutGlobalScope('active')` removes only the named scope from that query. It does not permanently change the model's configuration. The removal applies to the query being built.

To remove every registered global scope:

```php
$tasks = Task::query()
    ->withoutGlobalScopes()
    ->get();
```

Removing all scopes can bypass important visibility rules, including soft-delete constraints. Do this only when the operation is specifically intended to access those records and is protected by appropriate authorization.

## Prefer an ordinary query for one-off filters

For filters that vary by user action, add conditions directly:

```php
$pendingTasks = Task::query()
    ->where('status', '=', 'pending')
    ->where('user_id', '=', auth()->id())
    ->orderBy('created_at', 'desc')
    ->get();
```

This query applies the `pending` and ownership filters only to this operation. It is easier for another developer to understand why those rows are selected because the conditions are visible at the place the query is written.

## Debugging unexpected query results

If records are missing, check for global scopes before rewriting the query. Look for scopes registered by the model or inherited conventions, and remember that soft deletes are implemented through a global scope. Temporarily removing a scope may help diagnose a query, but do not leave a visibility bypass in production code without a clear reason.
