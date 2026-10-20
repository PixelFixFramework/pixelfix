# Registration Component

The Page 10 registration component renders a branded registration form, optional login/register pill tabs, username, email and password fields, optional password confirmation, an optional terms checkbox, submit button, and optional login footer. It composes shared form input, checkbox, button, and navigation components where supported by the template.

## Minimal use

```twig
{% include 'components/auth/register.twig' with {
    action_route: 'auth.store',
    login_url: route('auth.login'),
    register_url: route('auth.register'),
} only %}
```

Supply named route destinations from the calling view. When neither `action_route` nor `action` is supplied, the form action is empty. Login and registration URLs default to `#`. If `action_route` is supplied, the route name must exist at render time.

## Defaults and options

| Option | Default | Purpose |
|---|---|---|
| `brand` | `config('app.name')` or `Your application` | Accessible brand text |
| `csrf` | empty string | Raw CSRF markup inserted into the form |
| `logo_text` | brand | Text beside the logo |
| `logo_url` | empty | Optional linked-logo destination |
| `logo_image_url` | `asset('images/pixelfix-logo.svg')` | Logo image URL |
| `logo_alt` | brand | Image alternative text |
| `tagline` | `A fresh start begins here.` | Header tagline |
| `title` | `Create your account` | Form heading |
| `message` | empty | Optional explanatory text beneath the heading |
| `action_route` / `action_route_parameters` | not set / `[]` | Named form action and route parameters |
| `action` | empty | Explicit form target if no route is supplied |
| `method` | `post` | Form submission method |
| `show_labels` | `false` | Visible field labels or visually-hidden labels |
| `show_brand` | `true` | Show the branded header |
| `show_tabs` | `true` | Show the login/register pill tabs |
| `login_url` / `register_url` | `#` / `#` | Destinations for the two pills |
| `login_tab_text` / `register_tab_text` | `Login` / `Create account` | Pill labels |
| `show_login_link` | `true` | Show the login footer if its URL is truthy |
| `login_prompt` / `login_text` | `Already have an account?` / `Login` | Footer copy |
| `show_confirm_password` | `false` | Show or hide password confirmation |
| `submit_text` | `Create account` | Submit button label |

Field options include `name_name`, `name_id`, `name_label`, `name_placeholder`, `name_value`; `email_name`, `email_id`, `email_label`, `email_placeholder`, `email_value`; `password_name`, `password_id`, `password_label`, `password_placeholder`; and `confirm_password_name`, `confirm_password_id`, `confirm_password_label`, `confirm_password_placeholder`. The defaults are username (`name`, `register-name`, `Username`, `Username`), email (`email`, `register-email`, `Email address`, `Email address`), password (`password`, `register-password`, `Password`, `Create Password`), and confirmation (`password_confirmation`, `register-password-confirmation`, `Confirm password`, `Confirm password`). The username input receives autofocus by default through `autofocus|default(true)`.

## Optional password confirmation

Confirmation is hidden by default. Enable it explicitly when the application's form and server-side validation expect `password_confirmation`:

```twig
{% include 'components/auth/register.twig' with {
    action_route: 'auth.store',
    show_confirm_password: true,
    login_url: route('auth.login'),
    register_url: route('auth.register'),
} only %}
```

If the confirmation field is displayed, it is rendered as required. The server must validate the password confirmation independently.

## Optional terms acceptance

`show_terms` and `terms_required` both default to `false`. The terms checkbox renders when `show_terms` or `terms_url` is truthy. Options include `terms_name` (`terms`), `terms_value` (`1`), `terms_text` (`Terms and Privacy Policy`), `terms_prefix` (`I agree to the `), `terms_label`, `terms_url`, and `terms_link_text`. Supplying `terms_url` builds a linked label; use an actual application route/URL. The default checkbox is not required unless the caller sets `terms_required: true`.

## Layout and security

The component's pill tabs and active states remain part of the component. Pass destinations/copy through `with { ... }` rather than rebuilding the tab markup in each view. The CSRF field must be supplied using the application's normal CSRF rendering contract. Client-side `required` attributes do not replace server validation, unique-identity checks, password policy, or authorization decisions.
