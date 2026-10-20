# Scheduling

PixelFix provides a generic in-process scheduler resolved by `schedule()`. Applications register their own scheduled operations; the framework does not decide which business action an application should run.

## Register operations in an application provider

Register tasks from an application service provider's `boot()` method:

```php
schedule()
    ->call(static function (): void {
        // Run one application-owned operation.
    })
    ->daily()
    ->description('Daily application maintenance')
    ->withoutOverlapping(3600);
```

`Scheduler` provides `call(Closure)`, `command(string)`, `tasks`, `dueTasks`, `run`, `lastRunResults`, `lastRunFailures`, `timezone`, and `now`. A `ScheduledTask` can use `everyMinute`, `everyFiveMinutes`, `hourly`, `daily`, `weekly`, `monthly`, or `cron($expression)`, plus `description()` and `withoutOverlapping($seconds)`. Use cron expressions for schedules not covered by the convenience methods.

## Run due tasks

```powershell
php pixel schedule:run
php pixel schedule:work
php pixel dev
```

`schedule:run` checks and runs due work once. `schedule:work` is a long-running loop that checks on a regular interval; a supervised long-running process can keep it alive. The development runtime manages the scheduler when at least one task is registered, and the managed child does not repeat the parent runtime's shutdown instruction. For production, use the operating system's scheduler to invoke `schedule:run` on the desired cadence, typically every minute, or supervise a supported long-running worker.

## Timezone and overlap prevention

The starter configuration uses `scheduling.timezone`, configured via `SCHEDULER_TIMEZONE`. Use an IANA timezone such as `Africa/Lusaka`; task times are interpreted in the scheduler timezone. `withoutOverlapping(seconds)` protects a task from overlapping with another run using the scheduler's lock mechanism; choose a duration that safely covers the expected task runtime.

A provider should register generic scheduling behavior. Application settings for a particular operation—such as whether a reminder is enabled or which hours it may run—belong to that application's configuration and should not become hard-coded framework-wide schedule defaults.
