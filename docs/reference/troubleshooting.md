# Troubleshooting

When something goes wrong, change one thing at a time and use the error message to narrow the problem. The most common failures involve the current directory, route registration, database configuration, input validation, authorization, or a Twig template reference.

## The console says a command is not found

Run commands from the application root and check:

```powershell
php pixel help
```

The command must exist in the installed framework version. Do not assume that commands from another framework or an older PixelFix version exist. Use the installer documentation for project-creation tasks; application commands are run after a project exists.

## The application will not start

Check PHP and dependencies:

```powershell
php -v
composer install
```

Review the first exception in the console output and the application logs under `storage/`. Check that `bootstrap/app.php`, the relevant files under `config/` (such as `config/app.php`), and `public/index.php` exist in the expected locations.

## A URL returns 404

Inspect the route list:

```powershell
php pixel route:list --live
php pixel route:list --cached
```

If the live list contains the route but the cached list does not, clear or rebuild the route cache as appropriate. Check the HTTP method as well: a route declared for POST does not handle a browser GET request to the same path.

## Database connection or migration errors

Confirm that the database server is running, `config/database.php` reads the expected `.env` values, the database/user exist, and the current PHP runtime has the matching PDO driver enabled. Review `migrate:status` before trying to migrate. Do not use a destructive rebuild to diagnose a production connection issue.

## Validation or CSRF errors

For validation, confirm the field names in the form match the rules in the Form Request and that the controller uses validated data. For CSRF errors, check that the form submits a token and that session/web middleware is active. Do not disable protection to make a form work.

## Authorization errors

Authentication means the user is signed in; authorization means that user is permitted to perform this action. Check the active guard, policy registration, method name, and ownership rule. Hiding a button in Twig does not protect a route—server-side authorization is required.

## Twig errors

Confirm the view name maps to a file under `resources/views/`, that the template extends the right layout, and that each included component exists. If Twig says a variable is undefined, check the controller's data keys and the name used in the template. A generated view does not automatically import components it includes.

## General debugging method

1. Reproduce the problem with the smallest request or command.
2. Read the exact reason and the first application file in the stack trace.
3. Verify the relevant configuration/path/name in the source.
4. Fix one cause, then rerun the narrowest relevant test.
5. Add a regression test if this behavior should remain correct in the future.
