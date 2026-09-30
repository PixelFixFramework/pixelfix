# Test Runner

PixelFix's built-in test runner is launched through the project's `tests/run.php` entry point.

## Run the full suite

From the project root:

```bash
php tests/run.php
```

The framework's Composer script is equivalent to:

```bash
composer test
```

## Run a directory

Limit discovery to a directory with:

```bash
php tests/run.php --dir=tests/Unit
```

`--directory` is accepted as an alias.

## Filter tests

Use `--filter` to run tests whose fully qualified test name contains the filter string:

```bash
php tests/run.php --filter=Route
```

## Exclude directories

Multiple directory paths can be excluded as a comma-separated list:

```bash
php tests/run.php --exclude=Integration/Route,Integration/Database
```

The runner resolves excluded paths relative to the selected test directory.

## Discovery rules

The runner recursively loads PHP files under the selected directory, skipping the runner and bootstrap files. It then finds declared classes extending `TestCase` and executes every public/protected reflection method whose name starts with `test`.

Each test method receives a fresh instance. The runner captures test output so failures can display both assertion information and test output.

## Results

The runner reports each test as `[RUNNING]`, `[PASS]`, or `[FAIL]` and finishes with a summary containing total, passed, and failed counts. A failing suite exits with status code `1`; a successful suite exits with status code `0`.

## Example

```bash
php tests/run.php --dir=tests/Unit/Database --filter=Model
```

This pattern is useful while developing a subsystem without running the entire framework suite.
