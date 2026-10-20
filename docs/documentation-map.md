# PixelFix Documentation Map

This is the central documentation set for PixelFix. The current framework source/API and its tests define supported behavior; the application starter owns these user-facing guides. Framework and Task Manager packages do not carry their own documentation tree, and newly scaffolded apps do not get a duplicate `docs/` folder from the framework package.

## Start here

- [Learning Path](getting-started/learning-path.md)
- [Build Your First PixelFix Page](getting-started/first-application.md)
- [Architecture](architecture/overview.md)
- [Routing](http/routing.md)
- [Views and Components](views/overview.md)
- [Database](database/overview.md)
- [Authentication](authentication/overview.md)
- [Authorization](authorization/overview.md)
- [Testing](testing/overview.md)

## Runtime subsystems

- [Cache](cache/overview.md)
- [Events](events/overview.md)
- [Mail](mail/overview.md)
- [Notifications](notifications/overview.md)
- [Queues](queue/overview.md)
- [Rate Limiting](rate-limiting/overview.md)
- [Redis and Pub/Sub](redis/overview.md)
- [Scheduling](scheduling/overview.md)
- [Broadcasting](broadcasting/overview.md)
- [WebSockets](websockets/overview.md)

## API references

- [Capability Matrix](reference/capability-matrix.md)
- [Configuration](reference/configuration.md)
- [Environment Variables](reference/environment.md)
- [Helpers](reference/helpers.md)
- [Command Reference](console/command-reference.md)
- [Framework Package](reference/framework-package.md)
- [Framework Contribution Guide](guides/framework-contributing.md)

## Complete file inventory

The tree below is generated from the Markdown files present in the PixelFix `docs/` directory, not from framework stubs. Review this map when documentation is added or moved.

