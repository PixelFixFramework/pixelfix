# Register

Renders the application registration form with configurable identity fields, password confirmation, terms acceptance, social authentication, and login links.

**Component:** `components/auth/register.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `logo_url` | `#` | URL used by the authentication logo. |
| `logo_bold` | `''` | Bold portion of the logo text. |
| `logo_text` | `''` | Logo text displayed beside the bold portion. |
| `show_logo` | `false` | Determines whether the logo is rendered. |
| `message` | `Register a new membership` | Message displayed above the registration form. |
| `action` | `#` | Form submission URL. |
| `method` | `post` | Form submission method. |
| `csrf` | `''` | Raw CSRF markup rendered inside the form. |
| `name_name` | `name` | Name attribute for the full-name field. |
| `name_label` | `Full Name` | Full-name field label. |
| `name_placeholder` | `Full Name` | Full-name field placeholder. |
| `name_value` | `''` | Initial full-name value. |
| `email_name` | `email` | Name attribute for the email field. |
| `email_label` | `Email` | Email field label. |
| `email_placeholder` | `Email` | Email field placeholder. |
| `email_value` | `''` | Initial email value. |
| `password_name` | `password` | Name attribute for the password field. |
| `password_label` | `Password` | Password field label. |
| `password_placeholder` | `Password` | Password field placeholder. |
| `show_confirm_password` | `false` | Determines whether the password confirmation field is rendered. |
| `confirm_password_name` | `password_confirmation` | Name attribute for the confirmation field. |
| `confirm_password_label` | `Confirm Password` | Confirmation field label. |
| `confirm_password_placeholder` | `Confirm Password` | Confirmation field placeholder. |
| `terms_name` | `terms` | Name attribute for the terms checkbox. |
| `terms_value` | `1` | Value submitted by the terms checkbox. |
| `terms_checked` | `false` | Determines whether the terms checkbox is checked. |
| `terms_url` | `#` | URL used by the terms link. |
| `terms_text` | `terms` | Text displayed for the terms link. |
| `submit_text` | `Register` | Registration submit button text. |
| `show_social` | `false` | Determines whether social registration buttons are rendered. |
| `facebook_url` | `#` | Facebook registration URL. |
| `facebook_text` | `Sign up using Facebook` | Facebook registration button text. |
| `google_url` | `#` | Google registration URL. |
| `google_text` | `Sign up using Google` | Google registration button text. |
| `login_url` | `#` | Login URL. |
| `login_text` | `I already have an account` | Login link text. |

---

# Usage

The Register component is included using Twig's `include` statement.

Example:

```twig
{% include
    'components/auth/register.twig'
    with {
        logo_url:
            route('home')

        logo_bold:
            'Pixel'

        logo_text:
            'Fix'

        show_logo:
            true

        message:
            'Create your account'

        action:
            route('register')

        method:
            'post'

        csrf:
            csrf()

        name_name:
            'name'

        email_name:
            'email'

        password_name:
            'password'

        show_confirm_password:
            true

        terms_url:
            '/terms'

        terms_text:
            'Terms and Conditions'

        submit_text:
            'Register'

        login_url:
            route('login')
    }
    only
%}
```

---

## Password Confirmation

Set `show_confirm_password` to `true` to render the confirmation field.

```twig
{% include
    'components/auth/register.twig'
    with {
        show_confirm_password:
            true

        confirm_password_name:
            'password_confirmation'

        confirm_password_label:
            'Confirm Password'

        confirm_password_placeholder:
            'Confirm Password'
    }
    only
%}
```

---

## Complete Example

```twig
{% include
    'components/auth/register.twig'
    with {
        logo_url:
            route('home')

        logo_bold:
            'Pixel'

        logo_text:
            'Fix'

        show_logo:
            true

        message:
            'Register a new membership'

        action:
            route('register')

        method:
            'post'

        csrf:
            csrf()

        name_value:
            ''

        email_value:
            ''

        show_confirm_password:
            true

        terms_url:
            route('terms')

        terms_text:
            'Terms and Conditions'

        show_social:
            false

        login_url:
            route('login')
    }
    only
%}
```
