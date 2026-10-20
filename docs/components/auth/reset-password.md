# Password-Reset Component

`components/auth/reset-password.twig` renders the Page 10 form used to submit a password-reset token, email address, and new password. Confirmation is optional and defaults off. Route names must be supplied by the calling view.

## Usage

```twig
{% include 'components/auth/reset-password.twig' with {
    action_route: 'password.update',
    token: token,
    email: email,
    email_readonly: true,
    show_confirm_password: true,
    resend_reset_url: route('password.request'),
} only %}
```

The component has no built-in named-route fallback: if `action` and `action_route` are absent, the form action is empty. The resend URL defaults to `#`. When `action_route` is supplied, that route must exist at render time.

## Options

Brand/header defaults are `brand` (application name or `Your application`), `csrf` (empty), `logo_text` (brand), `logo_url` (empty), `logo_image_url` (`asset('images/pixelfix-logo.svg')`), `tagline` (`Password reset begins here.`), `title` (`Reset your password`), `show_brand` (`true`), and `show_labels` (`false`).

Form defaults are `action_route`, `action_route_parameters` (`[]`), `action` (empty), `method` (`post`), and `token` (empty). Email options are `email_name` (`email`), `email_id` (`reset-email`), `email_label` (`Email address`), `email_placeholder` (`Email address`), `email_value` (defaults to the supplied `email` or empty), `email_maxlength` (`255`), and `email_readonly` (`true`). The email field is required.

Password options are `password_name` (`password`), `password_id` (`reset-password`), `password_label` (`New password`), `password_placeholder` (`Create new password`), and `autofocus` (`true`). `show_confirm_password` defaults to `false`; when enabled, the component renders a required confirmation field with `password_confirmation` name and `reset-password-confirmation` ID by default. The confirmation label and placeholder default to `Confirm password` and `Confirm new password`.

Footer options are `show_resend_reset_link` (`true`), `resend_reset_url` (`#`), `resend_reset_text` (`Resend password reset link`), and `resend_reset_prompt` (`Didn't receive the link?`). To replace the footer entirely, supply `footer_partial` and `footer_partial_context`.

## Security

Validate token existence/expiry/throttling and compare the submitted confirmation on the server when confirmation is enabled. Do not trust the hidden token or read-only email input as authority. See [Password Reset](../../authentication/password-reset.md), [Mail](../../mail/overview.md), and [Validation](../../validation/overview.md).
