# PixelFix Capability Matrix

This matrix describes the framework source represented by PixelFix Framework v0.5.0. The public implementation and its tests define the contract. An API's existence does not mean application-specific domain behavior has been generated or configured for you.

| Subsystem | Built-in framework capability | Application responsibilities | Guide |
|---|---|---|---|
| Application lifecycle and container | Bootstrap, configuration repository, service providers, dependency resolution | Define application providers and bindings | [Architecture](../architecture/overview.md), [Lifecycle](../architecture/application-lifecycle.md) |
| HTTP and routing | Named routes, route groups, middleware, controllers, requests, response factory, route cache and model binding | Define URLs, business logic, access rules and API contracts | [Routing](../http/routing.md), [Controllers](../http/controllers.md), [Responses](../http/responses.md) |
| Views and components | Twig rendering, layouts and bundled reusable component templates; component generators/import pipeline | Compose page-specific content and pass explicit component data | [Views](../views/overview.md), [Components](../components/overview.md) |
| Database and ORM | PDO-backed drivers, schema/migrations, models, relationships, query builder, factories, seeders, transactions, upserts, soft deletes and model observers | Design schema/indexes, business constraints and operational backups | [Database](../database/overview.md), [Models](../database/models.md) |
| Validation | Built-in rule engine, validator, Form Requests and custom rules | Define rules for each application input | [Validation](../validation/overview.md) |
| Authentication | Guards/providers, password verification, session auth, remember-me and password-reset token infrastructure | Configure user model/provider, auth routes/controllers, email delivery and user lifecycle | [Authentication](../authentication/overview.md) |
| Authorization | Gates, policies and authorization middleware | Implement the role/permission model and assignment workflows | [Authorization](../authorization/overview.md) |
| Sessions and CSRF | Session storage, flash/old-input and CSRF middleware/helpers | Configure cookie policy and correctly group browser routes | [Sessions](../application/sessions.md), [CSRF](../http/csrf.md) |
| General application events | Synchronous dispatcher, listeners, subscribers, priorities, wildcard matching, contexts/envelopes and testing fake | Define event types, listeners and failure behavior | [Events](../events/overview.md) |
| Model lifecycle events | Model observer/lifecycle hooks around persistence | Implement model-specific side effects and keep them safe on model operations | [Model Events & Observers](../database/model-events-observers.md) |
| Queue and jobs | `Job` contract, `Queueable`, dispatch/batch APIs, sync/database/Redis drivers, worker and failure/dead-letter handling | Write idempotent job behavior, choose driver and keep workers running | [Queues](../queue/overview.md) |
| Scheduling | Callback/command tasks, cron intervals, due-task runner and overlap protection | Register tasks in application providers and run `schedule:run` or a supervised worker | [Scheduling](../scheduling/overview.md) |
| Cache | `array` and `file` stores, TTL operations, remember helpers, locks and tags | Choose driver/path, key scheme, expiry and invalidation strategy | [Cache](../cache/overview.md) |
| Rate limiting | Cache-backed counters, attempt windows, remaining/retry calculations and lock-assisted attempts | Choose identifiers, limits and decay intervals appropriate to each action | [Rate Limiting](../rate-limiting/overview.md) |
| Mail | SMTP mail manager, Twig-backed `Mailable`, fake and assertions | Configure valid SMTP credentials and write mail templates | [Mail](../mail/overview.md) |
| Notifications | Mail, database and broadcast channels; recipient routing and optional queued notification behavior | Choose channels, implement channel payloads, run migrations and workers as required | [Notifications](../notifications/overview.md) |
| Redis | Named connections and Redis Pub/Sub publisher/subscriber | Provision Redis, install `ext-redis`, handle reconnect/idempotency | [Redis](../redis/overview.md) |
| Broadcasting | Channel/payload manager, `ShouldBroadcast` events, Redis broadcaster and fake | Select channels, payload shape, authorization and delivery strategy | [Broadcasting](../broadcasting/overview.md) |
| WebSockets | Server/connection handling, public/private/presence channel APIs, handlers and authenticated Redis relay | Configure origins, channel authorization, payload rules and supervised processes | [WebSockets](../websockets/overview.md) |
| Filesystem | Local storage manager and `storage()` helper | Set retention/permissions and add cloud object storage integration if needed | [Filesystem](../application/filesystem.md) |
| Logging and exceptions | Configured logger/reporting and centralized exception flow | Choose levels, retention, alerting and safe user-facing errors | [Logging](../application/logging.md), [Exceptions](../application/exceptions.md) |
| Testing | Test runner, `TestCase`, assertion helpers, runtime/component and database test support | Write app-specific unit, integration, security and workflow tests | [Testing](../testing/overview.md) |
| Console and generators | Public CLI commands and declarative, staged artifact-generation lifecycle | Review generated artifacts and implement domain behavior | [Command Reference](../console/command-reference.md), [Generators](../console/generators.md) |

## Important subsystem boundaries

- `events()` dispatches in-process application events. It is not a durable queue. Use `queue()` for deferred work and Redis Pub/Sub or broadcasting when data must cross process boundaries.
- ORM observers are model persistence hooks and are not a substitute for a general event dispatcher.
- Queue execution requires a worker for database/Redis drivers. `sync` executes jobs in the current process. A defined job is not executed asynchronously until it is dispatched through a configured queue and a worker is running.
- Scheduled tasks are registered by each application. PixelFix supplies the scheduler and task API, not a universal list of business operations. `schedule:run` is intended to be invoked on a regular OS schedule; `schedule:work` is a long-running alternative.
- Cache drivers in this version are `array` and `file`; these are not a distributed Redis cache store. Choose accordingly for multi-process or multi-host deployments.
- Mail supports SMTP in this version. Valid SMTP configuration is required for real delivery. Mail sending alone is synchronous; queue it explicitly for asynchronous delivery.
- Notification channels do not remove the need to configure SMTP, run the database notification migration, configure broadcasting, or start a queue worker for queued notifications.
- Broadcasting is immediately executed through its configured broadcaster. WebSocket serving and the Redis broadcast relay are separate long-running processes.
- Gates and policies make authorization decisions but do not automatically create role/permission tables or administrative management workflows.

## Public runtime commands

Use the launcher included by the application. The supported public command set can be inspected with `php pixel help` (or the launcher name shipped by that application). Useful commands include `route:list`, migration/seed commands, `queue:work`, `schedule:run`, `schedule:work`, `websockets:serve`, `websockets:relay`, and `dev`; see the [CLI reference](../reference/cli.md) and [command reference](../console/command-reference.md).

## Verifying a capability

Before depending on behavior, inspect the public contract and implementation in the installed version, then exercise the exact behavior in an application-level test. A configuration key or generated class shell is not proof that business behavior is implemented. Likewise, a UI component is presentation; server-side validation and authorization must still enforce the underlying rules.
