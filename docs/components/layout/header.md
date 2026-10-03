# Header

Provides the base application header structure with start and end Twig blocks.

**Component:** `components/layout/header.twig`

---

## Parameters

This component does not define explicit parameters.

The component is intended to be extended through Twig `embed` and its
`header_start` and `header_end` blocks.

---

# Usage

```twig
{% embed 'components/layout/header.twig' %}

    {% block header_start %}

        {% include
            'components/layout/header/live-preview.twig'
        %}

    {% endblock %}

    {% block header_end %}

        {% include
            'components/layout/header/search.twig'
        %}

    {% endblock %}

{% endembed %}
```

---

## Header Blocks

| Block | Purpose |
|---|---|
| `header_start` | Content rendered at the start of the navigation. |
| `header_end` | Content rendered at the end of the navigation. |
