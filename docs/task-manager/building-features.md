# Building Features in Task Manager

The Task Manager is the reference application used throughout the PixelFix documentation. Its structure shows how a feature moves from a route to a controller, validation, authorization, persistence, and views.

## The task feature

The current task feature contains:

```text
routes/web.php
    ↓
TaskController
    ↓
StoreTaskRequest / UpdateTaskRequest
    ↓
TaskPolicy
    ↓
Task model
    ↓
tasks migration
    ↓
Twig task views
```

## Create flow

The create screen is exposed by `GET /tasks/create` and the submitted form by `POST /tasks`.

The controller receives the typed request:

```php
public function store(StoreTaskRequest $request)
```

The validated payload is obtained with:

```php
$data = $request->validated();
```

The controller then associates the task with the authenticated user and creates the model:

```php
$data['user_id'] = $user->id;
Task::create($data);
```

## Update flow

The update endpoint is:

```text
PUT /tasks/{task}
```

The request is validated through `UpdateTaskRequest` and the controller authorizes the current user against the task before saving the changes.

## Delete flow

The delete endpoint is:

```text
DELETE /tasks/{task}
```

The controller authorizes the operation through `TaskPolicy` and then calls the model's delete behavior. Because `Task` uses `SoftDeletes`, this is a soft delete.

## Why this structure matters

The reference application intentionally separates concerns:

- routes describe HTTP entry points;
- controllers coordinate use cases;
- FormRequests authorize and validate request input;
- policies express access rules;
- models represent persisted data and relationships;
- views render the result.

This is the core MVC-oriented workflow that the rest of the PixelFix documentation builds on.
