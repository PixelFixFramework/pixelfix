# Helper Reference

The framework autoloads `src/Support/helpers.php`, which provides small global helpers for common application operations.

## URL and routing helpers

```php
url('/tasks');
route('tasks.show', [$task->id]);
redirect('/tasks');
redirect('tasks.index');
redirect_to_route('tasks.index');
redirect_back('/tasks/index');
redirect_intended('/');
base_url();
asset('css/app.css');
```

`redirect()` accepts a URL path, an absolute external URL, or a named route. `redirect_to_route()` is the explicit named-route form.

## Authentication

```php
auth();
guest();
```

`auth()` returns the framework authentication manager. Common calls include:

```php
auth()->check();
auth()->user();
auth()->id();
auth()->attempt($credentials);
auth()->login($user);
auth()->logout();
```

## Validation

```php
validate($data, $rules);
old('email');
errors();
error('email');
has_error('email');
clear_validation_state();
```

The validation helpers read and write the flash-backed validation state used by browser form workflows.

## CSRF

```php
csrf_token();
csrf_field();
verify_csrf($request);
regenerate_csrf_token();
```

`csrf_field()` returns a hidden input containing the current session token.

## Sessions and flash data

```php
session();
flash('success', 'Saved.');
get_flash();
flash_messages();
with_input($input);
set_intended_url('/tasks');
intended_url('/');
```

## Container and configuration

```php
app();
app(SomeService::class);
config('app.name');
env('APP_ENV', 'production');
environment();
environment('local');
```

`app()` without an argument returns the container. With a class/service name it resolves the service through the container.

## Database

```php
db();
schema();
```

`db()` returns the framework database manager. `schema()` returns the schema API.

## Views and escaping

```php
view('tasks/index', $data);
e($value);
```

`view()` renders the named view and returns an `HtmlResponse`. `e()` HTML-escapes a value with `htmlspecialchars()`.

## JSON and responses

```php
json($data, 200);
response();
```

`response()` resolves the response factory. `json()` creates a `JsonResponse` directly.

## HTTP exceptions

```php
abort(404, 'Task not found.');
abort_if($condition, 403);
abort_unless($condition, 401);
```

These helpers throw the framework HTTP exception used by the exception handler.

## Collections

```php
collect($items);
```

The helper returns the framework `Collection` abstraction and leaves existing `Collection` instances unchanged.

## Logging and storage

```php
logger();
storage();
report($exception);
```

These resolve the framework's logger, storage manager, and exception reporting service.

## Utility helpers

The helper file also contains small internal utilities such as class/trait traversal and wildcard string matching. Application code should normally use them only where their documented behavior is directly useful.

## Global helper availability

Global helpers are registered through Composer's `autoload.files` entry for `src/Support/helpers.php`. They are therefore available to framework applications after Composer autoloading is initialized.
