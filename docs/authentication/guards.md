# Authentication Guards

A **guard** describes how PixelFix identifies the caller on a request. It answers “How does this request prove which user it belongs to?” A **provider** answers “Where does the user record come from?” PixelFix supports a session guard for browser workflows and a token-oriented guard for API requests.

## The default session guard

The starter configuration uses the `web` guard with the `session` driver and a database-backed `users` provider. This is the normal choice for a server-rendered application where people sign in through a form and remain signed in across browser requests.

After a successful login, the current user can be read from application code:

```php
if (auth()->check()) {
    $user = auth()->user();
    $userId = auth()->id();
}
```

- `check()` returns `true` when the selected guard has an authenticated user.
- `guest()` returns `true` when there is no authenticated user.
- `user()` returns the user model, or `null` when there is no user.
- `id()` returns the authenticated user's identifier when available.

These methods inspect authentication state; they do not decide whether that user may edit a particular task.

## Validate credentials

Use `attempt()` to ask the configured provider to find the user and verify the submitted credentials:

```php
$authenticated = auth()->attempt([
    'email' => $credentials['email'],
    'password' => $credentials['password'],
]);

if (!$authenticated) {
    // Return to the login form with a generic error.
}
```

When credentials are correct, `attempt()` logs in the user and returns `true`. When they are wrong, it returns `false`. Do not compare the submitted password directly with the database string; the framework uses password hashes and verification. Do not tell the visitor whether the email address or password specifically was wrong, because that can reveal account information.

`validate($credentials)` checks the credentials without establishing the persistent login state. Use it when you need a validation result but do not want to sign the user in.

## Log in and log out

If you have already resolved the user through a trusted flow, the guard also supports:

```php
auth()->login($user);
auth()->loginUsingId($userId);
auth()->logout();
```

`login()` establishes authenticated state for the supplied user; `loginUsingId()` asks the provider to load a user by identifier and log that user in; `logout()` clears the current authenticated state. Only call `login()` after the application has verified the identity through a legitimate authentication process.

`once($credentials)` authenticates a user for the current request without creating the normal persistent session. It is not a substitute for a token system across multiple requests.

## Protect a route

Attach the built-in `auth` middleware to a route that should only be available to signed-in users:

```php
Route::get('/tasks', [TaskController::class, 'index'])
    ->middleware('auth');
```

An unauthenticated browser request is redirected to `/login` by default, and GET requests store the intended destination for a later redirect. A request that expects JSON receives a `401` response instead of a browser redirect.

Use `guest` for a login or registration page that is intended for visitors who are not authenticated:

```php
Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest');
```

Verify that the controller and route exist in your application; the snippet demonstrates the middleware contract, not a generated authentication scaffold.

## Choose a named guard

If the application defines multiple guards, choose one explicitly:

```php
$webUser = auth()->guard('web')->user();
```

The guard name must exist in the `auth.guards` configuration. An undefined guard raises an error rather than silently selecting another mechanism.

## Token guard

A token guard authenticates requests using token material supplied with each request rather than relying on a browser session cookie. It is suitable for an API client when the application has deliberately configured token storage, token issuance, expiry, and revocation. Setting the driver to `token` does not automatically create login endpoints or a complete token lifecycle UI. Read [Token Authentication](tokens.md) before enabling it.

## Guard versus authorization

Authentication establishes identity; authorization decides whether that identity may perform an action. A signed-in user should not automatically be allowed to update every task. Check a [policy](../authorization/policies.md) or [gate](../authorization/gates.md) before operating on a protected record.
