# Sessions

PixelFix provides session management through `SessionManager` and a file-backed session driver.

## Session access

The framework manages the PHP session lifecycle for web requests. Session access is available through the session service used by the application and through the framework helpers that build on it.

Common session operations include storing, retrieving, flashing, forgetting, and checking values.

A typical application pattern is:

```php
session()->put('key', 'value');
$value = session()->get('key');
```

The exact helper methods available to application code should follow the `Session` service exposed by the current application bootstrap.

## Session lifecycle

`SessionManager::start()` configures and starts the session, attaches the framework session store, and ages flash data. `save()` closes an active PHP session and marks the manager as stopped.

The manager also exposes `started()` and `reset()` for lifecycle management and tests.

## Configuration

The current session manager reads these configuration keys:

```text
session.driver
session.cookie
session.lifetime
session.path
session.domain
session.secure
session.http_only
session.same_site
session.files
```

The current framework implementation supports the `file` session driver.

## Security-related behavior

Session IDs are validated before a session is established, and the session cookie can be configured with secure, HTTP-only, and SameSite attributes.

Session middleware is normally enabled through the `web` middleware group. See [Middleware](../http/middleware.md).
