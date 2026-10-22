# User Providers

A **guard** decides how a request is authenticated. A **user provider** decides how the application finds the user record and checks credentials. For a normal website, a session guard can use a database provider to find users in the `users` table.

You normally configure a provider rather than write one yourself. This guide shows where that configuration lives and how to change it safely.

## 1. Find the default provider configuration

Open `config/auth.php` in the generated application. It returns the contents of the `auth` group, similar to:

```php
<?php

use App\Models\User;

return [
    'defaults' => ['guard' => 'web'],
    'guards' => [
        'web' => ['driver' => 'session', 'provider' => 'users'],
    ],
    'providers' => [
        'users' => [
            'driver' => 'database',
            'model' => User::class,
            'password_field' => 'password',
        ],
    ],
];
```

Read the configuration from the inside out:

- `defaults.guard` chooses `web` when code calls `auth()` without naming a guard.
- `guards.web.driver` chooses session-based authentication for browser requests.
- `guards.web.provider` connects that guard to the `users` provider.
- `providers.users.driver` tells PixelFix to use the database-backed provider.
- `providers.users.model` identifies the model class returned by the provider.
- `password_field` identifies the model attribute that contains the stored password hash.

The `User::class` reference assumes `App\Models\User` is imported near the top of `config/auth.php`, as it is in the starter application.

## 2. What happens during a login attempt?

When your login handler calls:

```php
$authenticated = auth()->attempt([
    'email' => $email,
    'password' => $password,
]);

if (!$authenticated) {
    // Show a generic invalid-credentials message.
}
```

PixelFix asks the configured provider to find a user by the supplied identity field, then verifies the submitted password against the stored hash. If the credentials are valid, the session guard establishes the login state and `attempt()` returns `true`. If they are invalid, it returns `false`.

Do not compare passwords directly in your controller or store plain-text passwords. Create password hashes with PHP's supported password-hashing API or the framework's user/password setup, and let the authentication flow verify them.

## 3. Use a different user model

Suppose staff accounts live in a `staff` table and use an `App\Models\Staff` model. Create a model that fulfils the framework's authentication contract, then define both a guard and provider for it. The following is a simplified example of the array returned by `config/auth.php`; merge its settings with your existing auth settings rather than deleting unrelated authentication settings:

```php
<?php

use App\Models\Staff;
use App\Models\User;

return [
    'defaults' => ['guard' => 'web'],
    'guards' => [
        'web' => ['driver' => 'session', 'provider' => 'users'],
        'staff' => ['driver' => 'session', 'provider' => 'staff'],
    ],
    'providers' => [
        'users' => [
            'driver' => 'database',
            'model' => User::class,
            'password_field' => 'password',
        ],
        'staff' => [
            'driver' => 'database',
            'model' => Staff::class,
            'password_field' => 'password',
        ],
    ],
];
```

To use the staff provider, configure a guard to refer to `staff`, or make that guard the default. Merely adding a provider does not switch the default guard by itself.

The model must expose the authentication identifier and password information expected by the `Authenticatable` contract. The starter `User` model is the reference implementation. Check that its table, identity field, password field, and hidden serialization attributes match your schema. Fields such as `password` and `remember_token` should not be exposed when a model is returned as JSON.

## 4. Provider and guard are different decisions

| Situation | What you usually change |
|---|---|
| Website users stay in the `users` table and sign in through a browser session | Keep the database provider and session guard. |
| Staff users live in a separate table/model | Add or select a provider for the staff model. |
| An API client sends a bearer token instead of relying on a browser session | Configure the token guard and token validation/persistence for that application. |
| A signed-in user may read or edit only some records | Add authorization rules; changing the provider does not grant or restrict record permissions. |

## Troubleshooting

- **Correct password always fails:** confirm the model points to the correct table, the provider uses the correct password field, and stored values are password hashes.
- **A custom provider has no effect:** confirm the selected guard references that provider and, if appropriate, the default guard points to the intended guard.
- **Password appears in JSON:** configure the model's `$hidden` or `$visible` attributes, or return an API resource containing only public fields.
- **Login works but a user can edit another user's record:** authentication confirms identity; use a policy or ownership check for authorization.

Related topics: [Authentication Overview](overview.md), [Guards](guards.md), [Authorization](../authorization/overview.md), and [Returning JSON](../http/json-responses.md).
