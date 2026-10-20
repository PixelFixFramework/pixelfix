# Password Reset

Password reset lets a user who has forgotten their password prove control of a recovery channel and choose a new password. It is a security-sensitive workflow, not merely a form that updates the `password` column.

## What PixelFix provides—and what your application must add

PixelFix provides password-reset token primitives, including `DatabaseTokenRepository` and `PasswordResetToken`. These can create a random token, store a protected representation in the database, check a submitted token, enforce expiry/throttling windows, and delete a token. The framework does **not** automatically create a complete password-reset experience: the application still needs routes, forms/views, delivery of the reset link, password validation, updating the user, and protection/rate limiting of the endpoints.

## Prepare the token table

The database repository defaults to the table `password_reset_tokens`. The table needs columns for the email address, token hash, `created_at`, and `expires_at`. Create the table through a migration before using the repository, and make sure the configured database connection is the one the application uses.

## Create a reset token

The repository can be configured with an expiry and throttle window. The following shows the token primitive; it is not a complete controller or email sender:

```php
use PixelFix\Framework\Auth\Passwords\DatabaseTokenRepository;
use PixelFix\Framework\Database\Infrastructure\DatabaseManager;

$tokens = new DatabaseTokenRepository(
    app(DatabaseManager::class),
    table: 'password_reset_tokens',
    expire: 3600, // token validity: one hour
    throttle: 60  // minimum delay between requests: one minute
);

if ($tokens->recentlyCreated($email)) {
    // Return the same public message used for other reset requests.
} else {
    $reset = $tokens->create($email);
    $plainToken = $reset->token;

    // Send a reset URL containing this token through your configured
    // email-delivery system. Do not write the token to a log.
}
```

`create($email)` replaces any existing token for that email, stores a SHA-256 hash, and returns a `PasswordResetToken` whose `token` property contains the plain token for delivery. Treat that plain value as a secret: send it only through the intended recovery channel, do not log it, and do not return it from a public API response just to make testing easier.

Do not reveal whether an email address belongs to an account. The public response should be generic for both known and unknown addresses, and requests should be rate-limited.

## Validate the submitted token

When the user opens the reset link and submits the token, validate it with the repository:

```php
$isValid = $tokens->exists($email, $submittedToken);

if (!$isValid) {
    // Show an expired or invalid-link message.
}
```

`exists()` checks that a token exists for the email, has not expired, and matches the stored hash. A successful check alone does not change the password. Your application must still validate the new password, locate the user, hash the new password using the supported password-hashing API, save it, and delete the reset token after a successful reset:

```php
$tokens->delete($email);
```

The validation and password update should be designed as one secure workflow. Do not treat a token as permanently valid after the password has been changed, and consider revoking other sessions or access tokens after a reset.

## Security checklist

- Use HTTPS for the reset form and all reset links.
- Generate cryptographically random tokens; never use a sequential ID or predictable string.
- Store token hashes, not reusable plain tokens. Deliver the plain token only at creation time.
- Keep tokens short-lived and enforce request throttling.
- Use the same generic response for registered and unregistered email addresses.
- Hash the new password and delete the token only after a successful reset.
- Avoid logging passwords, reset links, or reset tokens.
- Test valid, invalid, expired, throttled, and reused tokens before deployment.

Related topics: [Authentication Overview](overview.md), [User Providers](providers.md), [Validation](../validation/overview.md), and [Logging](../application/logging.md).
