# Password-Recovery Request Component

`components/auth/forgot-password.twig` renders the Page 10 email form used to request a password-reset link. It intentionally has no account-access pill tabs. The calling view owns the route configuration.

## Usage

```twig
{% include 'components/auth/forgot-password.twig' with {
    action_route: 'password.email',
    return_to_login_url: route('auth.login'),
} only %}
```

The component does not resolve a default named route when no target is passed. Without `action` or `action_route`, its form action is empty; the return-to-login URL defaults to `#`. If `action_route` is supplied, the route must be registered at render time.

## Options

`brand` defaults to `config('app.name')` or `Your application`; `csrf` defaults to an empty string; `logo_text` defaults to the brand; `logo_url` is empty; `logo_image_url` defaults to `asset('images/pixelfix-logo.svg')`; `tagline` defaults to `Password recovery begins here.`; and `title` defaults to `Recover your password`.

Route/form options are `action_route`, `action_route_parameters` (default `[]`), `action` (default empty), and `method` (default `post`). Email options are `email_name` (`email`), `email_id` (`forgot-password-email`), `email_label` (`Email address`), `email_placeholder` (`Email address`), `email_value` (empty), `email_autofocus` (`true`), and `email_maxlength` (`255`). The email is required.

The return footer is controlled by `show_return_to_login` (default `true`), `return_to_login_url` (default `#`), `return_to_login_text` (`Return to login`), and `return_to_login_prompt` (`Remembered password?`). An optional `footer_partial` can replace the default footer; values are passed through `footer_partial_context`.

## Security

Password-reset tokens and delivery are handled by the application controller and framework reset/mail systems, not by the view component. Throttle reset requests and avoid exposing whether an email address has an account. See [Password Reset](../../authentication/password-reset.md) and [Mail](../../mail/overview.md).
