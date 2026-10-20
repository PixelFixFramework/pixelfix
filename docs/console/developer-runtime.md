# Developer runtime

Start the local application with one command:

```powershell
php pixelfix dev
```

PixelFix coordinates the web server, scheduler, and (when the queue driver is `database` or `redis`) queue worker in one terminal. Output is labelled by process. Use `Ctrl+C` to stop the processes started by this command.

```powershell
php pixelfix dev --open
php pixelfix dev --queues=default,notifications
php pixelfix dev --no-worker
php pixelfix dev --no-scheduler
```

If the application sends jobs to named queues, list them using `PIXELFIX_WORKER_QUEUES` in `.env` or `--queues` on the command line. The default queue is `default`.

Run framework-wide checks without assuming application-specific models:

```powershell
php pixelfix subsystems:verify --check-only
php pixelfix subsystems:verify
```

For a standalone scheduler process, run `php pixelfix schedule:work`. For background Windows services, see `scripts/PixelFixServices.ps1` and the generated developer-runtime documentation.
