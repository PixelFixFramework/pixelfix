# Route Inspection and Caching

Route inspection helps you confirm which URL patterns the application has loaded. Route caching stores a prepared representation of the route table so deployments with stable routes can load that information efficiently. It does not change the business logic inside a controller.

## Inspect the routes loaded by the application

```powershell
php pixel route:list --live
```

Use the live view after adding or editing a route. Check the HTTP method, path, route name, action, and middleware. If a route is missing from this output, confirm that the file containing its declaration is loaded by the application's route configuration.

## Inspect the cached route set

```powershell
php pixel route:list --cached
```

The cached output represents the current route cache, which may be older than the files you just edited. A difference between live and cached lists is a clue that the route cache needs to be rebuilt or cleared.

## Build and clear the cache

```powershell
php pixel route:cache
php pixel route:clear
```

`route:cache` prepares the cached representation from the application's current route definitions. `route:clear` removes the cache so the application can rebuild routes from source. Use these as part of a deliberate deployment or troubleshooting workflow; do not assume that changing a route file automatically refreshes an existing cache.

## A safe development workflow

During active development, inspect live routes. Before deploying a stable route set, build the cache only if your deployment process uses it. If you add `/reports` and receive a 404, first inspect `route:list --live`. If the route appears live but not cached, clear/rebuild the cache and inspect again. If it does not appear live either, investigate route registration and syntax instead of changing the controller blindly.

## Named routes

Route names are stable identifiers used by `route('tasks.index')` in Twig and `redirect_to_route('tasks.index')` in PHP. If you rename a route, update its callers and rebuild any cache that your application uses. See [Routing](routing.md) and [Routing Reference](routing-reference.md).
