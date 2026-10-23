# Helper Reference

PixelFix autoloads `src/Support/helpers.php`, which provides global helpers for common application operations. A global helper can be called without importing a class, but you still need to pass the documented arguments and understand what the helper returns.

## URL and routing helpers

```php
url('/tasks');
route('tasks.show', [$task->id]);
redirect('/tasks');
redirect_to_route('tasks.index');
redirect_back('/tasks/index');
redirect_intended('/');
base_url();
asset('css/app.css');
```

`url()` builds an application URL, `route()` creates a URL from a named route, and `asset()` creates a URL for a public asset. `redirect()` returns a redirect response to a path or URL; `redirect_to_route()` is the explicit named-route form. `redirect_back()` uses a suitable request referrer or the supplied fallback. `redirect_intended()` uses a destination stored by the authentication flow and falls back to the supplied path.

## Authentication helpers

```php
auth()->check();
auth()->user();
auth()->id();
auth()->attempt($credentials);
auth()->login($user);
auth()->logout();
guest();
```

`auth()` returns the configured authentication manager. `check()` asks whether the current request has an authenticated user; `user()` returns that user or `null`; `id()` returns the authenticated user's identifier when available. `attempt()` checks credentials through the configured guard/provider. `login()` establishes authenticated state, and `logout()` clears it. Authentication answers who the requester is; authorization still needs to decide which actions that person may perform.

## Validation helpers

```php
validate($data, $rules);
old('email');
errors();
error('email');
has_error('email');
clear_validation_state();
```

`validate()` runs the supplied data through the provided validation rules and returns validated data when validation succeeds; on browser form flows, validation failures are represented through the framework's validation mechanism. `old()` retrieves flashed input, `errors()` returns the current validation errors, `error('email')` retrieves a field's message, and `has_error('email')` checks whether that field has one. These helpers are most useful for returning to a form after invalid submission. Read [Validation Requests](../validation/requests.md) for how validated data moves from a request into a controller.

## CSRF helpers

```php
csrf_token();
csrf_field();
verify_csrf($request);
regenerate_csrf_token();
```

`csrf_field()` produces a hidden HTML input containing the current session token. Use it inside a state-changing browser form. `verify_csrf()` checks a request against the token expected by the framework, and `regenerate_csrf_token()` renews the token when the application needs to rotate it. See [CSRF Protection](../http/csrf.md).

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

`session()` accesses session storage. `flash()` stores short-lived data for the next request; it is commonly used for a success/error banner after a redirect. `with_input()` flashes safe prior form input, while `set_intended_url()` and `intended_url()` support the destination a user should visit after authentication. Do not flash passwords or other secrets.

## Container and configuration

```php
app();
app(SomeService::class);
config('app.name');
env('APP_ENV', 'production');
environment();
environment('local');
```

`app()` without an argument gives access to the application container; passing a class/service name asks the container to resolve it. `config()` reads configuration, `env()` reads an environment value with a fallback, and `environment()` reports or checks the active environment. Use configuration values in application code and reserve direct environment reads for configuration/bootstrap decisions where appropriate.

## PDF and spreadsheet exports

The framework provides `exports()` as a central access point for the optional export adapters:

```php
$pdfBytes = exports()->pdf()->renderView('reports/statement', ['statement' => $statement]);
$xlsxBytes = exports()->spreadsheet()->generate($rows, ['headers' => ['Name', 'Email']]);
```

Install `dompdf/dompdf` for PDF output and/or `phpoffice/phpspreadsheet` for spreadsheet output. Neither package is required during framework boot if your application does not use that export type. See [PDF and Spreadsheet Exports](../exports/overview.md) for supported formats, options and security boundaries.

## Database helpers

```php
$database = db();
$schema = schema();
```

`db()` returns the database manager; use it when you need a connection-level operation such as a transaction. `schema()` returns the schema API used for database structure tasks. For normal record queries, use models and the query builder; for table changes, use migrations.

## Views and HTML escaping

```php
return view('tasks/index', ['tasks' => $tasks]);
$name = e($value);
```

`view()` renders a Twig view and returns an HTML response. `e()` HTML-escapes a value for safe insertion into HTML text. Twig also has its own escaping rules; avoid marking untrusted input as safe HTML.