```text
docs/
├── api
│   ├── pagination.md
│   ├── resources.md
│   └── serialization.md
├── application
│   ├── exceptions.md
│   ├── filesystem.md
│   ├── logging.md
│   └── sessions.md
├── application-walkthrough
│   ├── authentication.md
│   ├── authorization.md
│   ├── building-features.md
│   ├── controllers.md
│   ├── database.md
│   ├── end-to-end-build.md
│   ├── features.md
│   ├── introduction.md
│   ├── models.md
│   ├── quick-start.md
│   ├── routing.md
│   ├── testing.md
│   ├── trace-a-request.md
│   ├── tutorial.md
│   ├── validation.md
│   └── views.md
├── architecture
│   ├── application-lifecycle.md
│   ├── dependency-injection.md
│   ├── overview.md
│   ├── public-api.md
│   └── service-providers.md
├── authentication
│   ├── auth-reference.md
│   ├── guards.md
│   ├── overview.md
│   ├── password-reset.md
│   ├── providers.md
│   └── tokens.md
├── authorization
│   ├── gates.md
│   ├── overview.md
│   ├── policies.md
│   └── policy-reference.md
├── broadcasting
│   └── overview.md
├── cache
│   └── overview.md
├── components
│   ├── auth
│   │   ├── forgot-password.md
│   │   ├── login.md
│   │   ├── register.md
│   │   └── reset-password.md
│   ├── dashboard
│   │   └── tile.md
│   ├── data
│   │   ├── pagination.md
│   │   └── table.md
│   ├── feedback
│   │   ├── alert.md
│   │   ├── badge.md
│   │   ├── flash-messages.md
│   │   ├── spinner.md
│   │   ├── toast.md
│   │   └── validation-errors.md
│   ├── floating
│   │   ├── input.md
│   │   ├── select.md
│   │   └── textarea.md
│   ├── form
│   │   ├── button.md
│   │   ├── checkbox.md
│   │   ├── input-group.md
│   │   ├── input.md
│   │   ├── radio.md
│   │   ├── range.md
│   │   ├── select.md
│   │   └── textarea.md
│   ├── layout
│   │   ├── header
│   │   │   ├── documentation.md
│   │   │   ├── fullscreen.md
│   │   │   ├── language.md
│   │   │   ├── live-preview.md
│   │   │   ├── messages.md
│   │   │   ├── notifications.md
│   │   │   ├── search.md
│   │   │   ├── theme.md
│   │   │   └── user-menu.md
│   │   ├── card.md
│   │   ├── default-header.md
│   │   ├── footer.md
│   │   ├── header.md
│   │   ├── main.md
│   │   ├── modal.md
│   │   └── sidebar.md
│   ├── navigation
│   │   ├── breadcrumb.md
│   │   ├── navbar.md
│   │   ├── offcanvas.md
│   │   └── tabs.md
│   └── overview.md
├── console
│   ├── command-reference.md
│   ├── custom-commands.md
│   ├── developer-runtime.md
│   ├── doctor.md
│   ├── generator-architecture.md
│   ├── generators.md
│   ├── overview.md
│   ├── stubs.md
│   └── subsystem-verification.md
├── database
│   ├── connections-reference.md
│   ├── connections.md
│   ├── factories.md
│   ├── migrations.md
│   ├── model-events-observers.md
│   ├── model-reference.md
│   ├── models.md
│   ├── orm-lifecycle.md
│   ├── overview.md
│   ├── query-builder-reference.md
│   ├── query-builder.md
│   ├── relationships-reference.md
│   ├── relationships.md
│   ├── schema.md
│   ├── scopes.md
│   ├── seeders.md
│   ├── soft-deletes.md
│   ├── transactions.md
│   └── upserts.md
├── events
│   └── overview.md
├── getting-started
│   ├── application-structure.md
│   ├── configuration.md
│   ├── first-application.md
│   ├── installation.md
│   ├── introduction.md
│   ├── learning-path.md
│   └── requirements.md
├── guides
│   ├── authorization-from-zero.md
│   ├── building-a-json-api.md
│   ├── debugging-by-symptom.md
│   ├── framework-contributing.md
│   ├── performance-and-scale.md
│   ├── production-feature-walkthrough.md
│   ├── production-readiness.md
│   ├── source-and-tests.md
│   ├── testing-real-workflows.md
│   └── websocket-channel-authorization.md
├── http
│   ├── controllers.md
│   ├── csrf.md
│   ├── json-responses.md
│   ├── middleware-reference.md
│   ├── middleware.md
│   ├── requests.md
│   ├── response-reference.md
│   ├── responses.md
│   ├── route-cache.md
│   ├── route-model-binding.md
│   ├── routing-reference.md
│   └── routing.md
├── mail
│   └── overview.md
├── notifications
│   └── overview.md
├── queue
│   └── overview.md
├── rate-limiting
│   └── overview.md
├── redis
│   └── overview.md
├── reference
│   ├── capability-matrix.md
│   ├── cli.md
│   ├── configuration.md
│   ├── conventions.md
│   ├── environment.md
│   ├── framework-package.md
│   ├── glossary.md
│   ├── helpers.md
│   ├── releasing.md
│   └── troubleshooting.md
├── scheduling
│   └── overview.md
├── task-manager
│   ├── authentication.md
│   ├── authorization.md
│   ├── building-features.md
│   ├── component-architecture.md
│   ├── controllers.md
│   ├── database.md
│   ├── end-to-end-build.md
│   ├── features.md
│   ├── introduction.md
│   ├── models.md
│   ├── quick-start.md
│   ├── routing.md
│   ├── scheduled-reminders.md
│   ├── testing.md
│   ├── trace-a-request.md
│   ├── tutorial.md
│   ├── validation.md
│   └── views.md
├── testing
│   ├── database-testing.md
│   ├── feature-tests.md
│   ├── integration-tests.md
│   ├── overview.md
│   ├── test-runner.md
│   └── unit-tests.md
├── validation
│   ├── custom-rules.md
│   ├── overview.md
│   ├── requests.md
│   ├── rule-reference.md
│   └── rules.md
├── views
│   ├── layouts.md
│   ├── overview.md
│   ├── templates.md
│   └── twig.md
├── websockets
│   └── overview.md
└── documentation-map.md
```
