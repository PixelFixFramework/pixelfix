# Header Language Menu

> **Component:** `components/layout/header/language.twig`

## Purpose

Adds the built-in language selector menu with English, Español, Français, Deutsch and العربية entries.

## API / Properties

This component declares **no configurable properties**.

## Behavior

The current source renders a fixed language list and marks English as the active language. The link destinations are currently `#`.

## Example

```twig
{% include 'components/layout/header/language.twig' %}
```

## Usage

Use as part of the default header while the application provides its own language-switching behaviour. The current Twig does not accept a dynamic language collection.

## Notes

The current implementation is static. It is documentation of the present component, not a claim that language routing is already parameterized.

## Related Components

- `components/layout/default-header.twig`
- `components/layout/header.twig`
