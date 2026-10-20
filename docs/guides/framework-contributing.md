# Contributing to PixelFix Framework

This guide applies to contributors working on the framework source package. Framework API and user guides are maintained in the PixelFix starter application documentation so new application projects do not get a copied documentation tree.

Thank you for contributing to PixelFix Framework.

## Development requirements

- PHP 8.2+
- Composer

Install dependencies with:

```bash
composer install
```

Run the framework test runner with:

```bash
composer test
```

The framework's console lifecycle and generator lifecycle are part of the current architecture. New changes should preserve those contracts and update authoritative tests when behavior is intentionally changed.

## Framework tests and application artifacts

Framework tests may inspect framework-owned source files and application scaffolds under `src/Stubs/Application`. They must not create, overwrite, or depend on a top-level application tree (`app/`, `resources/`, or `public/`) inside the framework repository.

Tests that exercise generators by writing real application artifacts to those paths belong in the consuming application test suite. In this repository, Task Manager owns those application-root integration tests. Such tests must snapshot and restore any pre-existing application files they touch; test cleanup must never delete application-owned files that existed before the test ran.
