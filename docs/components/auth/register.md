# Register Component

Renders the PixelFix registration form with optional logo, optional password confirmation, optional social registration links, terms acceptance, and a login link.

**Component:** `auth/register.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `logo_url` | `#` | URL used by the optional logo link. |
| `logo_bold` | `''` | Optional bold portion of the logo text. |
| `logo_text` | `''` | Optional regular logo text. |
| `show_logo` | `false` | When `true`, renders the `register-logo` section. |
| `message` | `Register a new membership` | Message displayed above the form. |
| `action` | `#` | Form action URL. |
| `method` | `post` | Form method. |
| `csrf` | `''` | Raw CSRF markup inserted into the form. |
| `name_name` | `name` | Name/id of the full-name input. |
| `name_label` | `Full Name` | Full-name field label. |
| `name_placeholder` | `Full Name` | Full-name placeholder. |
| `name_value` | `''` | Initial full-name value. |
| `email_name` | `email` | Name/id of the email input. |
| `email_label` | `Email` | Email field label. |
| `email_placeholder` | `Email` | Email placeholder. |
| `email_value` | `''` | Initial email value. |
| `password_name` | `password` | Name/id of the password input. |
| `password_label` | `Password` | Password field label. |
| `password_placeholder` | `Password` | Password placeholder. |
| `show_confirm_password` | `false` | When `true`, renders the confirm-password input. |
| `confirm_password_name` | `password_confirmation` | Name/id of the confirm-password input. |
| `confirm_password_label` | `Confirm Password` | Confirm-password field label. |
| `confirm_password_placeholder` | `Confirm Password` | Confirm-password placeholder. |
| `terms_name` | `terms` | Name/id of the terms checkbox. |
| `terms_value` | `1` | Value of the terms checkbox. |
| `terms_checked` | `false` | Initial checked state. |
| `terms_url` | `#` | URL used by the terms link. |
| `terms_text` | `terms` | Visible terms text and link text. |
| `submit_text` | `Register` | Submit button text. |
| `show_social` | `false` | When `true`, renders the social-registration block. |
| `facebook_url` | `#` | Facebook registration link URL. |
| `facebook_text` | `Sign up using Facebook` | Facebook registration link text. |
| `google_url` | `#` | Google registration link URL. |
| `google_text` | `Sign up using Google` | Google registration link text. |
| `login_url` | `#` | Login link URL. |
| `login_text` | `I already have an account` | Login link text. |

## Behavior and Notes

The logo is disabled by default with `show_logo=false`.

Confirm-password is disabled by default with `show_confirm_password=false`.

When confirmation is enabled, the field is rendered as a required password input using `components/form/input-group.twig`.

Social registration is disabled by default with `show_social=false`.

The terms component supplies both a normal `label` value and a raw `label_html` value containing the terms link.

The `csrf` value is rendered with `|raw`.

## Usage

```twig
{% include 'components/auth/register.twig' with {
    show_logo: false,
    show_confirm_password: true,
    show_social: false,
    action: route('auth.register'),
    method: 'POST',
    csrf: csrf
} %}
```
