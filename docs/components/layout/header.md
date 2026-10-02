# Base Application Header

> **Component:** `components/layout/header.twig`

## Purpose

Provides the reusable PixelFix application header shell. It contains the sidebar toggle and exposes three Twig blocks for custom header content.

## API / Properties

`header.twig` does not declare ordinary component properties. Its extension points are Twig blocks:

- `header_start` — injected into the left/start navigation area.
- `header_center` — injected into the central header area.
- `header_end` — injected into the right/end navigation area.

## Behavior

The base header always includes the sidebar toggle link. The rest of the header is supplied through Twig blocks.

## Example

```twig
{% embed 'components/layout/header.twig' %}
    {% block header_start %}
        <li class="pixelfix-nav-item">
            <a class="pixelfix-nav-link" href="/preview">
                Preview
            </a>
        </li>
    {% endblock %}

    {% block header_end %}
        <li class="pixelfix-nav-item">
            <a class="pixelfix-nav-link" href="/help">
                Help
            </a>
        </li>
    {% endblock %}
{% endembed %}
```

## Usage

Use `embed` when you need custom header composition. The predefined `default-header.twig` demonstrates how the framework fills the blocks.

## Notes

The only built-in control in this base component is the sidebar toggle. It uses `data-pixelfix-toggle="sidebar"`.

## Related Components

- `components/layout/default-header.twig`
