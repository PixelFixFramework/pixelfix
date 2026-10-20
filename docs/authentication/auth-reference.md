# Authentication Reference

PixelFix authentication answers two questions: whether a request has a known user, and which user that is. Use these helper methods from controllers or services after the authentication manager and guard have been configured by the application.

## Check the current authentication state

```php
auth()->check();
auth()->guest();
auth()->id();
auth()->user();
```

- `check()` returns whether a user is authenticated.
- `guest()` is the inverse: it returns whether no user is authenticated.
- `id()` returns the identifier of the authenticated user, or `null` when there is no user.
- `user()` returns the authenticated user model when one is available, otherwise `null`.

For example, a controller can use `auth()->user()` to identify the owner of a new task. A route should still use authentication middleware or an explicit check to prevent guests from executing a protected action.

## Verify credentials with `attempt()`

```php
$authenticated = auth()->attempt([
    'email' => $request->email,
    'password' => $request->password,
]);

if ($authenticated) {
    return redirect_intended('/');
}

return redirect_back();
```

`attempt()` checks the supplied credentials through the configured guard/provider and establishes authentication when they are valid. Do not store a submitted password directly or compare plain-text password strings yourself. Validate the request fields before attempting authentication and provide a safe failure message.

## Other authentication operations

- `validate($credentials)` checks the supplied credentials without establishing an authenticated session.
- `login($user)` signs in a user object that has already been resolved and trusted by the application.
- `logout()` clears the current authenticated state using the active guard's logout behavior.
- `guard('web')` selects the named guard; without an explicit selection the configured default guard is used.

The `PixelFix\Framework\Support\Auth` facade provides equivalent high-level operations using static calls. Prefer one style consistently within an application.

## Authenticatable model

An application user model implements `PixelFix\Framework\Auth\Contracts\Authenticatable` and typically uses the framework's `Authenticatable` trait. The configured provider tells the guard how to find the user. Keep fields such as `password` and `remember_token` hidden from serialized responses.

## Redirect to the intended page

The built-in authentication middleware can remember a GET URL when it redirects an unauthenticated visitor to the login page. After successful login, `redirect_intended('/')` returns the user to that destination, using `/` as the fallback when no intended URL was recorded.

## Guard configuration

The reference application configures a `web` session guard with a `users` provider backed by `App\Models\User`. The relevant keys are grouped under `auth.defaults.guard`, `auth.guards.*`, and `auth.providers.*` in the active configuration. A guard defines the authentication mechanism; a provider defines how the user record is loaded. Authorization policies are a separate step.
