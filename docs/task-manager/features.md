# Task Manager Feature Map

The Task Manager is a reference application that demonstrates how PixelFix features work together. Use this page as a map; the linked guides explain the implementation step by step.

## Public pages and authentication

The root route (`GET /`) displays the welcome page. Guests can view the registration and login forms and submit those forms through `POST /register` and `POST /login`. Signed-in users are redirected away from guest-only authentication pages. Logout uses `POST /logout` so it changes session state through a state-changing request protected by the `web` middleware group.

## Task-management workflow

The application exposes these task routes:

| Method | Path | Purpose |
|---|---|---|
| `GET` | `/tasks/index` | List the signed-in user's tasks |
| `GET` | `/tasks/create` | Display the task form |
| `POST` | `/tasks` | Validate and save a new task |
| `GET` | `/tasks/{task}` | Display one task |
| `GET` | `/tasks/{task}/edit` | Display the edit form |
| `PUT` | `/tasks/{task}` | Validate and save changes |
| `DELETE` | `/tasks/{task}` | Delete a task (soft delete in this app) |

The `{task}` segment is constrained to digits. Named routes such as `tasks.show` let templates generate URLs without hard-coding the path.

## Where each responsibility lives

- `routes/web.php` maps an HTTP method and URL to an action.
- `TaskController` coordinates the use case: find the record, authorize it, read validated input, persist the change, and choose the response.
- `StoreTaskRequest` and `UpdateTaskRequest` authorize and validate submitted fields.
- `TaskPolicy` checks whether the signed-in user may access or change the task.
- `Task` represents stored task rows and defines the relation to `User`.
- migrations define the `users` and `tasks` tables.
- Twig views and reusable components display the pages and validation feedback.

## Try the application as a user

1. Open `/register` and create an account.
2. Sign in at `/login`.
3. Open `/tasks/create`, enter a title and the required fields, then submit.
4. Return to `/tasks/index` and open the task you created.
5. Edit the task and save it.
6. Try signing out and opening a task URL. The route's authentication middleware should prevent an unauthenticated request from reaching the task action.

The exact behavior depends on the app's environment and database being configured and migrated. Do not test ownership protection using only one account: create a second user to verify that the first user cannot access the second user's task.

## Continue learning

- [Quick Start](quick-start.md) runs the application.
- [Trace a Request](trace-a-request.md) explains what happens during one HTTP request.
- [Building Features](building-features.md) walks through the create/update/delete flow.
- [Authentication](authentication.md), [Validation](validation.md), and [Authorization](authorization.md) explain the critical security boundaries.
