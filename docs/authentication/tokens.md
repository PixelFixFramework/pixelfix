# Token Authentication

PixelFix contains token authentication infrastructure alongside session authentication.

The framework includes token management and a token guard, including an `ApiToken` model and token repository abstractions.

## Where token authentication fits

A token-based request typically follows this shape:

```text
HTTP request
    ↓
Token guard
    ↓
Token repository / token manager
    ↓
Authenticated user
    ↓
Controller or middleware
```

Use token authentication for clients that cannot or should not maintain a browser session.

## Keep token handling behind the authentication layer

Application controllers should normally ask the authentication service for the current user rather than reading token storage directly. This preserves the separation between transport credentials and application identity.

The exact token issuance and persistence workflow should follow the authentication configuration of the application; the presence of token infrastructure does not by itself define a single application-specific login endpoint.
