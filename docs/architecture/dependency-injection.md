# Dependency Injection

PixelFix applications use a container to resolve application services and constructor dependencies.

## Resolving services

The container can resolve classes automatically when their dependencies are resolvable:

```php
$service = app(SomeService::class);
```

Within framework-managed classes, constructor injection is preferred:

```php
class TaskController extends Controller
{
    public function __construct(
        Request $request,
        QueryBuilder $query,
        Environment $twig
    ) {
        parent::__construct($request, $query, $twig);
    }
}
```

The PixelFix base controller already receives a request object, query builder, and Twig environment through dependency injection.

## Bindings

The container supports ordinary bindings, scoped bindings, and singletons.

```php
$container->bind(
    ReportRepository::class,
    fn () => new ReportRepository()
);

$container->singleton(
    Clock::class,
    fn () => new SystemClock()
);
```

Use bindings when an application needs an interface-to-implementation mapping or a custom construction rule.

## Service providers

Application-specific registrations belong in service providers. A provider exposes two lifecycle methods:

- `register()` for container bindings and service registration.
- `boot()` for work that depends on services already being registered.

Example:

```php
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->singleton(
            Clock::class,
            fn () => new SystemClock()
        );
    }

    public function boot(): void
    {
        // Use already-registered services here.
    }
}
```

Keep registration in `register()` and runtime initialization in `boot()` unless there is a specific reason to do otherwise.

## Application code vs framework internals

The container contains additional lifecycle and provider machinery. Application developers normally need only the public container helpers, constructor injection, and service-provider hooks. Internal compilation and resolution services are implementation details unless you are contributing to PixelFix itself.


## A concrete example

Suppose `TaskController` needs a service that sends notifications. Rather than constructing a notification client inside every controller method, declare the dependency in the controller constructor and let the container resolve it. This makes the dependency visible and lets tests provide a substitute when appropriate.

Dependency injection helps separate *what a class needs* from *how that dependency is constructed*. It does not mean every value belongs in the container: simple local values, request input, and objects that are naturally created for one operation do not need global registration.

## Troubleshooting resolution failures

When the container cannot build a class, inspect the constructor. Confirm each class type is autoloadable and that the container knows how to create interfaces or abstract types. If a constructor needs a scalar such as a URL or API key, configure that value explicitly; PHP type information alone cannot tell the container which string to use.
