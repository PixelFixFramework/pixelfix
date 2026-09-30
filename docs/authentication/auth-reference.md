# Authentication Reference

PixelFix exposes authentication through `AuthManager`, the `Auth` helper/facade layer, guards, and authenticatable models.

## Common helper API

```php
auth()->check();
auth()->guest();
auth()->id();
auth()->user();
```

Authentication actions include:

```php
auth()->attempt($credentials);
auth()->login($user);
auth()->logout();
auth()->validate($credentials);
```

The `PixelFix\\Framework\\Support\\Auth` facade provides the same high-level operations through static calls.

## Attempting a login

```php
if (auth()->attempt([
    'email' => $request->email,
    'password' => $request->password,
])) {
    return redirect_intended('/');
}
```

The guard is responsible for validating the credentials and establishing the authenticated identity.

## Logging in an existing user

```php
auth()->login($user, true);
```

The second argument controls the remember behavior where supported by the active guard.

## Logging out

```php
auth()->logout();
```

The application should clear the authenticated session before redirecting the user to a public destination.

## Guard selection

```php
auth()->guard('web');
```

Calling `auth()` without selecting a guard uses the configured default guard.

The reference Task Manager configures:

```text
default guard: web
guard driver: session
provider: users
```

## Authenticatable model

An application user model implements:

```php
PixelFix\\Framework\\Auth\\Contracts\\Authenticatable
```

and normally uses the framework's `Authenticatable` trait.

The Task Manager `User` model also hides `password` and `remember_token` from serialization.

## Guest and authenticated guards

For browser endpoints, `auth` middleware is generally the clearest route-level protection. For application code that needs a direct check:

```php
abort_unless(auth()->check(), 401);
```

For guest-only flows:

```php
auth()->requireGuest();
```

## Intended URLs

The built-in `auth` middleware stores a GET request's URI as the intended URL when redirecting an unauthenticated browser to login.

After a successful login:

```php
return redirect_intended('/');
```

The stored destination is consumed when `intended_url()`/the redirect helper resolves it.

## Configuration shape

The application authentication configuration is organized around:

```text
auth.defaults.guard
auth.guards.*
auth.providers.*
auth.password_timeout
auth.remember.cookie
auth.remember.duration
```

The exact values are application configuration, not hard-coded framework policy.
