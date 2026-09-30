# Query Scopes

PixelFix's model/query layer supports global scopes and query composition.

## Global scopes

A model can register a global scope with:

```php
ModelClass::addGlobalScope(
    'active',
    function (QueryBuilder $query) {
        $query->where('active', true);
    }
);
```

Global scopes are automatically applied to the model's queries unless they are explicitly removed.

## Removing scopes

The query builder supports:

```php
$query->withoutGlobalScope('active');
$query->withoutGlobalScopes();
```

Use scope removal deliberately because it changes the normal visibility rules of the model.

## Practical use

Global scopes are useful for cross-cutting model constraints such as tenant boundaries or default visibility. Domain-specific filtering that belongs to an individual use case is often clearer as an ordinary query:

```php
Task::query()
    ->where('status', 'pending')
    ->get();
```
