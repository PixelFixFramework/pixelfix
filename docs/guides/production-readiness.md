# Production Readiness: Prepare a PixelFix Application for Real Users

A working local application is not automatically ready for production. Production readiness means that secrets are protected, requests are authenticated and authorized correctly, data changes are recoverable, errors are controlled, dependencies are configured for the real environment, and the team can observe and troubleshoot failures.

This guide is a review workflow, not a claim that one command makes an application secure.

## 1. Configure the production environment deliberately

Review `.env`, the configuration assembled from the files under `config/`, and the environment in which PHP runs. The starter configuration includes settings for the application, authentication, database connections, sessions, security, views, logging, and registered providers. The actual values in your application are authoritative; a documentation default is not proof that the live deployment uses it.

Before deployment, verify:

- `APP_ENV` reflects the production environment.
- `APP_DEBUG` is `false` for public production traffic.
- `APP_URL` and `APP_BASE_PATH` match the external application URL and path.
- the default database and all connection credentials are correct;
- session/remember-me settings match your security policy;
- secrets are set in the server's environment or a controlled secret store;
- `.env` and other secret-bearing files are not committed to source control or exposed from the web root.

Do not copy development secrets into production. Do not display environment variables, connection strings, passwords, tokens, or request headers in public error pages.

## 2. Configure the web server's document root

The public document root should point to the application's `public/` directory, not the entire project root. The project root can contain source code, configuration, database migration files, logs, and environment settings that should not be publicly downloadable.

Verify that the web server routes requests through the intended public entry point, that static assets load, and that direct requests for `.env`, source files, logs, or backups cannot be served. Apply file permissions so the web process can read what it needs and write only to designated runtime directories.

Use HTTPS for public traffic. Configure TLS at the web server or trusted proxy, redirect HTTP to HTTPS where appropriate, and configure forwarded-proxy trust carefully. Do not trust arbitrary `X-Forwarded-*` headers from the public internet.

## 3. Review every route as a security boundary

For each route, ask:

- Is the HTTP method appropriate?
- Is the route intended to be public, authenticated, or restricted to a particular ability?
- Does it validate request data before persistence?
- Does it scope queries to the current user's allowed records?
- Does it authorize access to a concrete model before update/delete/restore/force-delete?
- Does it return only the fields the caller is allowed to see?
- Does a failed request stop before any unauthorized write takes place?

A route protected by `auth` is not automatically protected from access by another authenticated user. Use Gates and Policies for authorization and scope database queries to the user's permitted records. A hidden menu item is not a security boundary.

## 4. Treat generated policy and request stubs as starting points

The generic `make:policy` stub currently includes methods that return `true`. It is a generation scaffold, not a secure policy to deploy unchanged. Replace permissive rules for every ability that matters and add tests proving denied users cannot perform the operation.

The generic Form Request stub's `authorize()` method also returns `true`. Define the authorization needed for that request or enforce authorization at the controller/policy boundary. Validation only checks input shape and rules; it does not establish whether the caller is allowed to change the target record.

Review these files immediately after generating them. Never infer security from the fact that a class was generated.

## 5. Protect browser forms against CSRF

Browser routes that use session authentication should use the documented `web` middleware group or the correct combination of session and CSRF middleware. Include the framework's CSRF token in state-changing browser forms. Do not disable CSRF protection for convenience on a session-authenticated route.

CSRF protection and authentication solve different problems: a valid session says who the browser is acting as, while the CSRF token helps ensure a cross-site page cannot silently cause that browser to submit an unintended state-changing request. API endpoints authenticated by bearer tokens have a different threat model, but must still be configured deliberately.

See [CSRF Protection](../http/csrf.md) and [Middleware](../http/middleware.md).

## 6. Protect data at every layer

### Validation

Validate request fields and persist only the validated payload. Constrain enumerated values such as status fields with `in:...`; apply length rules; verify foreign IDs through trusted queries and authorization; and consider uniqueness and database constraints as well as validation. Validation is helpful feedback, but database constraints are still necessary to enforce data integrity under concurrent requests.

### Mass assignment

Review each model's `$fillable` or other assignment strategy. Keep server-owned values such as `role`, `user_id`, account status, and privileged flags out of ordinary user-controlled input. Setting a field manually in trusted server code is different from accepting the same field from a client.

### Serialization

Use `$hidden`/`$visible` or an API resource that explicitly selects public fields. Never return password hashes, remember tokens, reset tokens, private notes, or internal permissions by accident.

### SQL

