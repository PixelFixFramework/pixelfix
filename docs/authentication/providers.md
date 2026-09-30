# User Providers

A user provider is responsible for retrieving an authenticated user from persistent storage.

## Database provider

PixelFix includes a `DatabaseUserProvider`. It is designed for user models backed by the database layer.

The provider participates in the authentication flow rather than being called directly from controllers.

## Application model

The Task Manager's `User` model implements the framework's `Authenticatable` contract and uses the `Authenticatable` trait:

```php
class User extends Model implements AuthenticatableContract
{
    use SoftDeletes;
    use Authenticatable;
}
```

This allows the session guard and user provider to work with the model as the authenticated identity.

## Provider vs guard

The distinction is important:

```text
Guard
  = how the current request identifies the user

Provider
  = how the user record is retrieved
```

A guard may use a provider to retrieve an identity while retaining control over the request-level authentication state.
