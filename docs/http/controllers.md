# Controllers

Controllers organize request handling around application actions. PixelFix provides an abstract `Controller` base class at `PixelFix\\Framework\\Http\\Controllers\\Controller`.

## Creating a controller

Use the generator from the project root:

```bash
php pixelfix make:controller TaskController
```

A controller normally lives under `app/Http/Controllers` and extends the framework base controller:

```php
namespace App\Http\Controllers;

use PixelFix\Framework\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function index()
    {
        // ...
    }
}
```

## Controller actions

An action is a public method referenced by a route:

```php
Route::get(
    '/tasks',
    [TaskController::class, 'index']
);
```

Actions may return a view response, redirect response, JSON response, or another supported response object.

For example:

```php
public function index()
{
    $tasks = Task::query()->get();

    return view(
        'tasks/index',
        [
            'tasks' => $tasks,
        ]
    );
}
```

## Dependency injection

The base `Controller` receives these framework services through its constructor:

```php
protected Request $request;
protected QueryBuilder $query;
protected Environment $twig;
```

Application controllers inherit access to them through protected helper methods:

```php
$this->request();
$this->query();
$this->twig();
```

Action parameters can also be resolved as part of route/controller dispatch. A common application pattern is to type-hint a FormRequest in an action:

```php
public function store(
    StoreTaskRequest $request
) {
    $data = $request->validated();

    // ...
}
```

## Rendering a view

PixelFix provides the global `view()` helper:

```php
return view(
    'tasks/show',
    [
        'task' => $task,
    ]
);
```

The controller base class also provides `render()`:

```php
return $this->render(
    'tasks/show',
    [
        'task' => $task,
    ]
);
```

The global helper resolves `ViewFactory` and returns an `HtmlResponse`. The base controller's `render()` method renders through the injected Twig environment and wraps the output in an `HtmlResponse`.

## Redirects

Controllers commonly redirect after state-changing operations:

```php
return redirect_to_route(
    'tasks.index'
);
```

A route parameter can be supplied:

```php
return redirect_to_route(
    'tasks.show',
    [$task->id]
);
```

## Controller middleware

Controllers can register middleware in the controller definition:

```php
protected function boot(): void
{
    $this->middleware('auth')
        ->only(['index', 'create', 'store']);
}
```

The `middleware()` method returns a `ControllerMiddlewareOptions` object supporting:

```php
->only('index')
->except(['show', 'edit'])
```

Controller middleware is stored with action filters and is resolved as part of controller dispatch.

Route middleware and controller middleware are separate mechanisms. Use route middleware for route-level or grouped concerns; use controller middleware when the middleware belongs to selected actions of a controller.

## Authorization in controllers

The base controller uses the framework authorization trait, so controllers can call:

```php
$this->authorize(
    'update',
    $task
);
```

This is particularly useful when an action operates on a concrete model instance. For class-level abilities, pass the model class:

```php
$this->authorize(
    'create',
    Task::class
);
```

See the authorization documentation for policy registration and ability resolution.

## Route parameters in actions

If a route declares a parameter, it may be accepted by the action:

```php
Route::get(
    '/tasks/{task:\\d+}',
    [TaskController::class, 'show']
);
```

The application can receive the route parameter as an action argument:

```php
public function show(int|string $task)
{
    // ...
}
```

Alternatively, use the request route parameter API when that better matches the action design.

## Boot hook

The base controller calls `boot()` from its constructor. Application controllers can override this protected method for controller-specific initialization:

```php
protected function boot(): void
{
    // Controller-specific initialization.
}
```

Keep request-dependent behavior in actions or middleware unless initialization is genuinely shared across the controller.

## Task Manager example

`TaskController` demonstrates the intended application structure. Its actions:

- authorize the requested operation;
- query the `Task` model;
- render Twig views for read operations;
- accept `StoreTaskRequest` and `UpdateTaskRequest` for writes;
- use validated data instead of the raw request payload;
- assign ownership server-side using the authenticated user;
- redirect after successful writes;
- use flash messages for user feedback.

A simplified create flow is:

```php
public function store(
    StoreTaskRequest $request
) {
    $this->authorize(
        'create',
        Task::class
    );

    $data = $request->validated();

    $data['user_id'] = auth()->user()->id;

    Task::create($data);

    flash(
        'success',
        'Task created successfully.'
    );

    return redirect_to_route(
        'tasks.index'
    );
}
```

The important boundary is that validation and authorization occur before the model is modified, and ownership is derived from the authenticated user rather than trusting submitted input.
