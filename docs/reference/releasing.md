# Release and Publishing Guide

This guide describes the release-facing metadata that is present in the current PixelFix framework repository. It is intentionally limited to what the repository currently declares.

## Framework package

The framework identifies itself as:

```text
pixelfix/framework
```

The current `composer.json` declares:

```text
PHP: ^8.2
License: MIT
Type: library
```

Its runtime dependencies currently include FastRoute, Symfony VarDumper, Twig, and Dotenv. MongoDB support is an optional Composer suggestion rather than a mandatory dependency.

## Repository metadata

The current package metadata points its homepage, source, and issue tracker to the repository configured in `composer.json`. Keep those values synchronized with the repository used for the release.

Before publishing a release, verify at minimum:

1. `composer.json` package identity and metadata.
2. `composer.lock` is current when the project expects a committed lock file.
3. The framework test suite passes.
4. The CLI entry points still boot and list commands.
5. The public documentation matches the current source tree and command signatures.
6. The README installation instructions match the actual distribution workflow.

## Framework tests

The framework exposes its test suite through the Composer script:

```bash
composer test
```

The script runs the repository's custom test runner.

## Application generation

The framework currently contains an application generator and exposes it through:

```bash
php pixelfix new my-app
```

The generator creates the application from the framework's application stubs. It refuses reserved names and refuses to create an application inside the framework repository.

Application distribution can evolve independently from the framework package, so release documentation should describe the workflow supported by the current generator and repository rather than assuming a separate application package always exists.

## Documentation release checklist

Before tagging or publishing a framework release, run a documentation consistency pass:

```bash
php pixelfix help
php pixelfix help make:model
php pixelfix help migrate
php pixelfix help route:list
```

Then confirm that examples use the current launcher, current option names, and current class namespaces.

## Packagist and Composer distribution

Composer distribution depends on the package metadata and repository configuration. When the release process is connected to Packagist or another Composer registry, make sure the published package name remains `pixelfix/framework` unless the package metadata is intentionally changed in the same release.

Do not document a different Composer package name unless the repository's `composer.json` has been updated accordingly.
