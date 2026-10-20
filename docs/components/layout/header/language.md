# Language Header Item

Renders the language-selection dropdown in the PixelFix application header.

**Component:** `components/layout/header/language.twig`

---

## Parameters

| Parameter | Default | Purpose |
|---|---|---|
| `languages` | `[]` | List of language maps to display. Each map requires `code` and `label` (or the aliases `locale` and `name`). A non-current language needs a direct `url`/`href` or a named `route`. |
| `current_language` | `en` | Code of the currently selected language. |
| `current_language_label` | Inferred from the matching language, otherwise `English` for `en` or the language code | Human-readable name used in the trigger's accessible label. |
| `show` | `true` | Set to `false` to hide the component. Explicit `false` is respected. |
| `id` | `pixelfix-language-menu` | ID shared by the dropdown trigger and the menu's `aria-labelledby`. Customize it if more than one instance appears on the page. |
| `aria_label` | `Change language, current language …` | Optional accessible label for the trigger. |
| `title` | `Change language` | Trigger tooltip. |
| `icon` | `bi bi-translate` | Full CSS class string for the trigger icon. |
| `item_class` | Empty | Additional class for the navigation list item. |
| `control_class`, `link_class`, `class` | Empty | Additional class for the trigger button. `control_class` takes precedence, followed by `link_class` and `class`. |
| `menu_class` | Empty | Additional class for the dropdown menu. |
| `option_class` | Empty | Additional class for language options. |
| `active_class` | `active` | Class applied to the current-language option. |

---

## Usage

Provide the actual locale-switching URLs used by the application. The current language is rendered as the selected item and does not need a URL.

```twig
{% include
    'components/layout/header/language.twig'
    with {
        current_language:
            'en',

        languages: [
            {
                code: 'en',
                label: 'English',
            },
            {
                code: 'es',
                label: 'Español',
                url: '/language/es',
            },
            {
                code: 'fr',
                label: 'Français',
                url: '/language/fr',
            },
            {
                code: 'de',
                label: 'Deutsch',
                url: '/language/de',
            },
            {
                code: 'ar',
                label: 'العربية',
                url: '/language/ar',
            },
        ],
    }
    only
%}
```

### Named routes

Each language option can define a registered named route and its parameters. When `route` (or `route_name`) is supplied, the named route takes precedence over `url`/`href` for that option, matching the existing Documentation header component convention.

```twig
{% include
    'components/layout/header/language.twig'
    with {
        current_language:
            'en',

        languages: [
            {
                code: 'en',
                label: 'English',
            },
            {
                code: 'es',
                label: 'Español',
                route: 'language.switch',
                route_parameters: {
                    locale: 'es',
                },
            },
            {
                code: 'fr',
                label: 'Français',
                url: '/language/fr',
            },
        ],
    }
    only
%}
```

`route_parameters` is passed to PixelFix's `route()` helper. The compatibility aliases `route_name` and `parameters` are also accepted. Named routes must be registered in the application. The route/controller is responsible for changing and persisting the locale; this presentation component only generates the destination link.

The example paths are illustrative. Replace them with URLs or named routes that exist in the application. The application route or controller must perform the locale change; this presentation component does not change the locale itself.

### Customized trigger

```twig
{% include
    'components/layout/header/language.twig'
    with {
        current_language: 'fr',
        current_language_label: 'Français',
        aria_label: 'Change the application language',
        title: 'Select language',
        id: 'account-language-menu',
        icon: 'bi bi-globe2',
        item_class: 'custom-language-item',
        control_class: 'px-3',
        menu_class: 'shadow-sm',
        option_class: 'language-option',
        active_class: 'fw-bold',
    }
    only
%}
```

### Hide the component

```twig
{% include
    'components/layout/header/language.twig'
    with {
        show: false,
        languages: [],
    }
    only
%}
```

---

## Behaviour and accessibility

- Uses a semantic `button type="button"` for the dropdown trigger rather than an anchor with `href="#"`.
- Does not render until at least one language option is supplied, and respects `show: false`.
- Marks the current language with `aria-current="true"` and a check icon. The selected language is not a link.
- Renders non-current languages only when a direct URL or named route is configured; it never creates fallback `href="#"` links.
- Each language option accepts `url`/`href`, `route` and `route_parameters`. Named routes take precedence over direct URLs, following the existing Documentation header component convention. The aliases `route_name` and `parameters` are also accepted.
- Supports `code`/`locale`, `label`/`name` and `url`/`href` option keys.
- Sets `hreflang`, `lang` and `dir="auto"` on language links and sets `lang` on the current-language item.
- Associates the menu with the trigger through `aria-labelledby` and labels the trigger with the current language.
- Escapes displayed labels and attribute values.

Only use application-controlled or otherwise validated URLs. HTML escaping alone does not make an unsafe URL scheme such as `javascript:` safe.
