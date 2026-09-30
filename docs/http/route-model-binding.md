# Route Model Binding

PixelFix can resolve route parameters to model instances before controller execution.

## Explicit model binding

Register a model binding by parameter name:

```php
Route::model(
    'task',
    Task::class
);
```

The framework resolves the parameter using the model's route key.

## Custom bindings

For a custom lookup rule:

```php
Route::bind(
    'slug',
    function ($value) {
        return Article::query()
            ->where('slug', $value)
            ->first();
    }
);
```

## Model route keys

Models expose:

```php
$task->getRouteKey();
Task::getRouteKeyName();
```

By default the model's primary route key is used. A model can customize its route key behavior through the model API.

## Relation-scoped bindings

The routing layer also supports binding scopes:

```php
Route::scope('task', 'user');
Route::scopeBindings();
```

Use relation scoping when nested resources must be resolved within a parent relationship rather than globally.

## Practical guidance

Use route model binding when the controller should operate on a model instance rather than repeat the same lookup logic. Keep the route parameter name aligned with the controller argument and the binding registration.
