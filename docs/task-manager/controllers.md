# Task Manager: Controllers

The Task Manager has four application controllers:

```text
app/Http/Controllers/
├── AuthController.php
├── HomeController.php
├── TaskController.php
└── UserController.php
```

## TaskController

`TaskController` is the main CRUD example. Its public actions are:

```text
index
create
store
show
edit
update
destroy
```

### Index

The index action:

1. obtains the authenticated user;
2. authorizes the `viewAny` ability for `Task`;
3. queries tasks belonging to that user;
4. orders them by creation time descending;
5. calculates dashboard counters;
6. renders `tasks/index`.

The ownership filter is explicit:

```php
Task::query()
    ->where('user_id', $user->id)
    ->orderBy('created_at', 'desc')
    ->get();
```

## Create and store

`create()` authorizes the `create` ability and renders the form.

`store()` accepts a `StoreTaskRequest`, authorizes creation again for the actual write operation, and persists only validated input.

The controller then assigns ownership from the authenticated user:

```php
$data['user_id'] = auth()->user()->id;
```

This is an important application boundary: ownership is not accepted from the submitted form.

## Show, edit, update, destroy

The remaining actions resolve the task, handle missing records, authorize the operation against the concrete model, and then render, update, or delete as appropriate.

The authorization calls are action-specific:

```php
$this->authorize('view', $taskModel);
$this->authorize('update', $taskModel);
$this->authorize('delete', $taskModel);
```

After a successful update or delete, the controller uses a flash message and redirects to another named route.

## Response patterns

The Task Manager demonstrates three common controller responses:

```php
return view('tasks/show', [
    'task' => $taskModel,
]);
```

```php
return redirect_to_route('tasks.index');
```

```php
return redirect_to_route('tasks.show', [
    $taskModel->id,
]);
```

This keeps read operations server-rendered while state-changing operations finish with redirects.
