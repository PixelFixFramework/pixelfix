# Card Component

Renders a card with optional title, subtitle, body content, and footer.

**Component:** `layout/card.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `title` | `null` | Optional card title. |
| `subtitle` | `null` | Optional card subtitle. |
| `content` | `''` | Card body content. Rendered as raw HTML. |
| `footer` | `null` | Optional footer content. Rendered as raw HTML. |
| `class` | `''` | Additional card classes. |

## Behavior and Notes

Both `content` and `footer` are rendered with `|raw`.

## Usage

```twig
{% include 'components/layout/card.twig' with {
    title: 'Task Summary',
    subtitle: 'Current status',
    content: '<p>All tasks are up to date.</p>',
    footer: '<a href="/tasks">View Tasks</a>'
} %}
```
