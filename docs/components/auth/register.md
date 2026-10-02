# Authentication Register

> **Component:** `components/auth/register.twig`

## Purpose

Renders a reusable registration form with logo, introductory message, full name, email, password, password confirmation, terms acceptance, submit action, optional social sign-up links and a link back to login.

## API / Properties

| Property | Required | Default | Description |
|---|---|---|---|
| ``logo_url`` | Optional | `#` | Registration logo destination. |
| ``logo_bold`` | Optional | `''` | Logo text rendered in bold. |
| ``logo_text`` | Optional | `''` | Additional logo text. |
| ``message`` | Optional | `Register a new membership` | Registration message. |
| ``action`` | Optional | `#` | Form action URL. |
| ``method`` | Optional | `post` | HTTP method. |
| ``csrf`` | Optional | `''` | Raw CSRF markup. |
| ``name_name`` | Optional | `name` | Name input field name. |
| ``name_label`` | Optional | `Full Name` | Visible label value. |
| ``name_placeholder`` | Optional | `Full Name` | Placeholder. |
| ``name_value`` | Optional | `''` | Initial value. |
| ``email_name`` | Optional | `email` | Email field name. |
| ``email_label`` | Optional | `Email` | Email label. |
| ``email_placeholder`` | Optional | `Email` | Email placeholder. |
| ``email_value`` | Optional | `''` | Initial value. |
| ``password_name`` | Optional | `password` | Password field name. |
| ``password_label`` | Optional | `Password` | Password label. |
| ``password_placeholder`` | Optional | `Password` | Password placeholder. |
| ``confirm_password_name`` | Optional | `password_confirmation` | Confirmation field name. |
| ``confirm_password_label`` | Optional | `Confirm Password` | Confirmation label. |
| ``confirm_password_placeholder`` | Optional | `Confirm Password` | Confirmation placeholder. |
| ``terms_name`` | Optional | `terms` | Terms field name. |
| ``terms_value`` | Optional | `1` | Submitted terms value. |
| ``terms_checked`` | Optional | `false` | Initial checked state. |
| ``terms_url`` | Optional | `#` | Terms link URL. |
| ``terms_text`` | Optional | `terms` | Terms link text. |
| ``submit_text`` | Optional | `Register` | Submit button text. |
| ``facebook_url`` | Optional | `#` | Facebook sign-up URL. |
| ``facebook_text`` | Optional | `Sign up using Facebook` | Facebook text. |
| ``google_url`` | Optional | `#` | Google sign-up URL. |
| ``google_text`` | Optional | `Sign up using Google` | Google text. |
| ``login_url`` | Optional | `#` | Login URL. |
| ``login_text`` | Optional | `I already have an account` | Login link text. |


## Behavior

Full Name, Email, Password and Confirm Password are rendered through `input-group.twig`. The terms control is rendered through `checkbox.twig`, allowing the link markup to be supplied as `label_html`. CSRF is emitted raw.

## Example

```twig
{% include 'components/auth/register.twig' with {
    logo_bold: config('app.name'),
    action: route('auth.store'),
    method: 'post',
    csrf: csrf(),
    name_name: 'name',
    email_name: 'email',
    password_name: 'password',
    confirm_password_name: 'password_confirmation',
    terms_url: route('terms'),
    login_url: route('auth.login')
} %}
```

## Usage

Wrap the component in the page-level registration layout. Keep route decisions and navigation outside the component itself.

## Related Components

- `components/form/input-group.twig`
- `components/form/checkbox.twig`
- `components/form/button.twig`
