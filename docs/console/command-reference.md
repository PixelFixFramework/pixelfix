# Console Command Reference

Run the following commands from the root of an existing PixelFix application. In these examples, `php pixel` is the application launcher. The list below contains commands exposed by this framework source version; hidden commands and unsupported command names are intentionally not listed.

## Help and development server

```powershell
php pixel help
php pixel help make:model
php pixel serve
php pixel serve:status
php pixel serve:restart
php pixel serve:stop
```

`help` shows the available public command list or details for one command. `serve` starts the local PHP development workflow; the status, restart, and stop commands manage that workflow.

## Managed development runtime and background processes

```powershell
php pixel dev
php pixel dev --queues=default,notifications
php pixel schedule:run
php pixel schedule:work
php pixel queue:work notifications
php pixel websockets:serve
php pixel websockets:relay
```

`dev` manages the local HTTP server and, when configured/registered, the scheduler, queue worker, WebSocket server and broadcast relay. Use `--no-server`, `--no-worker`, `--no-scheduler`, or `--no-websockets` to disable selected services; `--queues` selects worker queues and `--verbose` displays routine server output. The process supervisor stops managed child processes when the development command exits.

`schedule:run` checks due scheduled operations once. `schedule:work` checks repeatedly and is intended to be supervised when used outside the managed development runtime. The `queue:work` command starts a worker for the configured database/Redis queue driver. `websockets:serve` and `websockets:relay` are separate long-running processes; browser broadcasts require the relay to remain active. See [Scheduling](../scheduling/overview.md), [Queues](../queue/overview.md), [Broadcasting](../broadcasting/overview.md), and [WebSockets](../websockets/overview.md).

## Routes

```powershell
php pixel route:list
php pixel route:list --live
php pixel route:list --cached
php pixel route:cache
php pixel route:clear
```

Use `route:list` to confirm that the application's route files have been loaded. `--live` asks for live route information; `--cached` inspects the cached route table. `route:cache` builds the route cache, while `route:clear` removes it. After changing routes, clear or rebuild the cache as appropriate.

## Database migrations and seeders

```powershell
php pixel migrate
php pixel migrate:status
php pixel migrate:rollback
php pixel migrate:reset
php pixel migrate:refresh
php pixel migrate:fresh
php pixel db:seed
php pixel db:seed --list
php pixel db:seed --dry-run
```

- `migrate` applies pending migrations.
- `migrate:status` shows which migrations have run.
- `migrate:rollback` reverses the most recent migration batch by default; review options and data impact first.
- `migrate:reset` rolls back migration history.
- `migrate:refresh` rolls back and reruns migrations.
- `migrate:fresh` drops/rebuilds the schema by running migrations from scratch. **It can destroy application data.**
- `db:seed` runs registered/default seeders; `--list` lists seeders, and `--dry-run` previews the operation.

Several database commands offer `--force` to allow operations that require explicit confirmation. Check the individual command's help and back up important data before destructive work.

## Queue failure recovery (database queue)

```powershell
php pixel queue:failed
php pixel queue:failed --limit=50
php pixel queue:retry 123
php pixel queue:retry all
```

- `queue:failed` lists the most recent records in the database-backed `failed_jobs` table. `--limit` accepts a positive number up to 500; the default is 20.
- `queue:retry ID` re-enqueues one failed job on its original queue. Use the ID printed by `queue:failed`.
- `queue:retry all` attempts to re-enqueue every database-backed failed job. Records that cannot be re-queued are retained and reported.
- These recovery commands require `queue.default` to be `database`. They operate on the SQL `failed_jobs` records; Redis driver's separate failed-job storage is not listed by these commands.
- After a job exhausts its attempts, the queue worker records it in both `failed_jobs` and the configured `dead_letter_jobs` table. The dead-letter record is kept for diagnosis/history when the failed job is manually re-queued.

After correcting the cause of a failure—for example, SMTP host or credentials—run the retry command. Re-queued jobs are processed by a worker listening on the relevant queue, such as `php pixel queue:work notifications` or `php pixel dev --queues=default,notifications`.

## Code generators

### Models and authentication user setup

```powershell
php pixel make:model Record
php pixel make:model Record --all
php pixel make:model User --all --auth
php pixel make:user --auth --all
```

`make:model` creates a model. `--all` generates the related artifacts supported by the model generator; `--auth` selects the authentication-oriented model scaffold where supported. `make:user` generates the standard User artifact set and accepts options but does not take a model name.

### HTTP classes

