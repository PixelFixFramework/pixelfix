# Password Reset

PixelFix includes password-reset token infrastructure under `PixelFix\\Framework\\Auth\\Passwords`.

The core abstractions include:

```text
PasswordTokenRepository
DatabaseTokenRepository
PasswordResetToken
```

`PasswordTokenRepository` defines the storage contract for reset tokens, while `DatabaseTokenRepository` provides a database-backed implementation.

## Token lifecycle

The repository supports operations for:

- creating a reset token for an email address;
- retrieving a stored reset token;
- validating token expiry and related state;
- throttling repeated reset requests;
- deleting reset tokens for an email address;
- clearing stored reset tokens.

The default database-backed implementation uses a `password_reset_tokens` table.

## Application integration

The token repository is infrastructure; the application still needs routes, request validation, notification/email delivery, and password-update behavior to expose a complete password-reset workflow.

Do not document a complete end-user reset flow unless the application has implemented the corresponding delivery and update endpoints.
