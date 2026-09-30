# Route Inspection and Caching

PixelFix provides console commands for inspecting, compiling, and clearing route state.

## Inspect live routes

```bash
php pixelfix route:list --live
```

The router can also be inspected through the registered route collection.

## Inspect cached routes

```bash
php pixelfix route:list --cached
```

Use this when diagnosing a mismatch between route definitions and the currently compiled route set.

## Build the route cache

```bash
php pixelfix route:cache
```

The route cache compiler transforms the registered route definitions into a compiled route representation used by the runtime.

## Clear the route cache

```bash
php pixelfix route:clear
```

After changing route definitions, clearing/rebuilding the cache is useful when the application is using cached routes.

## Development workflow

A simple development sequence is:

```text
change routes
    ↓
inspect live routes
    ↓
run the application
    ↓
compile route cache for deployment/use
```

Avoid assuming that a cached route set has automatically changed merely because the source route file changed.

## Named routes

Routes can be named and generated through:

```php
->name('tasks.show');
```

Then:

```php
route('tasks.show', [$task->id]);
```

The named route registry is therefore part of both application navigation and route inspection.
