# Command-Line Reference

Run application commands from the project root using `php pixel <command>`. Do not assume a command exists because another PHP framework has it; the list below is based on the commands shipped in this PixelFix source version.

## Find commands and options

```powershell
php pixel help
php pixel help make:model
php pixel route:list --help
```

The help output is the quickest way to confirm the exact syntax in the version installed in your project.

## Run and inspect the application

```powershell
php pixel serve
php pixel serve:status
php pixel serve:restart
php pixel serve:stop
php pixel route:list
php pixel route:cache
php pixel route:clear
```

Route caching is primarily useful when the route definitions are stable. Clear or rebuild the cache after changing route files.

## Managed runtime, scheduling, queues and WebSockets

```powershell
php pixel dev
php pixel dev --queues=default,notifications
php pixel schedule:run
php pixel schedule:work
php pixel queue:work notifications
php pixel websockets:serve
php pixel websockets:relay
```

Use `dev` for the local supervised runtime. The scheduler appears only when scheduled operations have been registered, queue workers run for `database` or `redis` queue drivers, and WebSocket server/relay processes run when WebSockets are enabled. `schedule:run` performs one due-task check; `schedule:work` is a long-running loop. For production, arrange a scheduler invocation or supervised worker in the deployment environment. See the dedicated [scheduling](../scheduling/overview.md), [queue](../queue/overview.md), and [WebSocket](../websockets/overview.md) references.

## Database commands

```powershell
php pixel migrate
php pixel migrate:status
php pixel migrate:rollback
php pixel migrate:reset
php pixel migrate:refresh
php pixel migrate:fresh
php pixel db:seed
php pixel db:seed --list
```

Read [Migrations](../database/migrations.md) and [Seeders](../database/seeders.md) before running destructive or data-changing operations. `migrate:fresh` rebuilds the schema and may destroy data.

## Generators

```powershell
php pixel make:model record
php pixel make:model record --all
php pixel make:user --auth --all
php pixel make:controller RecordController --resource --model=record
php pixel make:request StoreRecordRequest --model=record
php pixel make:middleware EnsureActiveUser
php pixel make:policy RecordPolicy --model=record
php pixel make:provider ReportingServiceProvider
php pixel make:migration create_records_table
php pixel make:factory RecordFactory --model=record
php pixel make:seeder RecordSeeder --model=record
php pixel make:resource RecordResource
php pixel make:view records.index
php pixel make:view analytics --as=reports.analytics
php pixel make:view analytics --path=reports/analytics.twig
php pixel make:view auth.login --preset=login
php pixel make:view auth --auth-bundle --dry-run
php pixel make:component records.summary
php pixel make:test RecordTest
php pixel make:event OrderPlacedEvent
php pixel make:job Reports/GenerateMonthlyReportJob
php pixel make:listener SendReceiptListener --event=OrderPlacedEvent --create-event
php pixel make:mailable OrderReceiptMailable
php pixel make:notification OrderPlacedNotification --channels=database,broadcast,mail --queued --queue=notifications
php pixel make:service InvoiceReminderService
php pixel make:websocket-handler PrivateChannelHandler
php pixel make:provider EventServiceProvider
php pixel make:provider ScheduleServiceProvider
```

The generator writes a starting artifact using PixelFix conventions. After generation, open the file and implement the actual application behavior.

## Import bundled components

```powershell
php pixel make:component --import auth.login
php pixel make:component --import dashboard.tile --dry-run
php pixel make:component --import dashboard.tile --as=employee.ui
php pixel make:component --import dashboard.tile --path=components/employee/ui
php pixel make:component --import --group=form
```

`make:component --import` copies existing component templates from PixelFix's bundled component catalog. It resolves fixed dependencies by default and reuses already-present dependencies rather than prompting to replace them. Use `--dry-run` to preview the import before writing files.

`make:view` supports `--as` with dot-separated directories and `--path` with forward-slash-separated destinations, both confined to `resources/views/`. `--preset=login`, `register`, `forgot-password`, or `reset-password` creates one authentication page and resolves its component dependencies. `--auth-bundle` creates all four pages and their required missing components in one artifact collection.

## Flags commonly used by generators

- `--dry-run` previews the operation without writing the generated files.
- `--force` permits overwriting an existing destination, bypassing confirmation where the command supports it.
- `--no-interaction` disables prompts. Use it in automated scripts only when you understand how conflicts are handled.

Not every command supports every flag. The per-command help output is authoritative.

## Separate project installer

Creating a new application is handled by the standalone PixelFix Installer, not the application's console. The installer has its own executable and documentation. Once an application exists, use `php pixel` for the commands listed in this reference.
