# Feature Tests

Feature tests exercise externally observable application behavior across several framework layers. PixelFix's `tests/Feature` area contains examples of this style, including database assertions and seeder behavior.

A feature test should answer a question such as:

> Can this application workflow produce the expected result?

rather than focusing on the private methods used to implement it.

## Typical scope

For a web feature, the test may involve:

```text
route
  → middleware
  → controller
  → validation
  → authorization
  → model/database
  → response
```

Keep lower-level implementation checks in unit tests so feature tests remain focused on the behavior users depend on.

## Database-backed features

For database-backed application behavior, combine the base test case with `InteractsWithDatabase`. See [Database Testing](database-testing.md).
