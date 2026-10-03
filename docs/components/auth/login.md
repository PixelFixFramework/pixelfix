# Login

Renders the application login form with configurable credentials, remember-me, social authentication, and account links.

**Component:** `components/auth/login.twig`

---

## Parameters

| Parameter | Default | Description |
|---|---|---|
| `logo_url` | `#` | URL used by the authentication logo. |
| `logo_bold` | `''` | Bold portion of the logo text. |
| `logo_text` | `''` | Logo text displayed beside the bold portion. |
| `show_logo` | `false` | Determines whether the logo is rendered. |
| `message` | `Sign in to start your session` | Message displayed above the login form. |
| `action` | `#` | Form submission URL. |
| `method` | `post` | Form submission method. |
| `csrf` | `''` | Raw CSRF markup rendered inside the form. |
| `email_name` | `email` | Name attribute for the email field. |
| `email_label` | `Email` | Email field label. |
| `email_placeholder` | `Email` | Email field placeholder. |
| `email_value` | `''` | Initial email field value. |
| `autofocus` | `false` | Determines whether the email field receives autofocus. |
| `password_name` | `password` | Name attribute for the password field. |
| `password_label` | `Password` | Password field label. |
| `password_placeholder` | `Password` | Password field placeholder. |
| `remember_name` | `remember` | Name attribute for the remember-me checkbox. |
| `remember_value` | `1` | Value submitted by the remember-me checkbox. |
| `remember_text` | `Remember Me` | Remember-me checkbox label. |
| `remember_checked` | `false` | Determines whether the remember-me checkbox is checked. |
| `submit_text` | `Sign In` | Login submit button text. |
| `show_social` | `false` | Determines whether social authentication buttons are rendered. |
| `facebook_url` | `#` | Facebook authentication URL. |
| `facebook_text` | `Sign in using Facebook` | Facebook authentication button text. |
| `google_url` | `#` | Google authentication URL. |
| `google_text` | `Sign in using Google` | Google authentication button text. |
| `forgot_password_url` | `#` | Forgot-password URL. |
| `forgot_password_text` | `I forgot my password` | Forgot-password link text. |
| `register_url` | `#` | Registration URL. |
| `register_text` | `Create a new account` | Registration link text. |

---

# Usage

The Login component is included using Twig's `include` statement.

Example:

```twig
{% include
    'components/auth/login.twig'
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
            'Sign in to your account'

        action:
            route('login')

        method:
            'post'

        csrf:
            csrf()

        email_name:
            'email'

        password_name:
            'password'

        remember_name:
            'remember'

        submit_text:
            'Sign In'
    }
    only
%}
```

---

## Social Authentication

Set `show_social` to `true` to render the Facebook and Google authentication links.

```twig
{% include
    'components/auth/login.twig'
    with {
        show_social:
            true

        facebook_url:
            '/auth/facebook'

        facebook_text:
            'Sign in using Facebook'

        google_url:
            '/auth/google'

        google_text:
            'Sign in using Google'
    }
    only
%}
```

---

## Complete Example

```twig
{% include
    'components/auth/login.twig'
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
            'Sign in to your account'

        action:
            route('login')

        method:
            'post'

        csrf:
            csrf()

        email_name:
            'email'

        email_label:
            'Email'

        email_placeholder:
            'Email address'

        email_value:
            ''

        autofocus:
            true

        password_name:
            'password'

        password_label:
            'Password'

        password_placeholder:
            'Password'

        remember_name:
            'remember'

        remember_value:
            '1'

        remember_text:
            'Remember Me'

        remember_checked:
            false

        submit_text:
            'Sign In'

        show_social:
            false

        forgot_password_url:
            route('password.request')

        register_url:
            route('register')
    }
    only
%}
```