## JSON and other response helpers

```php
return json($data, 200);
return response()->json($data, 200, ['Cache-Control' => 'no-store']);
return response()->html('<h1>Hello</h1>');
return response()->noContent();
```

`json()` is the direct global shorthand for a JSON response. `response()` resolves the response factory, whose `json()` method also lets you provide headers. Use an explicit JSON response for API endpoints so the payload format, status code, and headers are clear. PixelFix can automatically convert collections and other JSON-serializable results, but explicit code is easier for another developer to recognize and maintain. See [Returning JSON from a Route or Controller](../http/json-responses.md).

## HTTP exceptions

```php
abort(404, 'Task not found.');
abort_if($condition, 403);
abort_unless($condition, 401);
```

These helpers interrupt normal execution by throwing an HTTP exception, which is handled by the framework's exception pipeline. Use them when a request should stop because a resource is missing or the action is forbidden. Do not rely on a template-only check as security enforcement; validate access on the server.

## Collections, logging, storage, and utilities

```php
$items = collect($items);
logger();
storage();
report($exception);
```

`collect()` creates the framework collection abstraction and leaves an existing collection unchanged. `logger()` resolves the logger, `storage()` resolves the storage manager, and `report($exception)` sends an exception to the configured reporting path. The helper file also contains lower-level utilities; prefer the documented application-facing helpers when they match the task.

## Where helpers are registered

Composer's `autoload.files` entry loads `src/Support/helpers.php`. The helpers are available after the application's Composer autoloader has been initialized. If a helper is undefined, confirm that the application booted the expected autoloader and that the method name exists in the source version you installed.


## Cache, events, mail, queues and notifications

```php
cache()->get('key', null);
cache()->put('key', $value, 300);
events()->dispatch($event);
event($event);
mailer()->to('person@example.test')->send($mailable);
queue()->push($job);
dispatch($job);
batch([$jobA, $jobB]);
notifications()->send($notifiable, $notification);
rate_limiter()->hit('action:key', 60);
schedule()->call($callback)->hourly();
```

- `cache()` returns `CacheManager`; see [Cache](../cache/overview.md).
- `events()` returns the application event dispatcher; `event($event, ...$payload)` dispatches an event. `event_cache()` resolves the event manifest cache. See [Events](../events/overview.md).
- `mailer()` returns the mail helper. Call `to($email)` before `send($mailable)`; see [Mail](../mail/overview.md).
- `queue()` returns `QueueManager`. `dispatch(Job $job)` returns a `PendingDispatch`, and `batch(array $jobs)` returns a `PendingBatch`; these are dispatch APIs, not a substitute for running a worker. See [Queues](../queue/overview.md).
- `notifications()` resolves `NotificationManager`; see [Notifications](../notifications/overview.md).
- `rate_limiter()` and its alias `rateLimiter()` resolve `RateLimiter`; see [Rate Limiting](../rate-limiting/overview.md).
- `schedule()` resolves `Scheduler`; applications register tasks and a scheduler process executes them. See [Scheduling](../scheduling/overview.md).

## Redis, broadcasting and WebSockets

```php
redis()->connection();
redis_publisher()->publish('channel', $payload);
redis_subscriber()->subscribe('channel', $callback);
broadcast()->broadcast(['reports'], 'report.completed', $payload);
broadcast_manager();
websockets()->publicChannel('announcements');
```

`redis()` resolves `RedisManager`; `redis_publisher()` and `redis_subscriber()` expose Pub/Sub tools. `broadcast(?ShouldBroadcast $event = null)` resolves `BroadcastManager` and may broadcast an event when one is passed; `broadcast_manager()` directly resolves the manager. `websockets()` resolves `WebSocketServer`. See [Redis](../redis/overview.md), [Broadcasting](../broadcasting/overview.md), and [WebSockets](../websockets/overview.md).

## Other public helpers

`base_url`, `redirect_to_route`, `set_authenticated_destination`, `authenticated_destination`, `clear_authenticated_destination`, `class_basename`, `str_matches_pattern`, `class_uses_recursive`, `trait_uses_recursive`, and `broker` are also defined in the current helper file. Read their source signatures before relying on less-common utility helpers; the class and subsystem references are the supported guides for behavior-specific APIs.
