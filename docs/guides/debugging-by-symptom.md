# Debugging PixelFix by Symptom

This guide starts with what you observe and walks backward to the likely cause. Use it alongside the focused feature guide rather than changing random code until the error disappears.

## The route returns 404

1. Run `php pixel route:list --live` from the application root.
2. Confirm the HTTP method. A route registered for `POST` does not handle a browser `GET` request to the same URI.
3. Compare the exact URI, including a route prefix. PixelFix does not automatically add `/api` to routes loaded from `routes/api.php`.
4. Confirm the route file is loaded by the application's route configuration.
5. If source lists the route but cached routing does not, inspect `route:list --cached` and clear/rebuild the route cache as appropriate.
6. If routing is correct, check whether the controller or model lookup intentionally returns a not-found response.

## The route exists but returns 403

A `403 Forbidden` means the request reached an authorization boundary and was denied (or an application deliberately returned that response). Check:

- the route's `can` middleware;
- any `$this->authorize(...)` call in the controller;
- the corresponding Gate/Policy method and its inputs;
- whether the policy's generated stub still returns `true` or `false` unexpectedly;
- whether the correct model instance/class is passed to the policy;
- whether the authenticated user's role/ownership data is what the rule expects.

Do not remove authorization to make the page work. Find out which rule denies access and decide whether the rule or the caller is wrong.

## The route redirects to login

Check the route middleware and the configured default authentication guard. Confirm the session cookie reaches the application, session middleware is applied to browser routes, and the login process actually establishes the guard's user state. A route in `routes/api.php` is not automatically token-authenticated. API clients need the appropriate configured guard and credentials.

## A POST form fails CSRF validation

Confirm that:

- the browser route uses the intended session/CSRF middleware;
- the form includes the current CSRF token field or uses the documented CSRF component behavior;
- the token was not copied from an old page or another session;
- the form submits to the correct URL and method;
- the application is not mixing cookies, hostnames, ports, or schemes unexpectedly.

Do not disable CSRF globally as a workaround for a broken form.

## Validation redirects or the API does not return JSON errors

For browser forms, inspect the Form Request or validation helper, the validation rule names, and how the view displays field errors/old input. For API requests, ensure the client sends a JSON request and that the application uses an API-appropriate validation/error path. Do not assume all failures automatically use the same JSON body. Test and document the response contract for your endpoint.

Read [Validation](../validation/overview.md), [Form Requests](../validation/requests.md), and [JSON Responses](../http/json-responses.md).

## The API returns HTML instead of JSON

Check the actual route return value. A plain PHP string is handled as HTML, whereas `response()->json($data)` explicitly creates a JSON response. Use `curl.exe -i` or Postman to inspect the HTTP status and `Content-Type`, not just the body. A redirect or an error page may be HTML even when the route was intended to be an API.

## A view renders a variable as blank or throws an undefined-variable error

1. Open the route/controller that returns the view.
2. Verify the view name is correct; a dot-separated view path such as `tasks.index` maps to `resources/views/tasks/index.twig`.
3. Check the data array passed to `view()` or the controller's render method.
4. Verify the template variable name matches the key passed by PHP.
5. Check the Twig include path and whether the referenced component exists in the application.
6. In debug mode, inspect the detailed local error; do not enable debug output publicly in production.

Remember: `make:view` creates a generic view. It does not automatically import any component referenced by the view. Use the component importer for bundled components, then check their dependency paths.

## A generated class exists but the framework cannot discover it

Check the namespace, file path, class name, extension, and convention expected by that artifact type. Use `php pixel help <command>` and the specific generator page to confirm the public command syntax. Inspect the generated artifact—generators give you a starting file; they do not complete application logic for you.

For a service provider, check `app/Providers/` and its `register()` / `boot()` methods. For a policy, check `App\Policies\{ModelName}Policy` or its explicit registry mapping. For a Form Request, confirm the controller/action receives the intended request class and that its rules are implemented.

## Database connection fails

Read the complete exception message without publishing credentials. Confirm the configured connection name and driver, host, port, database name, username, password, PHP PDO extension, and network permissions. Check the configuration loaded by the application—not just what `.env` contains. A correct `.env` file cannot compensate for a missing PHP database driver.

For tests, `pdo_sqlite` is required when the test creates an SQLite in-memory connection. Check the PHP binary used by the application/test command; Windows can have multiple PHP installations with different extensions enabled.

## A query returns no rows or the wrong rows

- Run the query with the same filters used by the controller.
- Inspect bound values as well as SQL structure, without exposing secrets.
- Check relationship foreign keys and the actual table names.
- Remember that soft-deleted records are excluded by default on soft-deleting models; use `withTrashed()` or `onlyTrashed()` only when that behavior is intended and authorized.
- Check global scopes and local scopes.
- If the query is scoped to the current user, verify the current user's identifier and record ownership.

## A migration fails or the schema differs

Run `php pixel migrate:status`, inspect the generated migration code, and check whether it has already been applied. Verify the target table/column spelling, driver support, foreign-key ordering, and rollback implementation. Do not use a destructive reset/fresh operation on important data as the first troubleshooting step.

## A test suite fails

Run the smallest test group that reproduces the failure:

```powershell
php tests/run.php --filter=TheTestName
```

Then run the related directory and the full suite. If the failure says a PDO driver is missing, resolve the environment first. If a test fails only in the suite, look for global/static state that is not reset or temporary data not cleaned up.

## The app is slow

Don't start by enabling every optimization. Determine whether the delay is in PHP, a repeated query, full-table hydration, a relation loaded per row, an external dependency, or template rendering. Inspect SQL, paginate large lists, select needed fields, eager load used relationships, add justified indexes, and test against realistic data. See [Performance and Scale](performance-and-scale.md).

## What information to include when asking for help

A useful bug report includes:

- PHP version and which PHP executable ran the command;
- the exact public command or HTTP method and URI;
- the complete error/exception message with secrets removed;
- the relevant route, controller/request/policy, and model snippets;
- the expected behavior and the actual behavior;
- whether `route:list --live` shows the route;
- the focused test output and whether required PDO drivers are enabled.

Do not include `.env` files, passwords, session cookies, API tokens, reset links, or production user data.