Use query-builder parameters instead of interpolating input into SQL. Validate requested sort columns against an allowlist. Do not pass raw SQL fragments directly from user input.

### Destructive operations

A soft delete leaves a record in the database; a force delete removes it. Require explicit authorization for delete, restore, and permanent purge operations. Back up important data and understand migration rollback effects before running destructive database commands.

## 7. Authentication review

Confirm that the configured user provider points to the correct model and password column. Verify that password storage uses the framework's intended password hashing/verification path, that login failures do not reveal whether an email exists when this matters to your threat model, and that logout revokes session/token state as configured.

For APIs, configure the intended token guard and permission policy. Token-based authentication is not automatically enabled merely because a route lives in `routes/api.php`. Keep token values secret, give tokens only the scopes/abilities needed, and provide a tested revocation path.

Password reset requires more than displaying a reset form: review token expiry, throttling, storage, single-use behavior, email delivery integration, and account-enumeration behavior. PixelFix includes password-reset token infrastructure, but the application must still wire a user-facing delivery mechanism appropriate to its deployment.

## 8. Database release procedure

Before applying migrations to production:

1. Read every pending migration.
2. Determine whether it locks or rewrites a large table.
3. Back up the database and verify that the backup can be restored.
4. Test the migration against the same database engine and a representative data volume.
5. Plan how the previous application version behaves with the changed schema.
6. Apply migrations using your deployment's controlled release process.
7. Verify migration status and test the key application flows.

Commands such as `migrate:fresh`, `migrate:refresh`, and `migrate:reset` can drop or reverse existing schema/data. They are development/test tools unless you have explicitly reviewed their impact. Never use a destructive migration command on production just because it resolves a local schema problem.

## 9. Build and clear route caches deliberately

PixelFix supports route-list inspection and route caching. Inspect live routes while developing. For a stable deployment, build the route cache only if the deployment uses it; after route changes, clear or rebuild the cache as appropriate. A stale route cache can make correct source code appear not to register a route.

Twig template caching is separate from route caching. Do not confuse either with a general application data cache: this framework version does not include a general cache store/facade for arbitrary application values.

## 10. Logging and error handling

Log enough context to diagnose a failure, such as a request ID, feature name, model ID, operation, and exception category. Avoid logging passwords, access tokens, session IDs, complete request bodies containing personal data, or database credentials.

Production error pages should not display stack traces, SQL, source paths, or secrets. Use structured, safe messages for clients and retain appropriate diagnostic details in protected server logs. Check log rotation, disk capacity, permissions, and retention; a logging configuration is not useful if logs cannot be written or grow without limit.

## 11. Performance and resilience checks

- Paginate large lists rather than returning the entire table.
- Eager load relations that a page repeatedly consumes.
- Add indexes based on real filter/sort patterns.
- Keep transactions short and protect multi-row invariants with constraints.
- Consider concurrency when two requests may update the same record.
- Use chunking for bulk work rather than loading everything into memory.
- Test with the production database driver; an in-memory SQLite test can behave differently from MySQL/MariaDB.
- Define external strategy for queues, caching, mail delivery, and scheduling if the application needs them; these are not built-in subsystems in this framework source version.

## 12. Pre-release verification checklist

Before releasing, verify at minimum:

- [ ] Debug mode is off and secrets are private.
- [ ] The web root is the `public/` directory.
- [ ] HTTPS and proxy trust are configured intentionally.
- [ ] All public, authenticated, and admin routes have been reviewed.
- [ ] Every generated policy's permissive defaults have been replaced.
- [ ] Form Request authorization and validation are correct.
- [ ] User ownership is assigned by server code, not trusted from request data.
- [ ] API resources expose only approved fields.
- [ ] CSRF/session behavior is tested for browser forms.
- [ ] Token use, expiry/revocation, and authorization are tested for API clients.
- [ ] Migrations have a backup/recovery plan.
- [ ] Database indexes and slow queries have been reviewed.
- [ ] Error responses do not reveal internal implementation details.
- [ ] Logs are writable, protected, monitored, and rotated.
- [ ] Routes and critical workflows are tested from a clean deployment.
- [ ] External services not included in PixelFix have explicit operational ownership.

Related reading: [Environment](../reference/environment.md), [Configuration](../getting-started/configuration.md), [Authorization from Zero](authorization-from-zero.md), [CSRF](../http/csrf.md), [Transactions](../database/transactions.md), [Performance and Scale](performance-and-scale.md), and [Troubleshooting](../reference/troubleshooting.md).
