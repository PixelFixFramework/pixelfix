# Trace a Task Manager Request

This walkthrough shows how to follow a request across the framework, instead of treating a controller as magic. We'll trace `GET /tasks/12` (replace `12` with a real task ID in your local database).

## 1. The browser sends a request

The browser requests `GET /tasks/12`. The HTTP method and URL must match a route declaration. A route is not just a PHP method: it also carries a path, name, and middleware configuration.

## 2. The router matches the route

`routes/web.php` declares `/tasks/{task:\d+}` and points it to `TaskController::show()`. The `\d+` constraint means the parameter is expected to contain digits. A non-numeric path will not match this route.

## 3. Middleware runs

The route is inside the `web` and `auth` groups. The web middleware establishes browser session/CSRF behavior; the auth middleware prevents an unauthenticated request from continuing to the protected action. Middleware can reject or modify a request before the controller runs.

## 4. The controller looks up the record

`TaskController::show()` receives the route identifier, calls its task lookup helper, and handles a missing record before rendering. Finding a record is not authorization: a valid ID can belong to another user.

## 5. The policy checks ownership

The controller calls `authorize('view', $taskModel)`. PixelFix resolves the registered `TaskPolicy` and calls the relevant ability with the current user and task. The reference policy allows viewing only if the task's `user_id` matches the authenticated user's identifier. A denied decision stops normal rendering.

## 6. The controller returns a view

After the lookup and authorization succeed, the controller calls:

```php
return view('tasks/show', [
    'task' => $taskModel,
]);
```

The string `tasks/show` points to `resources/views/tasks/show.twig`. The array makes the model available in Twig as `task`.

## 7. Twig composes the page

The page extends the application layout and includes reusable components for the task details and actions. The template presents values; database lookup, authorization, and persistence remain in the PHP layer.

## What to inspect when it fails

- 404: confirm the route matches and the task ID exists.
- Redirect to login: the request was not authenticated.
- Forbidden response: the policy denied the operation.
- Blank or malformed page: check the view name, Twig syntax, and variables passed to `view()`.
- Database error: verify migrations, connection settings, and the task row.

Try the same trace for `PUT /tasks/12`: it adds request validation and persistence after authorization. See [Routing](routing.md), [Authentication](authentication.md), and [Authorization](authorization.md).
