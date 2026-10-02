# Base Header Component

Provides the base PixelFix header markup and three Twig blocks for custom header content.

**Component:** `layout/header.twig`

## Behavior and Notes

The component defines no configurable input parameters.

The `header_start` block is rendered on the left after the default sidebar-toggle item.

The `header_center` block is rendered in the center.

The `header_end` block is rendered on the right.

When using Twig `embed`, these blocks can be overridden by the embedding template.

## Usage

```twig
{% embed 'components/layout/header.twig' %}
    {% block header_start %}
        <li class="pixelfix-nav-item">
            Custom Start Item
        </li>
    {% endblock %}

    {% block header_center %}
        <span>Page Context</span>
    {% endblock %}

    {% block header_end %}
        <li class="pixelfix-nav-item">
            Custom End Item
        </li>
    {% endblock %}
{% endembed %}
```
