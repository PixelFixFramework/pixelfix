# Building the Task Manager with PixelFix

The Task Manager is PixelFix's reference application. This tutorial follows the same architectural path as the uploaded application: establish the application, create the database layer, add authentication, add task CRUD, protect it with authorization, render the UI, and then test the resulting behavior.

## 1. Create the application

The current PixelFix CLI can generate an application directly from the framework repository:

```bash
php pixelfix new task-manager
cd task-manager
composer install
```

The generated application contains the standard PixelFix directories, including `app`, `bootstrap`, `config`, `database`, `public`, `resources`, `routes`, and `tests`.

## 2. Configure the environment

Create the local environment file:

```bash
cp .env.example .env
```

The Task Manager can use SQLite for local development. Its active configuration is held in `config/config.php`, while environment variables select deployment-specific values.

## 3. Create the database schema

The reference application contains migrations for:

```text
users
tasks
```

The task table stores ownership through `user_id` and includes title, description, status, due date, timestamps, and soft-delete state.

Run:

```bash
php pixel migrate
```

Inspect migration state with:

```bash
php pixel migrate:status
```

## 4. Add factories and seeders

The Task Manager contains:

```text
UserFactory
TaskFactory
DatabaseSeeder
UserSeeder
TaskSeeder
```

Seed development data with:

```bash
php pixel db:seed
```

Factories describe how model instances are generated; seeders orchestrate application data setup.

## 5. Build the User model

The `User` model implements PixelFix's authentication contract and uses the framework's `Authenticatable` support together with soft deletes.

This allows the authentication system to resolve the current user through the configured provider.

## 6. Build the Task model

The current Task model uses:

```php
protected static string $table = 'tasks';

protected static array $fillable = [
    'user_id',
    'title',
    'description',
    'status',
    'due_date',
];
```

The model defines the relationship back to its owner:

```php
public function user(): BelongsTo
{
    return $this->belongsTo(
        User::class,
        'user_id'
    );
}
```

## 7. Add authentication routes

The reference application exposes:

```text
GET  /register
POST /register
GET  /login
POST /login
POST /logout
```

All browser routes are placed inside the `web` middleware group.

## 8. Validate authentication input

`RegisterUserRequest` protects registration input, while `LoginRequest` protects login input. Their controllers receive the FormRequest objects rather than reading unvalidated payloads directly.

The controller pattern is:

```php
$data = $request->validated();
```

## 9. Authenticate the user

The login action validates credentials and calls the configured authentication facade/helper:

```php
$authenticated = auth()->attempt([
    'email' => $credentials['email'],
    'password' => $credentials['password'],
]);
```

A successful login redirects to the task list. Logout clears authentication state and redirects to the home route.

## 10. Define task routes

The Task Manager defines these task actions:

```text
GET     /tasks/index
GET     /tasks/create
POST    /tasks
GET     /tasks/{task}
GET     /tasks/{task}/edit
PUT     /tasks/{task}
DELETE  /tasks/{task}
```

The `{task}` parameter is constrained to numeric values:

```php
'/tasks/{task:\\d+}'
```

The routes are named, allowing controllers and Twig templates to generate URLs without hard-coding paths.

## 11. Build the task controller

`TaskController` follows a consistent flow.

For collection access:

```php
$this->authorize(
    'viewAny',
    Task::class
);
```

Then it queries tasks for the authenticated user:

```php
$tasks = Task::query()
    ->where('user_id', $user->id)
    ->orderBy('created_at', 'desc')
    ->get();
```

For creation, the controller validates, authorizes, assigns the server-owned `user_id`, creates the model, flashes a success message, and redirects.

## 12. Protect task creation

`StoreTaskRequest` currently validates:

```php
return [
    'title' => 'required|string|max:255',
    'description' => 'required|string',
    'status' => 'required|in:pending,in_progress,completed',
    'due_date' => 'required|date',
];
```

Its authorization layer requires an authenticated user:

```php
public function authorize(): bool
{
    return auth()->check();
}
```

The controller still performs the domain-level policy authorization for the create operation.

## 13. Protect ownership with TaskPolicy

`TaskPolicy` owns the task-level authorization decisions. A typical ownership rule is:

```php
public function update(User $user, Task $task): bool
{
    return (int) $task->user_id
        === (int) $user->getAuthIdentifier();
}
```

The controller invokes the policy through:

```php
$this->authorize('update', $taskModel);
```

This keeps ownership rules centralized rather than duplicating them in every controller action.

## 14. Protect the admin gate

The application also demonstrates a named gate in `AuthServiceProvider`:

```php
Gate::define(
    'access-admin',
    function ($user): bool {
        return $user->role === 'admin';
    }
);
```

A route can authorize that gate with:

```php
Gate::authorize('access-admin');
```

## 15. Render the task pages with Twig

The controller renders templates through the framework view helper:

```php
return view(
    'tasks/show',
    [
        'task' => $taskModel,
    ]
);
```

The application's view tree contains layouts, authentication templates, task templates, and reusable components.

Forms use the framework's CSRF support and named-route helpers so the presentation layer remains tied to the application's routing configuration without hard-coded URLs.

## 16. Run the finished application

Start the development server:

```bash
php pixel serve
```

Then exercise the application in this order:

```text
Register
  ↓
Login
  ↓
Open task list
  ↓
Create task
  ↓
View task
  ↓
Edit task
  ↓
Update task
  ↓
Delete task
```

## 17. Trace a request

For `GET /tasks/{id}`, the conceptual path is:

```text
Browser
  ↓
public/index.php
  ↓
Application bootstrap
  ↓
HTTP kernel / middleware
  ↓
Router
  ↓
TaskController::show()
  ↓
Task lookup
  ↓
TaskPolicy::view()
  ↓
Twig template
  ↓
HTTP response
```

See [Trace a Task Manager Request](trace-a-request.md) for the same flow explained as a debugging walkthrough.

## 18. Add application tests

The Task Manager already contains the PixelFix test bootstrap and application `TestCase`, but the uploaded reference snapshot currently contains no discovered application test classes.

The next natural test cases are:

```text
registration succeeds
invalid registration is rejected
login succeeds with valid credentials
invalid login is rejected
users can only view their own tasks
task creation validates required fields
users can update their own tasks
users cannot update another user's task
users can delete their own tasks
```

Those tests should exercise application behavior through the framework testing facilities rather than duplicate PixelFix's own framework unit tests.

## What this application demonstrates

The Task Manager puts the major PixelFix concepts together without requiring them to be treated as one monolithic subsystem:

```text
Routes
  ↓
Middleware
  ↓
Controllers
  ├── FormRequests → Validation
  ├── Policies     → Authorization
  ├── Models       → ORM / Database
  └── Views        → Twig
```

That separation is the central design lesson of the reference application.
