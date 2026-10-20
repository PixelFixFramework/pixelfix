# Route Model Binding

Route model binding takes a value from the URL, finds the matching database record, and passes the model object to your route handler or controller. It removes repetitive lookup code, but it does not replace authorization: finding a record does not prove that the current user may see or change it.

This guide uses a `Task` model and routes such as `/tasks/42`. It assumes the `tasks` table and `Task` model already exist.

## 1. Understand the problem it solves

Without model binding, every route action has to read the URL value and look up the task itself:

```php
use App\Models\Task;
use PixelFix\Framework\Routing\Route;

Route::get('/tasks/{task}', function (string $taskId) {
    $task = Task::find($taskId);

    if ($task === null) {
        abort(404, 'Task not found.');
    }

    return view('tasks/show', ['task' => $task]);
});
```

This is valid, but the same lookup and not-found check can be repeated in every action that needs a task.

## 2. Bind a route parameter to a model

Register a model binding before the routes that use it, normally in the appropriate route file:

```php
use App\Models\Task;
use PixelFix\Framework\Routing\Route;

Route::model('task', Task::class);

Route::get('/tasks/{task}', function (Task $task) {
    return view('tasks/show', ['task' => $task]);
});
```

Here is how the pieces fit together:

1. `{task}` names the URL parameter.
2. `Route::model('task', Task::class)` tells PixelFix which model to resolve for that parameter.
3. The handler's `Task $task` type declaration tells the parameter resolver that it needs a `Task` model.
4. PixelFix looks up the record using the model's route key and passes the model into the handler.
5. If the record cannot be found, binding produces a `404 Not Found` response instead of passing `null` to the action.

With this route, `/tasks/42` resolves task 42 when it exists. The parameter name matters: the route parameter `{task}`, binding name `task`, and handler argument `$task` must agree.

## 3. Use a custom lookup

Use `Route::bind()` when the value in the URL should be looked up differently—for example, when URLs use a task slug instead of its numeric ID:

```php
Route::bind('task', function ($value) {
    return Task::query()
        ->where('slug', '=', $value)
        ->first();
});

Route::get('/tasks/{task}', function (Task $task) {
    return view('tasks/show', ['task' => $task]);
});
```

The callback receives the raw route value. Return an instance of the expected model. If the lookup returns `null`, PixelFix responds with `404 Not Found`. If the custom resolver returns a value of the wrong type, the framework treats that as a binding error.

A slug should be unique and indexed in the database. If the model already has a custom route key configured, the default `Route::model()` binding can use that route key without a custom callback.

## 4. Configure a model's route key

Models use their primary key (`id` by default) as the route key unless a custom route key is configured. In a model, the framework supports a `routeKey` property:

```php
class Task extends Model
{
    protected static ?string $routeKey = 'slug';
}
```

After this is configured, the default binding can resolve `/tasks/write-better-docs` using the `slug` column. Ensure the column exists, is unique for the records being routed, and has an index. Do not change the route key unless you intend URLs and binding lookups to use that field.

## 5. Binding is not authorization

A user may change `/tasks/42` to `/tasks/43`. Binding only checks whether task 43 exists; it does not check whether the signed-in user owns it. Protect the operation with a policy/gate or an ownership-scoped query before showing or changing private data.

For example, an ownership-scoped lookup can constrain the query to the current user:

```php
$task = Task::query()
    ->where('id', '=', $taskId)
    ->where('user_id', '=', auth()->id())
    ->first();

if ($task === null) {
    abort(404, 'Task not found.');
}
```

If you use implicit or explicit binding, enforce the same ownership rule in authorization logic; do not assume the binding itself applies it.

## 6. Nested routes and scoped binding

For nested URLs such as `/users/7/tasks/42`, checking only that both records exist is not enough. You must also ensure task 42 belongs to user 7. PixelFix supports scoped binding through route/group configuration and model relationships, but the parent-child relation must be configured correctly. If you are not deliberately using scoped bindings, perform an explicit ownership check instead.

## Troubleshooting

- **The handler receives a missing model response:** confirm `{task}`, `Route::model('task', ...)`, and the `$task` argument use the same name.
- **A valid-looking URL returns 404:** check the configured route key, database row, ordinary model global scopes, and whether the record is soft-deleted.
- **A user can access someone else's record:** binding is not authorization; add an ownership check or policy.
- **The binding callback gives a server error:** return an instance of the declared model type or `null`, and verify the queried column exists.

Related topics: [Routing](routing.md), [Authorization](../authorization/overview.md), [Models](../database/models.md), and [Soft Deletes](../database/soft-deletes.md).
