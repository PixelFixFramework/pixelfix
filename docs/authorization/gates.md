# Gates

A **gate** is a named rule that answers an authorization question. Use a gate for an ability that is not naturally tied to one particular database record, such as whether someone may open an administration dashboard or view system-wide reports. Use a policy for rules about an individual model, such as whether someone may edit Task 42.

## 1. Define the gate

Register gates during application boot, usually inside an application service provider. The callback returns `true` when the action is allowed and `false` when it is denied:

```php
use PixelFix\Framework\Providers\ServiceProvider;
use PixelFix\Framework\Support\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register container bindings here, if needed.
    }

    public function boot(): void
    {
        Gate::define('access-admin', function ($user): bool {
            return $user->role === 'admin';
        });
    }
}
```

This assumes the authenticated user model has a `role` attribute whose value is `admin` for administrators. Register the provider using the application's provider configuration. Do not define a gate in a route callback: a provider is the place for one-time application authorization setup.

## 2. Check the gate without interrupting the request

`Gate::allows()` returns a boolean. Use it when the code should choose between two paths:

```php
if (Gate::allows('access-admin')) {
    return view('admin/index');
}

return response()->html('Forbidden', 403);
```

`Gate::denies()` returns the opposite result:

```php
if (Gate::denies('access-admin')) {
    // Do not run the restricted operation.
}
```

The `allows()` and `denies()` methods answer a yes/no question; they do not themselves perform the protected operation.

## 3. Reject a request when permission is required

If the request must not continue without permission, use `Gate::authorize()`:

```php
Gate::authorize('access-admin');

return view('admin/index');
```

If the gate denies the action, `authorize()` throws the framework authorization exception, which is handled by the HTTP exception pipeline. The view is rendered only if authorization succeeds.

## 4. Pass extra context to a gate

A gate callback can receive arguments supplied during the check. This is useful when a general ability needs context but is not organized as a model policy:

```php
Gate::define('view-financial-report', function ($user, string $department): bool {
    return $user->department === $department
        && $user->role === 'manager';
});

Gate::authorize('view-financial-report', 'finance');
```

Use the same argument order when defining and checking the gate. Validate and authorize the underlying operation on the server; merely hiding a link or button in Twig is not a security check.

## Gate before/after callbacks

The gate manager supports global `before` and `after` callbacks. A `before` callback can implement a deliberate global override; an `after` callback observes the decision and may participate in the evaluation result. These callbacks affect every gate, so keep them small, well-tested, and narrowly justified.

## Troubleshooting

- **Gate is not found or does not run:** check that the service provider is registered and its `boot()` method ran.
- **Always denied:** confirm an authenticated user exists, the user's attribute values match the rule, and extra arguments are passed in the expected order.
- **The page hides the link but the URL still works:** enforce `Gate::authorize()` or middleware in the server-side request path. UI visibility alone does not protect data.

See [Authorization Overview](overview.md) for the distinction between gates and policies.
