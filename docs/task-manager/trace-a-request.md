# Trace a Task Manager Request

The Task Manager is most useful as a framework learning tool when a complete request is followed through the system.

This example traces the task details page.

## Route declaration

The route is declared in `routes/web.php`:

```php
Route::get(
    '/tasks/{task:\\d+}',
    [
        TaskController::class,
        'show',
    ]
)->name('tasks.show');
```

The `\\d+` constraint means the dynamic `task` segment must be numeric.

## Web middleware

The route is inside the `web` middleware group, which currently contains:

```text
session
csrf
```

Because this request is a GET request, the CSRF middleware does not require a token. The session middleware still starts the session.

## Routing

The router matches the URI and stores the captured `task` value in the route parameter set.

PixelFix can then use route model binding to resolve a model from that parameter when the route/controller configuration requests it. The Task Manager also demonstrates explicit model lookup in controller code.

## Controller

The task controller obtains the authenticated user, checks the relevant policy, loads the requested task, and returns a view. The important separation is:

```text
HTTP orchestration → Controller
Authorization      → Policy
Data access        → Model / Query Builder
Presentation       → Twig View
```

## Model query

The current reference implementation resolves the task in a small controller helper:

```php
return Task::query()
    ->where('id', (int) $taskId)
    ->first();
```

The controller then passes the resolved model through `TaskPolicy::view()`. The policy is the authoritative ownership check for the page.

## Authorization

Policy checks use the framework authorization layer. The Task Manager's `TaskPolicy::view()` compares the task owner with the authenticated user's identity.

## View rendering

The controller renders:

```php
return view('tasks/show', [
    'task' => $task,
]);
```

Twig receives the `task` variable and the surrounding layout/components render the final HTML.

## Response

The controller returns an `HtmlResponse`. The HTTP kernel ultimately sends its headers and rendered content to the browser.

## Complete path

```text
Browser
  ↓
public/index.php
  ↓
Application bootstrap
  ↓
HTTP pipeline
  ↓
web middleware
  ↓
Router
  ↓
TaskController
  ├── authentication context
  ├── policy authorization
  └── ORM query
          ↓
       Task model
          ↓
       Database
  ↓
Twig view
  ↓
HtmlResponse
  ↓
Browser
```

This same mental model applies to the Task Manager's other browser workflows.
