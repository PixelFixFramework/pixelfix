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

## Documentation index

Browse the documentation by topic. Every link below points to an existing Markdown file.

### Getting started

- [Application Structure](getting-started/application-structure.md)
- [Configuration](getting-started/configuration.md)
- [First Application](getting-started/first-application.md)
- [Installation](getting-started/installation.md)
- [Introduction](getting-started/introduction.md)
- [Learning Path](getting-started/learning-path.md)
- [Requirements](getting-started/requirements.md)

### Application walkthrough

- [Authentication](application-walkthrough/authentication.md)
- [Authorization](application-walkthrough/authorization.md)
- [Building Features](application-walkthrough/building-features.md)
- [Controllers](application-walkthrough/controllers.md)
- [Database](application-walkthrough/database.md)
- [End To End Build](application-walkthrough/end-to-end-build.md)
- [Features](application-walkthrough/features.md)
- [Introduction](application-walkthrough/introduction.md)
- [Models](application-walkthrough/models.md)
- [Quick Start](application-walkthrough/quick-start.md)
- [Routing](application-walkthrough/routing.md)
- [Testing](application-walkthrough/testing.md)
- [Trace A Request](application-walkthrough/trace-a-request.md)
- [Tutorial](application-walkthrough/tutorial.md)
- [Validation](application-walkthrough/validation.md)
- [Views](application-walkthrough/views.md)

### Architecture

- [Application Lifecycle](architecture/application-lifecycle.md)
- [Dependency Injection](architecture/dependency-injection.md)
- [Overview](architecture/overview.md)
- [Public Api](architecture/public-api.md)
- [Service Providers](architecture/service-providers.md)

### HTTP and routing

- [Controllers](http/controllers.md)
- [Csrf](http/csrf.md)
- [Json Responses](http/json-responses.md)
- [Middleware](http/middleware.md)
- [Middleware Reference](http/middleware-reference.md)
- [Requests](http/requests.md)
- [Response Reference](http/response-reference.md)
- [Responses](http/responses.md)
- [Route Cache](http/route-cache.md)
- [Route Model Binding](http/route-model-binding.md)
- [Routing](http/routing.md)
- [Routing Reference](http/routing-reference.md)

### Database and ORM

- [Connections](database/connections.md)
- [Connections Reference](database/connections-reference.md)
- [Factories](database/factories.md)
- [Migrations](database/migrations.md)
- [Model Events Observers](database/model-events-observers.md)
- [Model Reference](database/model-reference.md)
- [Models](database/models.md)
- [Orm Lifecycle](database/orm-lifecycle.md)
- [Overview](database/overview.md)
- [Query Builder](database/query-builder.md)
- [Query Builder Reference](database/query-builder-reference.md)
- [Relationships](database/relationships.md)
- [Relationships Reference](database/relationships-reference.md)
- [Schema](database/schema.md)
- [Scopes](database/scopes.md)
- [Seeders](database/seeders.md)
- [Soft Deletes](database/soft-deletes.md)
- [Transactions](database/transactions.md)
- [Upserts](database/upserts.md)

### Authentication

- [Auth Reference](authentication/auth-reference.md)
- [Guards](authentication/guards.md)
- [Overview](authentication/overview.md)
- [Password Reset](authentication/password-reset.md)
- [Providers](authentication/providers.md)
- [Tokens](authentication/tokens.md)

### Authorization

- [Gates](authorization/gates.md)
- [Overview](authorization/overview.md)
- [Policies](authorization/policies.md)
- [Policy Reference](authorization/policy-reference.md)

### Validation

- [Custom Rules](validation/custom-rules.md)
- [Overview](validation/overview.md)
- [Requests](validation/requests.md)
- [Rule Reference](validation/rule-reference.md)
- [Rules](validation/rules.md)

### Views and templates

- [Layouts](views/layouts.md)
- [Overview](views/overview.md)
- [Templates](views/templates.md)
- [Twig](views/twig.md)

### Reusable components

