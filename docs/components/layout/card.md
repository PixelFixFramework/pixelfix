# Card

> **Component:** `components/layout/card.twig`

## Purpose

Provides a simple Bootstrap card with optional title, subtitle, body content and footer.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``title`` | Optional | `null` | Card heading. |
| ``subtitle`` | Optional | `null` | Secondary heading. |
| ``content`` | Optional | `''` | Card body content; rendered raw. |
| ``footer`` | Optional | `null` | Footer content; rendered raw. |
| ``class`` | Optional | `''` | Additional card class. |


## Behavior

The component renders title/subtitle conditionally. `content` and `footer` use `|raw`, allowing callers to pass prepared HTML fragments.

## Example

```twig
{% include 'components/layout/card.twig' with {
    title: 'Task Summary',
    subtitle: 'Today',
    content: '<p>5 tasks remain.</p>',
    footer: '<a href="/tasks">View all tasks</a>'
} %}
```

## Usage

Use for reusable content panels. Prefer trusted/generated markup for raw `content` and `footer` inputs.

## Related Components

- `components/layout/modal.twig`
- `components/layout/main.twig`
