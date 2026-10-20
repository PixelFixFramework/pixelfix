# Example Application Routing: URLs, Actions, and Middleware

Routes connect an HTTP method and URL to the code that handles the request. The Example Application's browser routes are in `routes/web.php` and are grouped under the `web` middleware. This group provides browser-oriented behavior such as session handling and CSRF protection. Authentication-specific routes also use `guest` or `auth` middleware.

## Public and authentication routes

| Method | Path | Name | Purpose |
|---|---|---|---|
| `GET` | `/` | `home` | Display the welcome page |
| `GET` | `/register` | `auth.register` | Display registration form |
| `POST` | `/register` | `auth.store` | Validate and create an account |
| `GET` | `/login` | `auth.login` | Display login form |
| `POST` | `/login` | `auth.attempt` | Check credentials |
| `POST` | `/logout` | `auth.logout` | End the session |

The register/login pages are inside the `guest` group, so signed-in users are redirected away from them. Logout and record pages are inside the authenticated group.

## record routes

| Method | Path | Name | Purpose |
|---|---|---|---|
| `GET` | `/records/index` | `records.index` | List the current user's records |
| `GET` | `/records/create` | `records.create` | Show the create form |
| `POST` | `/records` | `records.store` | Create a record |
| `GET` | `/records/{record}` | `records.show` | Show one record |
| `GET` | `/records/{record}/edit` | `records.edit` | Show the edit form |
| `PUT` | `/records/{record}` | `records.update` | Save edits |
| `DELETE` | `/records/{record}` | `records.destroy` | Delete a record |

The parameter pattern `\d+` restricts `{record}` to digits. It prevents a URL such as `/records/not-a-number` from matching these routes, but it does not prove that the database record exists or that the current user owns it. The controller still looks up the record and `RecordPolicy` performs ownership authorization.

## Named routes avoid hard-coded URLs

Use the route name in a Twig template:

```twig
<a href="{{ route('records.index') }}">My records</a>
```

Or redirect from a controller:

```php
return redirect_to_route('records.show', [$record->id]);
```

If a path changes, update the route definition and keep callers using its stable name. If you see a 404, run `php pixel route:list --live` from the application root and check the method, path, name, and middleware.

## Gate-protected route

The reference app also includes `/admin-test`, which calls `Gate::authorize('access-admin')` before returning the success text. This demonstrates route-level gate authorization. The record endpoints use model-policy authorization because those decisions depend on the specific record being accessed.

## Browser form requirements

A state-changing form should use the intended HTTP method, post to its named route, include the CSRF field (`{{ csrf|raw }}`), and submit field names expected by the Form Request. In PixelFix, `routes/api.php` does not automatically mean every path is prefixed with `/api`; use the route's actual declared path unless you explicitly configure a prefix.