- [Forgot Password](components/auth/forgot-password.md)
- [Login](components/auth/login.md)
- [Register](components/auth/register.md)
- [Reset Password](components/auth/reset-password.md)
- [Tile](components/dashboard/tile.md)
- [Pagination](components/data/pagination.md)
- [Table](components/data/table.md)
- [Alert](components/feedback/alert.md)
- [Badge](components/feedback/badge.md)
- [Flash Messages](components/feedback/flash-messages.md)
- [Spinner](components/feedback/spinner.md)
- [Toast](components/feedback/toast.md)
- [Validation Errors](components/feedback/validation-errors.md)
- [Input](components/floating/input.md)
- [Select](components/floating/select.md)
- [Textarea](components/floating/textarea.md)
- [Button](components/form/button.md)
- [Checkbox](components/form/checkbox.md)
- [Input](components/form/input.md)
- [Input Group](components/form/input-group.md)
- [Radio](components/form/radio.md)
- [Range](components/form/range.md)
- [Select](components/form/select.md)
- [Textarea](components/form/textarea.md)
- [Card](components/layout/card.md)
- [Default Header](components/layout/default-header.md)
- [Footer](components/layout/footer.md)
- [Header](components/layout/header.md)
- [Documentation](components/layout/header/documentation.md)
- [Fullscreen](components/layout/header/fullscreen.md)
- [Language](components/layout/header/language.md)
- [Live Preview](components/layout/header/live-preview.md)
- [Messages](components/layout/header/messages.md)
- [Notifications](components/layout/header/notifications.md)
- [Search](components/layout/header/search.md)
- [Theme](components/layout/header/theme.md)
- [User Menu](components/layout/header/user-menu.md)
- [Main](components/layout/main.md)
- [Modal](components/layout/modal.md)
- [Sidebar](components/layout/sidebar.md)
- [Breadcrumb](components/navigation/breadcrumb.md)
- [Navbar](components/navigation/navbar.md)
- [Offcanvas](components/navigation/offcanvas.md)
- [Tabs](components/navigation/tabs.md)
- [Overview](components/overview.md)

### Console and generators

- [Command Reference](console/command-reference.md)
- [Custom Commands](console/custom-commands.md)
- [Developer Runtime](console/developer-runtime.md)
- [Doctor](console/doctor.md)
- [Generator Architecture](console/generator-architecture.md)
- [Generators](console/generators.md)
- [Overview](console/overview.md)
- [Stubs](console/stubs.md)
- [Subsystem Verification](console/subsystem-verification.md)

### API

- [Pagination](api/pagination.md)
- [Resources](api/resources.md)
- [Serialization](api/serialization.md)

### Application services

- [Exceptions](application/exceptions.md)
- [Filesystem](application/filesystem.md)
- [Logging](application/logging.md)
- [Sessions](application/sessions.md)

### Testing

- [Database Testing](testing/database-testing.md)
- [Feature Tests](testing/feature-tests.md)
- [Integration Tests](testing/integration-tests.md)
- [Overview](testing/overview.md)
- [Test Runner](testing/test-runner.md)
- [Unit Tests](testing/unit-tests.md)

### Developer guides

- [Authorization From Zero](guides/authorization-from-zero.md)
- [Building A Json Api](guides/building-a-json-api.md)
- [Debugging By Symptom](guides/debugging-by-symptom.md)
- [Framework Contributing](guides/framework-contributing.md)
- [Performance And Scale](guides/performance-and-scale.md)
- [Production Feature Walkthrough](guides/production-feature-walkthrough.md)
- [Production Readiness](guides/production-readiness.md)
- [Source And Tests](guides/source-and-tests.md)
- [Testing Real Workflows](guides/testing-real-workflows.md)
- [Websocket Channel Authorization](guides/websocket-channel-authorization.md)

### Runtime subsystems

- [Broadcasting](broadcasting/overview.md)
- [Cache](cache/overview.md)
- [Events](events/overview.md)
- [Mail](mail/overview.md)
- [Notifications](notifications/overview.md)
- [Queues](queue/overview.md)
- [Rate Limiting](rate-limiting/overview.md)
- [Redis](redis/overview.md)
- [Scheduling](scheduling/overview.md)
- [WebSockets](websockets/overview.md)

### Task Manager tutorial

- [Authentication](task-manager/authentication.md)
- [Authorization](task-manager/authorization.md)
- [Building Features](task-manager/building-features.md)
- [Component Architecture](task-manager/component-architecture.md)
- [Controllers](task-manager/controllers.md)
- [Database](task-manager/database.md)
- [End To End Build](task-manager/end-to-end-build.md)
- [Features](task-manager/features.md)
- [Introduction](task-manager/introduction.md)
- [Models](task-manager/models.md)
- [Quick Start](task-manager/quick-start.md)
- [Routing](task-manager/routing.md)
- [Scheduled Reminders](task-manager/scheduled-reminders.md)
- [Testing](task-manager/testing.md)
- [Trace A Request](task-manager/trace-a-request.md)
- [Tutorial](task-manager/tutorial.md)
- [Validation](task-manager/validation.md)
- [Views](task-manager/views.md)

### Reference

- [Capability Matrix](reference/capability-matrix.md)
- [Cli](reference/cli.md)
- [Configuration](reference/configuration.md)
- [Conventions](reference/conventions.md)
- [Environment](reference/environment.md)
- [Framework Package](reference/framework-package.md)
- [Glossary](reference/glossary.md)
- [Helpers](reference/helpers.md)
- [Releasing](reference/releasing.md)
- [Troubleshooting](reference/troubleshooting.md)


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
