# Modal

> **Component:** `components/layout/modal.twig`

## Purpose

Renders a Bootstrap modal dialog with title, raw body content, optional footer, size presets, scrollable/centered behavior and static-backdrop behavior.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``id`` | Required | `—` | Modal id and base for the label id. |
| ``title`` | Optional | `Modal` | Modal title. |
| ``content`` | Optional | `''` | Modal body HTML; rendered raw. |
| ``footer`` | Optional | `null` | Modal footer HTML; rendered raw. |
| ``size`` | Optional | `null` | `sm`, `lg`, `xl`, or Bootstrap fullscreen variants. |
| ``scrollable`` | Optional | `false` | Adds `modal-dialog-scrollable`. |
| ``centered`` | Optional | `false` | Adds `modal-dialog-centered`. |
| ``static`` | Optional | `false` | Uses a static backdrop and disables keyboard dismissal. |


## Behavior

Supported size values are `sm`, `lg`, `xl`, `fullscreen`, `fullscreen-sm-down`, `fullscreen-md-down`, `fullscreen-lg-down`, `fullscreen-xl-down` and `fullscreen-xxl-down`. Invalid values fall back to no size class.

## Example

```twig
{% include 'components/layout/modal.twig' with {
    id: 'deleteModal',
    title: 'Confirm deletion',
    content: '<p>Delete this record?</p>',
    footer: '<button class="btn btn-danger">Delete</button>',
    centered: true
} %}
```

## Usage

Place the modal markup in the page and trigger it with Bootstrap's modal API or `data-bs-*` attributes.

## Notes

`content` and `footer` are raw. Supply trusted HTML.

## Related Components

- `components/form/button.twig`
- `components/layout/card.twig`
