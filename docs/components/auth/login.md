# Login Component

The Page 10 login component renders the login form, branded header, optional login/register pill tabs, remember-me checkbox, password visibility control, optional forgot-password link, submit button, and optional registration footer. It composes the shared `components/form/input-group.twig`, `components/form/checkbox.twig`, `components/form/button.twig`, and `components/navigation/link.twig` components.

## Minimal use

```twig
{% include 'components/auth/login.twig' with {
    action_route: 'auth.attempt',
    login_url: route('auth.login'),
    register_url: route('auth.register'),
    show_forgot_password: true,
    forgot_password_url: route('password.request'),
} only %}
```

Supply route destinations from the calling view. The component does not try to resolve conventional route names by default; it uses an empty form action when `action` and `action_route` are not supplied, and link URLs default to `#`. If `action_route` is supplied, that named route must exist because the component resolves it through `route()`.

## Defaults and options

| Option | Default | Purpose |
|---|---|---|
| `brand` | `config('app.name')` or `Your application` | Accessible brand/name text |
| `csrf` | empty string | Raw CSRF markup to place inside the form |
| `logo_text` | brand | Text beside the logo |
| `logo_url` | empty | Optional logo destination; when present, the image is linked |
| `logo_image_url` | `asset('images/pixelfix-logo.svg')` | Logo image URL |
| `logo_alt` | brand | Image alternative text |
| `tagline` | `Secure access begins here.` | Header tagline |
| `title` | `Access your account` | Form heading |
| `message` | empty | Optional introductory message below the heading |
| `action_route` | not set | Named route resolved to the form action |
| `action_route_parameters` | `[]` | Parameters for `action_route` |
| `action` | empty | Explicit form action if no `action_route` is given |
| `method` | `post` | Form method |
| `show_labels` | `false` | Show visible labels instead of visually-hidden labels |
| `show_brand` | `true` | Show branded header |
| `show_tabs` | `true` | Show login/register pill tabs |
| `login_url` | `#` | Destination for the login pill |
| `register_url` | `#` | Destination for the registration pill/footer link |
| `login_tab_text` | `Login` | Login pill text |
| `register_tab_text` | `Create account` | Registration pill text |
| `show_remember` | `true` | Show remember-me checkbox |
| `remember_name` / `remember_label` / `remember_value` | `remember` / `Remember me` / `1` | Checkbox field contract |
| `remember_checked` | `false` | Initial checkbox state |
| `show_forgot_password` | `false` | Whether to show the forgot-password link |
| `forgot_password_url` | `#` | Destination for the forgot-password link |
| `forgot_password_text` | `Forgot password?` | Forgot-password link text |
| `submit_text` | `Login` | Submit button label |
| `show_register_link` | `true` | Show the registration footer when its URL is truthy |
| `register_prompt` / `register_text` | `New here?` / `Create an account` | Registration footer copy |
| `autofocus` | `true` through the email input include | Whether the email input receives autofocus |

The component also accepts the input-specific options `email_name`, `email_id`, `email_label`, `email_placeholder`, `email_value`, `password_name`, `password_id`, `password_label`, and `password_placeholder`. Defaults are `email`, `login-email`, `Email address`, `Email address`, empty value, `password`, `login-password`, `Password`, and `Password` respectively.

## Optional navigation

Forgot password is opt-in. Both `show_forgot_password: true` and a useful `forgot_password_url` should be supplied by the caller to render that link. Keep the login/register pill markup and active state owned by this component; the calling view configures destinations and text rather than recreating the pills.

## Form behavior and security

The email and password inputs are required. The password visibility buttons target their input IDs. The form includes the supplied `csrf` markup; pass the application's CSRF field if the view doesn't already supply it through the rendering context. Named routes should be supplied by the view and must be registered before it renders. Client-side required attributes improve form usability but do not replace server-side validation or authentication checks.
