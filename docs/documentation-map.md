# PixelFix Documentation Map

This map is generated from the current documentation bundle. The current PixelFix framework source, framework tests, and Task Manager implementation remain the technical source of truth.

## Current pages

```text
docs/

├── README.md

├── api
│   ├── pagination.md
│   ├── resources.md
│   └── serialization.md

├── application
│   ├── exceptions.md
│   ├── filesystem.md
│   ├── logging.md
│   └── sessions.md

├── architecture
│   ├── application-lifecycle.md
│   ├── dependency-injection.md
│   ├── overview\.md
│   ├── public-api.md
│   └── service-providers.md

├── authentication
│   ├── auth-reference.md
│   ├── guards.md
│   ├── overview\.md
│   ├── password-reset.md
│   ├── providers.md
│   └── tokens.md

├── authorization
│   ├── gates.md
│   ├── overview\.md
│   ├── policies.md
│   └── policy-reference.md

├── components
│   ├── auth
│   │   ├── login.md
│   │   └── register.md
│   │
│   ├── dashboard
│   │   └── tile.md
│   │
│   ├── data
│   │   ├── pagination.md
│   │   └── table.md
│   │
│   ├── feedback
│   │   ├── alert.md
│   │   ├── badge.md
│   │   ├── flash-messages.md
│   │   ├── spinner.md
│   │   ├── toast.md
│   │   └── validation-errors.md
│   │
│   ├── floating
│   │   ├── input.md
│   │   ├── select.md
│   │   └── textarea.md
│   │
│   ├── form
│   │   ├── button.md
│   │   ├── checkbox.md
│   │   ├── input-group.md
│   │   ├── input.md
│   │   ├── radio.md
│   │   ├── range.md
│   │   ├── select.md
│   │   └── textarea.md
│   │
│   ├── layout
│   │   ├── card.md
│   │   ├── default-header.md
│   │   ├── footer.md
│   │   ├── header.md
│   │   ├── main.md
│   │   ├── modal.md
│   │   ├── sidebar.md
│   │   │
│   │   └── header
│   │       ├── documentation.md
│   │       ├── fullscreen.md
│   │       ├── language.md
│   │       ├── live-preview.md
│   │       ├── messages.md
│   │       ├── notifications.md
│   │       ├── search.md
│   │       ├── theme.md
│   │       └── user-menu.md
│   │
│   └── navigation
│       ├── breadcrumb.md
│       ├── navbar.md
│       ├── offcanvas.md
│       └── tabs.md

├── console
│   ├── command-reference.md
│   ├── custom-commands.md
│   ├── generator-architecture.md
│   ├── generators.md
│   ├── overview\.md
│   └── stubs.md

├── database
│   ├── connections-reference.md
│   ├── connections.md
│   ├── factories.md
│   ├── migrations.md
│   ├── model-events-observers.md
│   ├── model-reference.md
│   ├── models.md
│   ├── orm-lifecycle.md
│   ├── overview\.md
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

├── documentation-map.md

├── getting-started
│   ├── application-structure.md
│   ├── configuration.md
│   ├── first-application.md
│   ├── installation.md
│   ├── introduction.md
│   └── requirements.md

├── http
│   ├── controllers.md
│   ├── csrf.md
│   ├── middleware-reference.md
│   ├── middleware.md
│   ├── requests.md
│   ├── response-reference.md
│   ├── responses.md
│   ├── route-cache.md
│   ├── route-model-binding.md
│   ├── routing-reference.md
│   └── routing.md

├── reference
│   ├── cli.md
│   ├── configuration.md
│   ├── conventions.md
│   ├── environment.md
│   ├── helpers.md
│   ├── releasing.md
│   └── troubleshooting.md

├── task-manager
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

├── testing
│   ├── database-testing.md
│   ├── feature-tests.md
│   ├── integration-tests.md
│   ├── overview\.md
│   ├── test-runner.md
│   └── unit-tests.md

├── validation
│   ├── custom-rules.md
│   ├── overview\.md
│   ├── requests.md
│   ├── rule-reference.md
│   └── rules.md

└── views
    ├── layouts.md
    ├── overview\.md
    ├── templates.md
    └── twig.md

```

## Documentation principles

1. **Implementation first.** Current source code and tests take precedence over historical examples.
2. **Examples are real.** Task Manager examples should match the current reference application wherever practical.
3. **Public API first.** Application developers should not need to depend on internal framework pipeline classes.
4. **Unsupported features are not advertised as shipped.**
5. **Reference examples are explicit about current maturity.** Empty or incomplete application test suites are documented as such rather than presented as completed coverage.
