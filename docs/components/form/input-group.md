# Input Group Component

Renders a conventional form input with optional label, leading/trailing icon, validation feedback, and common HTML input attributes.

**Component:** `form/input-group.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `type` | `text` | HTML input type. |
| `name` | Required | Input name/id. |
| `label` | `''` | Input label. |
| `label_class` | `form-label` | CSS class for the label. |
| `placeholder` | `''` | Input placeholder. |
| `required` | `false` | Adds the HTML `required` attribute. |
| `icon` | `null` | Optional icon markup. Rendered as raw HTML. |
| `icon_position` | `start` | Use `start` or `end` to choose where the icon appears. |
| `value` | `''` | Initial value before `old()` resolution. |
| `class` | `''` | Additional input classes. |
| `maxlength` | `null` | Optional HTML `maxlength`. |
| `autofocus` | `false` | Adds the HTML `autofocus` attribute. |
| `disabled` | `false` | Adds the HTML `disabled` attribute. |
| `readonly` | `false` | Adds the HTML `readonly` attribute. |
| `validation_message` | `null` | Custom fallback validation message. |
| `autocomplete` | `null` | Autocomplete value. When omitted, common values are inferred for email, password, name/full_name, and username. |

## Behavior and Notes

The field value is resolved with `old(name, value)`.

Password inputs render an empty value attribute and are not repopulated.

The `icon` value is rendered with `|raw` and therefore should be trusted HTML when using markup such as `<i class="bi ..."></i>`.

The icon is only rendered when `icon` is supplied and `icon_position` is `start` or `end`.

The component calls `errors()` and uses the first field error in the invalid-feedback block.

## Usage

```twig
{% include 'components/form/input-group.twig' with {
    type: 'email',
    name: 'email',
    label: 'Email',
    placeholder: 'Enter your email',
    icon: '<i class="bi bi-envelope"></i>',
    icon_position: 'start',
    autocomplete: 'email',
    required: true
} %}
```
