# Button Component

Renders either an anchor or a button element, with optional route resolution, icons, accessibility attributes, and raw content.

**Component:** `form/button.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `tag` | `button` | Use `a` to render an anchor; any other value renders a `<button>`. |
| `class` | `btn` | CSS classes applied to the element. |
| `type` | `button` | Button type when rendering a `<button>`. |
| `href` | `null` | Anchor href when `tag` is `a` and no route is supplied. |
| `route` | `null` | When supplied, resolves the href with the `route()` helper. |
| `route_parameters` | `[]` | Parameters passed to `route()`. |
| `id` | `null` | Optional element id. |
| `aria_label` | `null` | Optional `aria-label`. |
| `title` | `null` | Optional title attribute. |
| `target` | `null` | Optional anchor target; applied only when rendering an anchor. |
| `rel` | `null` | Optional anchor rel; applied only when rendering an anchor. |
| `icon` | `null` | Optional Bootstrap icon class name, inserted into `<i class="...">`. |
| `icon_class` | `me-1` | Additional class appended to the icon. |
| `content` | `''` | Button/anchor content. Rendered as raw HTML. |

## Behavior and Notes

When `route` is supplied, its resolved URL replaces the supplied `href`.

For `tag: 'a'`, the component does not render the `type` attribute.

For a normal `<button>`, `target` and `rel` are not rendered.

The `content` value is rendered with `|raw`.

The icon parameter should contain the icon class string, for example `bi bi-google`, not complete `<i>` markup.

## Usage

```twig
{% include 'components/form/button.twig' with {
    tag: 'a',
    route: 'tasks.index',
    route_parameters: [],
    class: 'btn btn-primary',
    icon: 'bi bi-list',
    content: 'View Tasks'
} %}
```
