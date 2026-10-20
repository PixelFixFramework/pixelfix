# Learn an Unfamiliar PixelFix Feature from Its Source and Tests

Even a comprehensive manual cannot replace checking the exact source version you have installed. This guide teaches a repeatable method for verifying framework behavior instead of guessing based on a familiar method name.

## 1. Start from a concrete question

Ask a question that can be answered precisely, for example:

- What does `Task::withTrashed()` return, and when does SQL execute?
- Does `response()->json()` set the content type and what is its default status?
- Does a route group apply middleware to nested routes?
- What happens if a model policy returns `false`?
- Does a generated policy deny by default?

“Understand authentication” is too broad for source inspection. Turn it into behaviors that can be confirmed one by one.

## 2. Find the public entry point

Begin with the class or helper a developer is expected to call. Follow it into the service that implements the work. For example, a JSON response can start at the global `response()` helper, move into the response factory, and end in the JSON response object and the HTTP response sending pipeline.

Read the method signature, its parameter types/defaults, the return type, exception paths, and collaborators. A method's name rarely tells the whole contract. Check whether a call returns a builder, a value, a model, a boolean, or a response.

## 3. Read both the successful path and failure path

For every method, ask:

- What inputs are accepted?
- What happens with `null`, empty input, or an invalid type?
- Does the method perform work immediately, or return a builder that executes later?
- Does it return a result, mutate state, or throw an exception?
- What global scope, middleware, callback, or configuration can affect it?
- Does it reveal sensitive data or bypass authorization if used carelessly?

For query builders, distinguish method chaining from execution. For example, `where()` modifies the query, while `get()` fetches records. For validation, `validate()` returns the accepted input or throws. For authorization, `allows()` returns a decision while `authorize()` raises an authorization failure when denied.

## 4. Find the closest test

PixelFix tests are grouped by areas such as `Unit`, `Integration`, `Runtime`, `Feature`, and `Foundation`. Search by class name, method name, or behavior. Read the test setup as well as the assertion: the setup tells you what dependencies must exist for the behavior to work.

The test runner can narrow a run using `--filter=` and `--dir=`:

```powershell
php tests/run.php --filter=JsonResponse
php tests/run.php --dir=tests/Integration/Auth
```

Use test names and directory paths present in your checkout. Test results are only meaningful when the required PHP extensions, database drivers, and configuration are available.

## 5. Create a minimal reproduction

Before building a whole application feature, create a small test or route that exercises one contract. For a query issue, seed two or three rows with different values and assert which ones are returned. For a gate, test an allowed user and a denied user. For a response, inspect the status and `Content-Type`, not only the PHP object before it is sent.

Avoid production data. For database behavior, use the test database facilities and reset state after the example. If a test depends on SQLite, verify that the PHP executable running the test has `pdo_sqlite` enabled.

## 6. Turn your finding into application documentation

Write down:

- the exact public call;
- imports and setup required;
- the file in which the code belongs;
- what the method returns and when it executes;
- an expected result;
- error cases and common misuse;
- security and performance implications;
- the test that verifies the behavior.

If the source and documentation disagree, verify the installed version first, then update the documentation or report a genuine implementation/documentation defect. Do not quietly “fix” an example by inventing a method the source does not provide.

## 7. Know when a feature is not implemented

A class name in a reservation list, a configuration key, a component named “Notifications,” or a model lifecycle hook does not establish that a complete feature exists. Check for a real public entry point, operational implementation, configuration, and tests. Use [Capability Matrix](../reference/capability-matrix.md) to distinguish supported framework capabilities from application-specific work and external integrations.

This habit matters most for security, queueing, events, caching, delivery systems, data integrity, and production operations. Make the boundary explicit in the design before depending on a capability.
