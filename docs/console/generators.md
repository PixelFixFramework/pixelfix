# Generators

PixelFix generators create application artifacts from framework stubs and conventions.

## Common generator commands

```bash
php pixel make:model Record
php pixel make:controller RecordController
php pixel make:middleware AuthMiddleware
php pixel make:migration create_records_table
php pixel make:factory RecordFactory --model=Record
php pixel make:seeder RecordSeeder --model=Record
php pixel make:request StoreRecordRequest --model=Record
php pixel make:policy RecordPolicy --model=Record
php pixel make:provider AuthServiceProvider
php pixel make:resource RecordResource
php pixel make:view welcome
php pixel make:view records.index
php pixel make:test RecordTest
php pixel make:event OrderPlacedEvent
php pixel make:job Reports/GenerateMonthlyReportJob
php pixel make:listener SendReceiptListener --event=OrderPlacedEvent --create-event
php pixel make:mailable OrderReceiptMailable
php pixel make:notification OrderPlacedNotification --channels=database,broadcast,mail --queued --queue=notifications
php pixel make:service InvoiceReminderService
php pixel make:websocket-handler PrivateChannelHandler
```

Most generators support `--force`, `--dry-run`, and `--no-interaction`.

The view generator creates Twig templates under `resources/views`. View names may use slash notation (`records/index`) or dot notation (`records.index`); a trailing `.twig` extension is optional. Invalid absolute paths and parent-directory traversal are rejected by the view validation service.

## Events, jobs, notifications, mail, services, and WebSockets

These commands generate domain-neutral class shells under the application's conventional directories. They use `GeneratorCommand`, `DefinitionFactory`, and `DefinitionCollection`; they do not write files through a parallel file-generation path.

```bash
php pixel make:event OrderPlacedEvent
php pixel make:job Reports/GenerateMonthlyReportJob
php pixel make:listener SendReceiptListener --event=OrderPlacedEvent --create-event
php pixel make:mailable OrderReceiptMailable
php pixel make:mailable ExistingTemplateMailable --no-view
php pixel make:notification OrderPlacedNotification --channels=database,broadcast,mail --queued --queue=notifications
php pixel make:notification OrderPlacedNotification --channels=database --mailable=App\Mail\OrderReceiptMailable
php pixel make:service InvoiceReminderService
php pixel make:websocket-handler PrivateChannelHandler
php pixel make:provider EventServiceProvider
php pixel make:provider ScheduleServiceProvider
```

### Related artifacts

- `make:job` generates a class under `app/Jobs` that implements the framework `Job` contract and uses `Queueable`. Implement `handle()` with the work to perform; configure the queue, delay, retry attempts, timeout, backoff, and tags through the trait or dispatch API as required. Jobs are application artifacts and do not require provider registration.

- `make:listener --event=... --create-event` explicitly adds both the listener definition and event definition to one `DefinitionCollection`. The shared relationship resolver fills the event type reference before the standard lifecycle processes each artifact.
- `make:mailable` adds its default Twig view as an implicit related definition. The view definition uses the same logical-name and path conventions as `make:view`. If the view already exists, the pipeline preserves it.
- `make:notification` generates channel methods for the requested built-in channels. Selecting `mail` includes a related mailable and Twig view unless `--mailable` names an existing mailable. `--queued` adds `ShouldQueue`, and `--queue` chooses the queue name.
- `make:websocket-handler` generates the handler and automatically creates or updates `App\Providers\WebSocketServiceProvider` to bind `WebSocketHandler::class` to the new handler. Use `--no-register` to leave the binding for manual registration. `make:provider` remains the generic provider generator for other application-specific providers.

The generated code is intentionally a starting shell. Developers supply job behavior, event properties, listener behavior, notification payloads, email subjects and data, scheduled callbacks, and WebSocket authorization policy. The framework must not assume a particular application's domain.

## Model generation

The model generator has additional composition features:

```bash
php pixel make:model Record --all
```

The `--all` workflow builds related artifacts for the model. In the current implementation that includes the model plus a migration, factory, root database seeder integration, and a model seeder.

For the authentication user setup:

```bash
php pixel make:model User --all --auth
```

The authentication option is intended for the `User` model generation path.

## Resource controllers

The controller generator supports resource mode and an optional model:

```bash
php pixel make:controller RecordController --resource --model=Record
```

## Generator safety options

### `--dry-run`

Plans and displays the generation operation without committing the generated artifacts.

### `--force`

Allows an existing artifact to be overwritten when the generator's resolution rules permit it.

### `--no-interaction`

Disables interactive prompts and makes the command suitable for scripted workflows.

## Artifact-oriented generation

Generators are not implemented as isolated string-copy commands. The current system builds artifact definitions, discovers project state, validates those artifacts, resolves conflicts, creates a generation plan, generates source, runs workflow operations, and displays the result.

See [Generator Architecture](generator-architecture.md) for the internal lifecycle.