```powershell
php pixel make:controller RecordController
php pixel make:controller RecordController --resource --model=Record
php pixel make:request StoreRecordRequest --model=Record
php pixel make:middleware EnsureActiveUser
php pixel make:policy RecordPolicy --model=Record
php pixel make:provider ReportingServiceProvider
```

A resource controller starts with conventional CRUD actions. A Form Request groups validation rules for a request. Middleware runs before/around a request. Policies contain authorization decisions. Providers register or initialize services.

### Database support

```powershell
php pixel make:migration create_records_table
php pixel make:factory RecordFactory --model=Record
php pixel make:seeder RecordSeeder --model=Record
```

A migration changes database structure, a factory describes sample model data, and a seeder inserts records. Review generated source before running it against a shared database.

### Views and components

```powershell
php pixel make:view records.index
php pixel make:view analytics --as=reports.analytics
php pixel make:view analytics --path=reports/analytics.twig
php pixel make:component records.summary
php pixel make:component --import dashboard.tile
php pixel make:component --import auth.login --dry-run
```

`make:view` creates a generic Twig view by default. `--as` uses dots to separate destination directories, while `--path` uses forward slashes and may include a final `.twig` extension. Both destination options are relative to `resources/views`; absolute paths and path traversal are rejected. Specify only one destination selector.

Authentication pages are opt-in presets. Each preset generates the requested page and imports the required reusable component dependency closure through the shared artifact pipeline when it is not already available:

```powershell
php pixel make:view auth.login --preset=login
php pixel make:view auth.register --preset=register
php pixel make:view auth.forgot-password --preset=forgot-password
php pixel make:view auth.reset-password --preset=reset-password
php pixel make:view auth --auth-bundle --dry-run
```

`--auth-bundle` generates login, register, forgot-password, and reset-password views under `resources/views/auth/`, plus any missing reusable components and their dependencies. Use `--as=admin.access` to place the bundle under `resources/views/admin/access/`, or `--path=admin/access` for the equivalent slash-separated namespace. For one preset, `--as` names the destination view and `--path` names its view file. `--preset=NAME` and `--auth-bundle` cannot be used together.

Component-import destination examples:

```powershell
php pixel make:component --import dashboard.tile --as=employee.ui
php pixel make:component --import dashboard.tile --path=components/employee/ui
php pixel make:component --import --group=form
```

For component imports, `--as` uses dots to separate directories. `--path` uses forward slashes and can name a directory or an explicit `.twig` file. `--group=form` imports the shared form domain to its canonical location.

### Events, notifications, mail, services, and WebSockets

```powershell
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

- `make:event`, `make:job`, `make:listener`, `make:mailable`, `make:notification`, `make:service`, and `make:websocket-handler` generate generic application class shells.
- `make:listener --event=... --create-event` places the listener and event definitions in one artifact collection so both travel through the shared generation lifecycle.
- `make:job` creates an `App\Jobs` class implementing `PixelFix\Framework\Queue\Job` and using `Queueable`; define the job's work in `handle()`. Jobs are dispatched through the existing queue API and do not require provider registration.
- `make:mailable` also defines its default Twig view as a related artifact. `--no-view` omits that generated view when the application already owns the template.
- `make:notification --channels=...` creates methods for the selected built-in channels. When `mail` is selected, a generated mailable and its view are included unless `--mailable` references an existing mailable. `--queued` adds the queue contract; `--queue` selects the queue name.
- `make:websocket-handler` creates the handler and automatically creates or updates `App\Providers\WebSocketServiceProvider` with the handler binding. Pass `--no-register` when you intend to register the handler manually. `make:provider` remains the generic provider generator for other provider classes.
- These commands generate structure, not domain behavior. Define job behavior, event data, listener actions, email content, scheduling callbacks, notification payloads and channel authorization for your application.

### API resources and tests

```powershell
php pixel make:resource RecordResource
php pixel make:test RecordTest
```

Resources shape API output; generated tests provide a starting point for application-specific assertions.

Most `make:*` commands support `--dry-run`, `--force`, and `--no-interaction` where appropriate. Check `php pixel help <command>` for the exact options.

## IDE metadata

```powershell
php pixel ide:generate
```

Generates helper files for IDE completion. These are development aids, not application runtime requirements.

## Command availability

This reference intentionally documents the command classes present in this source version. It does not include hidden framework commands or command names that are not implemented here. If your terminal reports `Command not found`, compare the command with `php pixel help` for your installed framework version.
