# Task Manager: Authentication

The Task Manager uses PixelFix's session guard and database user provider.

## User model

`app/Models/User.php` implements the authentication contract and uses the framework's authenticatable trait:

```php
class User extends Model implements AuthenticatableContract
{
    use SoftDeletes;
    use Authenticatable;
}
```

The model marks `password` and `remember_token` as hidden attributes.

## Registration

The registration flow is implemented in `AuthController::register()`:

```text
RegisterUserRequest
        ↓
validated data
        ↓
password hash
        ↓
User::create()
        ↓
flash success
        ↓
auth.login
```

The confirmation field is removed before persistence and the password is hashed with PHP's `password_hash()` using `PASSWORD_DEFAULT`.

## Login

The login flow uses `LoginRequest` followed by:

```php
$result = auth()->attempt([
    'email' => $credentials['email'],
    'password' => $credentials['password'],
]);
```

Invalid credentials cause an error message and a redirect back to the login page. Successful authentication redirects to `tasks.index`.

## Logout

Logout delegates to the framework guard:

```php
auth()->logout();
```

The application then flashes a success message and redirects to the welcome page.

## Route protection

The current Task Manager places all browser routes in the `web` middleware group, which provides session and CSRF handling. Individual task actions then perform object-level authorization through `TaskPolicy`.
