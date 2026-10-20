# Token Authentication

Token authentication lets a client authenticate by sending a bearer token with each request. It is commonly used by APIs, mobile applications, and services that do not use a browser's session cookie. A token should be treated like a password: whoever obtains it may be able to act as its owner until it expires or is revoked.

## Important: token primitives are not a complete API login system

PixelFix includes `TokenManager`, `ApiToken`, `TokenRepository`, and a `TokenGuard`. The starter configuration uses a session guard, not a ready-to-use token API. An application that needs token authentication must configure and wire the guard, user provider, token manager, and a persistence mechanism that suits its deployment. It must also implement the login endpoint that issues tokens and the logout/revocation path.

The supplied `TokenRepository` stores token objects in memory. That is useful for demonstrating and testing token behavior, but tokens kept only in memory will not survive a PHP process/application restart and may not be shared between workers. Do not use that in-memory repository as durable production token storage. Use a suitably designed persistent repository and ensure the configured guard uses it before relying on tokens across requests.

## Understand the token lifecycle

The `TokenManager` creates a random bearer token, stores its SHA-256 digest through the repository, and returns an `ApiToken` object whose `token` property contains the plain value once for delivery. The manager can later validate a presented token, check abilities, and revoke tokens.

A small example of the token primitives is:

```php
use DateTimeImmutable;
use PixelFix\Framework\Auth\Tokens\TokenManager;
use PixelFix\Framework\Auth\Tokens\TokenRepository;

// Demonstration only: TokenRepository stores data in memory.
$manager = new TokenManager(new TokenRepository());

$issued = $manager->create(
    $user,
    ['tasks:read'],
    new DateTimeImmutable('+1 hour'),
    'task-manager-client'
);

$plainToken = $issued->token;
```

In a real application, `$user` must implement the framework's `Authenticatable` contract. Return the plain token to the authenticated client only once over HTTPS; do not put it in a URL, write it to a log, or serialize the entire `ApiToken` object into an uncontrolled response. Store the token with secure client-side handling.

## Validate and authorize a token

When the guard is wired to a persistent token manager, `validate()` returns an `ApiToken` for a valid token or `null` for an invalid, expired, or revoked token:

```php
$token = $manager->validate($plainToken);

if ($token === null) {
    abort(401, 'Unauthenticated.');
}

if (!$manager->can($token, 'tasks:read')) {
    abort(403, 'This token cannot read tasks.');
}
```

Abilities describe which API operations a token may perform. Tokens with the `*` ability are unrestricted by this ability check, so issue that ability only when it is actually required. The application must still check the authenticated user’s access to each requested task; a valid token does not automatically authorize every record.

Revoke a bearer token when a client signs out or access should end:

```php
$manager->revoke($plainToken);
```

Because the plain token should not be stored by the server in reusable form, provide a secure way for the server to identify and revoke the corresponding stored digest according to the configured repository/guard design.

## Send bearer tokens correctly

Clients normally send tokens in the HTTP `Authorization` header:

```text
Authorization: Bearer YOUR_TOKEN
```

Use HTTPS. Do not include tokens in query strings, which may be recorded in browser history, access logs, analytics, or referrer headers. Avoid logging authorization headers. Provide expiry and revocation policies, and grant each token only the abilities it needs.

## Authentication is not authorization

A valid token identifies the caller. Policies, gates, ownership checks, and business rules still decide whether the caller may read or change a particular record. For example, a token issued to one user should not allow that user to update another user's task.

Before deploying token authentication, test token creation, successful validation, invalid tokens, expiry, revocation, missing abilities, and cross-user resource access. See [Guards](guards.md), [Authentication Overview](overview.md), and [Authorization](../authorization/overview.md).
