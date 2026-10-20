# PixelFix Framework Package

PixelFix is a PHP MVC framework for building web applications. This page describes the framework source package and its relationship to the PixelFix starter application. User-facing documentation is maintained centrally in the PixelFix starter application's `docs/` directory. The framework package does not ship or scaffold its own documentation tree.

## Package boundary

The framework package provides reusable runtime source, providers, console commands, application stubs, and framework component templates. It is not itself a complete application. The PixelFix starter application supplies the application entry point, routes, configuration, public assets, starter views, and centralized documentation. Use the PixelFix installer to create a complete new project; installing the framework package into an existing Composer project is not the same as scaffolding a new application.

## Framework API documentation

- [Architecture overview](../architecture/overview.md)
- [Application lifecycle](../architecture/application-lifecycle.md)
- [Service providers](../architecture/service-providers.md)
- [Console commands](../console/command-reference.md)
- [Generator architecture](../console/generator-architecture.md)
- [Configuration reference](configuration.md)
- [Environment reference](environment.md)
- [Helpers reference](helpers.md)
- [Capability matrix](capability-matrix.md)

## Development checks

In the framework source checkout, install Composer dependencies and run its configured test command. Package-maintenance scripts validate required source files and assembled package overlays; they are maintainer tooling, not application commands. For details on contribution practices see [Contributing to PixelFix Framework](../guides/framework-contributing.md).

## User-facing commands

Commands are run from an existing generated application root using the project's launcher (typically `php pixel` or `php pixelfix`, depending on the starter package version). Use the actual launcher shipped by that application and inspect `help` output for the installed version. The developer runtime can manage the HTTP server, scheduler, queue worker and WebSocket processes when the corresponding configuration and dependencies are enabled. See [the command reference](../console/command-reference.md) and [developer runtime](../console/developer-runtime.md).
