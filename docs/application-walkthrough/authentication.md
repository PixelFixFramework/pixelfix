# Example Application Authentication: Registration, Login, and Logout

The example application uses PixelFix's session-based authentication. A user submits credentials, the framework checks them through the configured guard and user provider, and a successful login stores the authenticated identity in the session. The application does not store a plain-text password.

## Registration flow

`GET /register` renders the registration form. `POST /register` is handled by `AuthController::register()` and follows this sequence:

1. `RegisterUserRequest` checks that the submitted fields are valid.
2. The controller calls `$request->validated()` to obtain only fields that passed validation.
3. It removes `password_confirmation`, because this is only a confirmation field and is not a database column.
4. It hashes the password with `password_hash($data['password'], PASSWORD_DEFAULT)`.
5. It creates the `User` record and redirects to the login page with a success message.

The password hash is what is stored in the database. During login, the framework verifies a submitted password against that hash; the application must never compare or store plain-text passwords itself.

## Login flow

`GET /login` displays the form; `POST /login` receives it. `LoginRequest` validates the submitted email and password fields, and the controller calls:

```php
$authenticated = auth()->attempt([
    'email' => $credentials['email'],
    'password' => $credentials['password'],
]);
```

`auth()->attempt()` returns a boolean: `true` means the credentials were accepted and the guard has authenticated the user; `false` means login did not succeed. On failure, the application shows a generic error message and redirects back to the login form. On success, it flashes a message and redirects to the intended URL, falling back to `records.index`.

Never tell a user whether the email or password alone was wrong. A generic invalid-credentials message reveals less information about registered accounts.

## Logout

Logout is a state-changing operation, so the application exposes it as `POST /logout` inside the `web` middleware group. The action calls `auth()->logout()`, flashes a confirmation, and redirects to the welcome page. A logout link should submit a form with a CSRF token rather than use a plain GET link.

## Guests and signed-in users

The routes use `guest` middleware for login and registration pages and `auth` middleware for record pages. This provides a route-level boundary, but it does not replace record ownership checks. `RecordPolicy` still has to decide whether the current user may view or change a particular record.

## Important setup checks

If login always fails, check that the `users` table exists, the email lookup returns the expected user, and the password was created with a compatible password hash. If a form submission is rejected before the controller runs, check `LoginRequest` or `RegisterUserRequest` and the CSRF field (`{{ csrf|raw }}` in Twig).

See [Authentication Guards](../authentication/guards.md), [Authentication Providers](../authentication/providers.md), and [Validation](validation.md) for the framework-level details.
