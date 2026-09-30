# Troubleshooting

This page collects the most useful checks for a PixelFix application that is not behaving as expected.

## Confirm the application boots

From the application root, run:

```bash
php pixelfix help
```

A successful result confirms that Composer autoloading, application bootstrap, console registration, and the command kernel can initialize together.

## Confirm the routes

Use:

```bash
php pixelfix route:list
```

When route caching is involved, compare the live and cached route views when supported by the current command options:

```bash
php pixelfix route:list --live
php pixelfix route:list --cached
```

## Confirm the database state

Inspect migrations before changing the schema:

```bash
php pixelfix migrate:status
```

Apply pending migrations with:

```bash
php pixelfix migrate
```

Resetting or refreshing a development database can be destructive. Treat these commands as development-maintenance operations and verify the target database before running them.

## Confirm validation behavior

When a FormRequest rejects input, inspect three places:

```text
FormRequest::authorize()
FormRequest::rules()
Controller::validated()
```

The controller should consume validated data rather than bypassing the FormRequest with raw request input.

## Confirm authorization behavior

For a policy-based operation, verify:

```text
Model ↔ Policy registration
          ↓
Controller authorize(...)
          ↓
Policy method
```

For gate-based checks, verify that the gate is defined during provider boot before the application calls `Gate::authorize()` or the corresponding check.

## Confirm views

If a template fails to render, verify:

1. The template exists under `resources/views`.
2. The controller uses the correct view name.
3. Variables passed to `view()` match the names referenced by the Twig template.
4. The application view configuration points to the expected template location.

## Debugging principle

Start with the narrowest observable boundary:

```text
CLI boot
→ routes
→ middleware
→ controller
→ request validation
→ authorization
→ database
→ view
→ response
```

The Task Manager request trace follows this same sequence and is a useful worked example when debugging a real feature.
