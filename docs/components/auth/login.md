# Login Component

Renders the PixelFix login form, including the optional logo, authentication form, optional social-login links, password-reset link, and registration link.

**Component:** `auth/login.twig`

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `logo_url` | `#` | URL used by the optional logo link. |
| `logo_bold` | `''` | Optional bold portion of the logo text. |
| `logo_text` | `''` | Optional regular logo text. |
| `show_logo` | `false` | When `true`, renders the `login-logo` section. |
| `message` | `Sign in to start your session` | Message displayed above the form. |
| `action` | `#` | Form action URL. |
| `method` | `post` | Form method. |
| `csrf` | `''` | Raw CSRF markup inserted into the form. |
| `email_name` | `email` | Name/id of the email input. |
| `email_label` | `Email` | Label variable defined by the component. |
| `email_placeholder` | `Email` | Email placeholder. |
| `email_value` | `''` | Initial email value. |
| `autofocus` | `false` | Enables autofocus on the email field. |
| `password_name` | `password` | Name/id of the password input. |
| `password_label` | `Password` | Label variable defined by the component. |
| `password_placeholder` | `Password` | Password placeholder. |
| `remember_name` | `remember` | Name/id of the remember-me checkbox. |
| `remember_value` | `1` | Value of the remember-me checkbox. |
| `remember_text` | `Remember Me` | Visible remember-me label text. |
| `remember_checked` | `false` | Initial checked state. |
| `submit_text` | `Sign In` | Submit button text. |
| `show_social` | `false` | When `true`, renders the social-login block. |
| `facebook_url` | `#` | Facebook login link URL. |
| `facebook_text` | `Sign in using Facebook` | Facebook login link text. |
| `google_url` | `#` | Google login link URL. |
| `google_text` | `Sign in using Google` | Google login link text. |
| `forgot_password_url` | `#` | Password-reset link URL. |
| `forgot_password_text` | `I forgot my password` | Password-reset link text. |
| `register_url` | `#` | Registration link URL. |
| `register_text` | `Create a new account` | Registration link text. |

## Behavior and Notes

The logo is disabled by default with `show_logo=false`.

Social authentication is disabled by default with `show_social=false`; both Facebook and Google links are rendered when the block is enabled.

The current login template defines `email_label` and `password_label`, but passes an empty `label` to the nested `input-group` components. Therefore these two parameters do not currently change the rendered labels.

The email and password fields use the `components/form/input-group.twig` component. Password values are not repopulated by the nested component.

The `csrf` value is rendered with `|raw` and is intended for already-generated CSRF markup.

## Usage

```twig
{% include 'components/auth/login.twig' with {
    show_logo: false,
    show_social: true,
    message: 'Sign in to manage your tasks.',
    action: route('auth.attempt'),
    method: 'POST',
    csrf: csrf,
    email_name: 'email',
    email_placeholder: 'Email or username',
    password_name: 'password',
    password_placeholder: 'Password',
    remember_name: 'remember',
    remember_value: '1',
    forgot_password_url: '#',
    register_url: route('auth.register'),
    register_text: 'Create a new account'
} %}
```
