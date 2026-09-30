# Authentication Guards

PixelFix separates authentication through guards and user providers.

## Session guard

The Task Manager uses browser authentication backed by a session guard. Application code normally accesses it through the `auth()` helper:

```php
auth()->check();
auth()->user();
auth()->attempt($credentials);
auth()->logout();
```

The session guard stores authenticated identity in the application's session.

## Token guard

The framework also contains a token guard for token-oriented authentication flows. Use it for API authentication when the application is configured for that guard/provider combination.

## Guard selection

`AuthManager` exposes the configured default guard and allows named guards/providers to be resolved. Application code should normally use `auth()` and named guard access only when the application intentionally supports multiple authentication mechanisms.

## Choosing a guard

Use a session guard for browser interactions that depend on a logged-in session. Use a token guard for API clients that authenticate with an API token. Keep authentication mechanism separate from authorization policy: authentication answers who the user is; authorization decides what that user may do.
