# Sessions

A session stores small pieces of information between separate HTTP requests from the same browser. For example, authentication can use a session to remember which user is signed in, and an application can use flash data to display a message after a redirect.

## Store and retrieve a value

```php
session()->put('report_filter', 'open');
$filter = session()->get('report_filter');
```

`put()` saves a value under a key. `get()` retrieves it. Use a default value where the application should continue when the key is missing, and avoid treating session data as validated input merely because it came from a previous request.

## Remove a value or clear the session

```php
session()->forget('report_filter');
```

Forget keys that are no longer needed. Logging a user out should use the framework's authentication/session APIs so the authenticated identity and session lifecycle are cleared together.

## Flash data for the next request

Flash data is commonly used with redirects: save a short-lived status or validation message, redirect the browser, and read the message while rendering the next page. Flash values are intended to be temporary rather than a permanent store.

## Security notes

Do not put large files in a session. Avoid storing secrets or unnecessary personal information. Session cookies should be configured for HTTPS and appropriate same-site behavior in production. Authentication code should regenerate or invalidate session state at the appropriate points to reduce session-fixation risk.

## Configuration and lifecycle

Session storage and cookie behavior are configured by the application. The framework manages session startup and request integration; do not start a second independent session system beside it. If session values unexpectedly disappear, verify that the request passes through the session middleware and that the browser is sending the session cookie.


## What belongs in a session?

Sessions are useful for small pieces of state that must survive between requests from the same browser, such as a login identity, a one-time flash message, or a temporary workflow choice. They are not a replacement for a database: do not use them to store a full list of business records or information that must be shared reliably between users.

A typical pattern is to store a small value during one request and read it on the next. When using a session for authentication, use the framework's authentication API rather than inventing your own session key and password-checking logic. After login, regenerate session state where the authentication flow requires it to reduce session-fixation risk.

## Flash data versus persistent data

A flash message is intended to be read once, often after a redirect. Persistent session data remains available until it is changed or removed. Use flash data for messages such as “Task saved”; use persistent data only when the state genuinely needs to survive multiple requests. Never put secrets in a message that will be rendered into HTML.
