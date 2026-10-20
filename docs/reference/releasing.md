# Release and Publishing Guide

This page is for maintainers preparing a PixelFix framework release. Application developers normally do not need these steps to build a feature.

## Package identity

The framework package is `pixelfix/framework`, defined in `composer.json`. The package targets PHP `^8.2` and declares its runtime dependencies there. Keep the package metadata, license, repository links, and version/tag aligned when preparing a release.

## Validate the source and examples

Before publishing, confirm the framework test runner succeeds in an environment with the required PHP extensions and database drivers. Run:

```powershell
composer validate
composer test
```

If the test run depends on SQLite, verify that the PHP process running the test suite has `pdo_sqlite` enabled. A driver-missing failure is an environment problem, not proof that the feature is correct or incorrect; rerun in the supported environment before releasing.

## Verify the public console

Use the generated application's launcher and check only commands supported by the current source:

```powershell
php pixel help
php pixel help make:model
php pixel help migrate
php pixel help route:list
```

Compare the output with the Command Reference and ensure documentation does not list hidden commands, removed commands, or signatures from an older version.

## Documentation checklist

- A beginner can follow the installation path without invoking an internal or hidden framework command.
- API examples explain what each important method returns and what it does.
- Destructive database operations include warnings.
- File paths and namespaces match the source tree.
- Code examples use the current request, model, response, and Twig APIs.
- Component documentation reflects the bundled templates and their real dependencies.
- Links work after application stubs have been copied into the generated documentation tree.

## Publish the package

Publishing follows the repository's configured Composer/Packagist process. Verify `composer.json`, package version, tag, and release notes before publishing. Do not describe a different package name or claim a package is publicly available until the registry and repository reflect that release.
