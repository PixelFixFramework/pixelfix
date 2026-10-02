# Main Content

> **Component:** `components/layout/main.twig`

## Purpose

Renders the main application content area, including an optional page title, breadcrumb trail and configurable content/container classes.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``class`` | Optional | `''` | Additional class on the `<main>` element. |
| ``id`` | Optional | `pixelfix-main` | Main element id. |
| ``title`` | Optional | `null` | Page title shown in the content header. |
| ``breadcrumbs`` | Optional | `[]` | Array of `{label, url}` items; last item is active. |
| ``content`` | Optional | `''` | Main page content; rendered raw. |
| ``container_class`` | Optional | `''` | Additional class on the inner content container. |
| ``content_class`` | Optional | `''` | Additional class on the `.pixelfix-main-content` wrapper. |


## Behavior

The header area is rendered when either `title` exists or `breadcrumbs` contains items. The last breadcrumb is rendered as plain text and marked `aria-current="page"`. Earlier breadcrumbs become links only when their `url` is present.

## Example

```twig
{% include 'components/layout/main.twig' with {
    title: 'Tasks',
    breadcrumbs: [
        {label: 'Dashboard', url: '/'},
        {label: 'Tasks'}
    ],
    content: '<p>Task list goes here.</p>'
} %}
```

## Usage

Use as the content shell inside the PixelFix dashboard layout. Supply prepared page content via `content` when using the component as a standalone include.

## Related Components

- `components/navigation/breadcrumb.twig`
- `components/layout/card.twig`
