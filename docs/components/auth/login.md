# Authentication Login

> **Component:** `components/auth/login.twig`

## Purpose

Renders the reusable PixelFix login interface. The component provides the logo area, sign-in message, email and password fields, remember-me option, submit button, optional social-auth links, password-recovery link and registration link.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``logo_url`` | Optional | `#` | Destination of the login logo. |
| ``logo_bold`` | Optional | `''` | Text rendered inside `<b>` in the logo. |
| ``logo_text`` | Optional | `''` | Additional logo text. |
| ``message`` | Optional | `Sign in to start your session` | Message displayed above the form. |
| ``action`` | Optional | `#` | Form action URL. |
| ``method`` | Optional | `post` | HTTP method used by the form. |
| ``csrf`` | Optional | `''` | Raw CSRF markup inserted inside the form. |
| ``email_name`` | Optional | `email` | Name used for the email input. |
| ``email_label`` | Optional | `Email` | Normalized label value passed into the input-group component. |
| ``email_placeholder`` | Optional | `Email` | Placeholder for the email field. |
| ``email_value`` | Optional | `''` | Initial email value. |
| ``autofocus`` | Optional | `false` | Whether the email input receives autofocus. |
| ``password_name`` | Optional | `password` | Name used for the password input. |
| ``password_label`` | Optional | `Password` | Password label value. |
| ``password_placeholder`` | Optional | `Password` | Password placeholder. |
| ``remember_name`` | Optional | `remember` | Remember-me field name. |
| ``remember_value`` | Optional | `1` | Remember-me submitted value. |
| ``remember_text`` | Optional | `Remember Me` | Text displayed beside the checkbox. |
| ``remember_checked`` | Optional | `false` | Initial checked state. |
| ``submit_text`` | Optional | `Sign In` | Text displayed on the submit button. |
| ``facebook_url`` | Optional | `#` | Facebook authentication URL. |
| ``facebook_text`` | Optional | `Sign in using Facebook` | Facebook button/link text. |
| ``google_url`` | Optional | `#` | Google authentication URL. |
| ``google_text`` | Optional | `Sign in using Google` | Google button/link text. |
| ``forgot_password_url`` | Optional | `#` | Password-reset destination. |
| ``forgot_password_text`` | Optional | `I forgot my password` | Forgot-password link text. |
| ``register_url`` | Optional | `#` | Registration destination. |
| ``register_text`` | Optional | `Create a new account` | Registration link text. |


## Behavior

The component delegates the email and password controls to `components/form/input-group.twig` and the remember-me control to `components/form/checkbox.twig`. The CSRF value is output as raw markup. The component itself contains the AdminLTE-style `.login-box` structure.

## Example

```twig
{% include 'components/auth/login.twig' with {
    logo_bold: config('app.name'),
    action: route('auth.attempt'),
    method: 'post',
    csrf: csrf(),
    email_name: 'email',
    password_name: 'password',
    remember_name: 'remember',
    register_url: route('auth.register')
} %}
```

## Usage

Place the component inside the page-level login wrapper. Keep page navigation/footer decisions outside this component so the login component remains reusable.

## Notes

The source defines label variables for email/password/remember but the current markup passes an empty visible label for the input-group email/password controls and uses the checkbox text for the remember control. The public API documents the inputs exactly as the component accepts them.

## Related Components

- `components/form/input-group.twig`
- `components/form/checkbox.twig`
- `components/form/button.twig`
