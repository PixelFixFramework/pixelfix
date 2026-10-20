# Task Manager Controllers

Controllers coordinate a request. They should not replace routing, validation, authorization, or model responsibilities; they connect those parts into one use case.

## The task controller's responsibilities

`TaskController` contains actions for listing tasks, showing the create form, storing a task, showing one task, editing, updating, and deleting. A common action has this flow:

1. Obtain the current user when ownership matters.
2. Find the requested record if the route contains an identifier.
3. Authorize the action through the controller's `authorize()` method.
4. Read validated data from a typed Form Request.
5. Ask the model to perform database work.
6. Return a view, redirect, or another HTTP response.

## A create action

The controller receives `StoreTaskRequest`, so PixelFix resolves the request's authorization and validation before the action uses its payload:

```php
public function store(StoreTaskRequest $request)
{
    $user = auth()->user();

    $this->authorize('create', Task::class);

    $data = $request->validated();
    $data['user_id'] = $user->id;
    $data['status'] = $data['status'] ?? 'pending';

    Task::create($data);

    flash('success', 'Task created successfully.');
    return redirect_to_route('tasks.index');
}
```

The code assigns `user_id` on the server so that form input cannot select another owner. `Task::create()` persists an allowed set of attributes and returns the created model; the controller then flashes a message and redirects instead of returning the whole HTML form response again.

## Show an existing task

The show/edit/update/delete actions must handle a missing task and authorize against the actual model instance. A route parameter is user-controlled input even if it matches the expected numeric pattern. Never assume that knowing a task ID proves ownership.

## Return JSON for an API endpoint

A controller can explicitly return JSON instead of a Twig view:

```php
public function indexJson()
{
    $user = auth()->user();
    $tasks = Task::query()
        ->where('user_id', $user->id)
        ->get();

    return response()->json($tasks);
}
```

This is an illustrative action; register a route to it and decide whether it should use authentication middleware. The ownership filter ensures the response only includes tasks for the current user. See [JSON Responses](../http/json-responses.md) before exposing model data through an API.

## Keep controllers understandable

If the same validation rules are repeated across controllers, move them into a Form Request. If the same ownership rule appears in several actions, keep it in a policy. If a query is reused, consider a model scope or a service. Avoid hiding a simple three-line operation behind many abstractions; extract code when doing so creates a clearer responsibility or reusable behavior.
