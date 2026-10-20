# Spinner

Renders an accessible Bootstrap loading spinner. PixelFix provides a complete default spinner, with options for border or grow animation, contextual color, small sizing, visible loading text, centering, and a custom accessible-label partial.

**Component:** `components/feedback/spinner.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `variant` | `border` | Animation style: `border` or `grow`. Invalid values fall back to `border`. |
| `type` | `primary` | Bootstrap text color. Supported values include `primary`, `secondary`, `success`, `danger`, `warning`, `info`, `light`, `dark`, `body`, `muted`, `white`, `black-50` and `white-50`. |
| `size` | `''` | Use `sm` for Bootstrap's small spinner. Other values use the default size. |
| `label` | `Loading...` | Accessible loading description. Also supplies visible text when `show_label` is enabled. |
| `show_label` | `false` | Displays the label beside the spinner as well as providing accessible status text. |
| `class` | `''` | Additional classes on the spinner element. |
| `id` | `''` | Optional HTML ID for the spinner element. |
| `centered` | `false` | Wraps the spinner in a flex container and centers it horizontally. |
| `wrapper_class` | `''` | Additional classes on the optional flex wrapper. Supplying this option enables the wrapper. |
| `label_partial` | `''` | Optional Twig partial rendered inside the visually hidden accessible label. It receives `label`. |

The component uses `role="status"` and includes a visually hidden label by default. Text values are escaped by Twig. A label partial should emit trusted application-authored markup or text.

---

## Basic Usage

The default provides an accessible primary border spinner without requiring any parameters:

```twig
{% include
    'components/feedback/spinner.twig'
%}
```

## Customize the Spinner

```twig
{% include
    'components/feedback/spinner.twig'
    with {
        type:
            'success',

        size:
            'sm',

        label:
            'Saving changes...',

        show_label:
            true,
    }
    only
%}
```

## Grow Spinner

```twig
{% include
    'components/feedback/spinner.twig'
    with {
        variant:
            'grow',

        type:
            'primary',

        label:
            'Loading students...',
    }
    only
%}
```

## Center the Spinner

```twig
{% include
    'components/feedback/spinner.twig'
    with {
        centered:
            true,

        wrapper_class:
            'py-4',

        label:
            'Loading dashboard...',
    }
    only
%}
```

## Use a Label Partial

The optional partial lets an application provide a composed or localized accessible description. It renders inside the component's `visually-hidden` label.

```twig
{% include
    'components/feedback/spinner.twig'
    with {
        label:
            'Loading student records...',

        label_partial:
            'students/partials/loading-label.twig',
    }
    only
%}
```

Example `students/partials/loading-label.twig`:

```twig
{{ label }}
```

Every hash entry in these examples, including the final entry, ends with a comma so new options can be added without modifying the previous line.

---

## Bootstrap Requirements

Load Bootstrap CSS in the page layout for spinner styling. The spinner itself does not require Bootstrap JavaScript.
