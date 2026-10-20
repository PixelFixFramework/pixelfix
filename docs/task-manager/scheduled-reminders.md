# Task Manager Scheduled Reminders

This page records the Task Manager example configuration that was previously documented in the application README. It is an application-specific example; the scheduler API itself is generic.

## Named schedule configuration

The application registers its reminder callback with PixelFix's generic Scheduler. The callback is application-specific; its schedule configuration uses a generic named-schedule convention and is not a framework-wide Task Manager setting.

Set `SCHEDULER_TIMEZONE` to the IANA timezone used by scheduled operations (for Zambia, `Africa/Lusaka`). The schedule named `reminders` supports these settings:

- `SCHEDULE_REMINDERS_FREQUENCY=daily`: run once per day at `SCHEDULE_REMINDERS_START_HOUR` (default `8`, meaning 08:00 in `SCHEDULER_TIMEZONE`).
- `SCHEDULE_REMINDERS_FREQUENCY=hourly`: run every hour from `SCHEDULE_REMINDERS_START_HOUR` through `SCHEDULE_REMINDERS_END_HOUR` (defaults 08:00 through 23:00).
- `SCHEDULE_REMINDERS_ENABLED=false`: do not register this schedule.

These settings belong to the application's schedule named `reminders`; other applications can register different callbacks and define their own named schedules and configuration. After changing these settings, restart `php pixelfix dev` so the schedule is registered with the new configuration. In this demo, hourly reminder mode checks for each incomplete task whose due date is today or earlier on every scheduled run.



For the generic scheduler API and commands, see [Scheduling](../scheduling/overview.md).
