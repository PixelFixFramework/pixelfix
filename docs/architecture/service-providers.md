# Service Providers

Service providers are the main extension point for registering application services and bootstrapping application-level behavior.

## Provider lifecycle

Every provider inherits from `PixelFix\Framework\Providers\ServiceProvider` and can implement:

```php
public function register(): void
public function boot(): void
```

`register()` should define bindings. `boot()` should configure behavior that can safely run after the application's services have been registered.

## Example: authorization provider

The Task Manager defines an application provider for a gate:

```php
class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register services here.
    }

    public function boot(): void
    {
        Gate::define(
            'access-admin',
            function ($user): bool {
                return $user->role === 'admin';
            }
        );
    }
}
```

A separate provider registers model policies with the framework's `PolicyRegistry`.

## Deferred providers

The base provider exposes `isDeferred()`, `provides()`, and `when()` hooks. These are part of the provider infrastructure. Use them only when the application's registration requirements justify deferred loading or conditional provider behavior.

## Provider responsibilities

Good provider responsibilities include:

- registering interface implementations;
- configuring authorization gates and policies;
- configuring framework integrations;
- attaching application-level listeners or behavior supported by the current framework.

Avoid placing ordinary request handling or feature logic in providers. Put feature behavior in controllers, services, models, policies, or other appropriate application classes.
