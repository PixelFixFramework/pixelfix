# Authentication

PixelFix provides configurable authentication through guards and user providers. The default framework setup supports session-based authentication and token-based authentication.

## Application configuration

Authentication is configured under the `auth` key in the application's configuration:

```php
'auth' => [
    'defaults' => [
        'guard' => 'web',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'database',
            'model' => User::class,
            'password_field' => 'password',
        ],
    ],
],
```

The default guard is selected from `auth.defaults.guard`.

## Authenticatable model

An application user model implements `PixelFix\\Framework\\Auth\\Contracts\\Authenticatable` and commonly uses the framework `Authenticatable` trait:

```php
use PixelFix\Framework\Auth\Authenticatable;
use PixelFix\Framework\Auth\Contracts\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;
}
```

The trait provides the authentication identifier, password access, remember-token support, password verification, password hashing, and password rehash detection.

By convention, the trait uses:

```text
id              authentication identifier
password        password hash
remember_token  persistent login token
```

The application can override the corresponding methods when its database uses different column names.

## Auth helper

The global `auth()` helper resolves the configured `AuthManager`:

```php
$user = auth()->user();
```

Useful guard methods include:

```php
auth()->check();
auth()->guest();
auth()->user();
auth()->id();
auth()->attempt($credentials);
auth()->validate($credentials);
auth()->login($user);
auth()->loginUsingId($id);
auth()->once($credentials);
auth()->logout();
auth()->viaRemember();
```

When no guard name is supplied, the configured default guard is used.

A named guard can be selected explicitly:

```php
auth()->guard('web')->check();
```

## Attempting authentication

The normal credential flow is:

```php
$authenticated = auth()->attempt([
    'email' => $email,
    'password' => $password,
]);

if (!$authenticated) {
    // Invalid credentials.
}
```

`attempt()` resolves a user through the configured provider, verifies the credentials, and logs the user in when they match.

`validate()` performs credential validation without logging the user in.

## Logging a user in

An already-resolved user can be authenticated directly:

```php
auth()->login($user);
```

A user can also be authenticated by identifier:

```php
auth()->loginUsingId($id);
```

`once()` authenticates the user for the current request without establishing the normal persistent login state.

## Logging out

```php
auth()->logout();
```

The session guard clears the authenticated user state and handles its remember-token state according to the current guard implementation.

## Session guard

`SessionGuard` stores the authenticated identifier in the configured session and resolves the corresponding user through the configured user provider.

When the normal session identifier is unavailable, the guard can resolve a user from the remember cookie when remember authentication is configured.

The framework's `AuthMiddleware` uses the current guard to determine whether the request is authenticated.

## Authentication middleware

Protect browser routes with the `auth` middleware:

```php
Route::get(
    '/tasks',
    [TaskController::class, 'index']
)->middleware('auth');
```

Unauthenticated browser requests are redirected to `/login` by default. GET requests also store the intended URL for later use.

Requests that expect JSON receive a `401` response instead of a browser redirect.

## Guest middleware

Use `guest` for pages intended for unauthenticated visitors such as login and registration:

```php
Route::get(
    '/login',
    [AuthController::class, 'showLogin']
)->middleware('guest');
```

Authenticated users are redirected away from the guest-only route.

## Remember authentication

The session guard supports a remember option:

```php
auth()->attempt(
    $credentials,
    true
);
```

The application's `auth.remember` configuration controls the remember cookie name and duration.

## Token authentication

PixelFix also includes `TokenGuard` and token management infrastructure. A guard can be configured with the `token` driver and a user provider.

Use token authentication when the application needs request-token-based API authentication rather than browser sessions. The exact token transport and persistence configuration should follow the application's current token setup.

## Password security

The built-in authenticatable trait uses PHP's password hashing API with `PASSWORD_DEFAULT` and verifies passwords with `password_verify()`.

The database provider also detects password hashes that need rehashing and can persist an updated hash after successful credential validation.

Applications should never store plain-text passwords.

## Task Manager example

The Task Manager configures one `web` session guard with a database-backed `users` provider. Its `User` model uses the framework authenticatable trait and hides `password` and `remember_token` from serialized model output.

Registration hashes the supplied password before creating the user. Login delegates credential verification to:

```php
$authenticated = auth()->attempt([
    'email' => $credentials['email'],
    'password' => $credentials['password'],
]);
```

Successful authentication redirects the user to the task list; failure flashes an error and returns to the login route.
