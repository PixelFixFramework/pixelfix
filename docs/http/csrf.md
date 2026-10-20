# CSRF Protection

Cross-Site Request Forgery (CSRF) is an attack in which another site tricks a browser into submitting an unwanted request to an application where the user is already signed in. Browsers may send session cookies automatically, so PixelFix needs a token that proves a state-changing form was rendered in the application's session.

## Which requests need protection?

Protect browser requests that change state, such as creating a task, updating a profile, or deleting a record. GET requests should only read data; they should not perform destructive work. The predefined `web` middleware group includes session handling and CSRF protection.

## Include the token in a Twig form

PixelFix registers a Twig global named `csrf`. Render it inside each state-changing browser form:

```twig
<form method="post" action="{{ route('tasks.store') }}">
    {{ csrf|raw }}

    <label for="title">Task title</label>
    <input id="title" name="title" type="text" required>

    <button type="submit">Save task</button>
</form>
```

The `csrf` global renders a hidden `_token` input. The `|raw` filter is needed because the global returns HTML markup, not plain text. Only use `raw` for this framework-generated token field; do not use it on user-supplied text.

You can also write the field through PHP when generating form HTML outside Twig:

```php
echo csrf_field();
```

The global PHP helper `csrf_token()` returns the token string, while the Twig `csrf` global returns the complete hidden field. Do not try to call `csrf_token()` as a Twig function unless your application explicitly registers such a function.

## How verification works

The browser submits the hidden token with the form. CSRF middleware checks the submitted value against the token associated with the current session. A missing or invalid token causes the request to be rejected before the controller performs the state-changing operation.

The form must submit under the session context in which it was rendered. If your custom form component already includes `{{ csrf|raw }}`, do not add a second token field to the same form.

## Common problems

- **Missing-token or CSRF failure:** confirm the form uses the `web` group or the appropriate session/CSRF middleware and includes `{{ csrf|raw }}`.
- **Unknown Twig function `csrf`:** `csrf` is a Twig global variable, not a function. Use `{{ csrf|raw }}` rather than `{{ csrf() }}`.
- **Form inside a component:** a component does not bypass CSRF checks; the outer form still needs a token.
- **API request confusion:** a bearer-token API has a different security model from a browser session form. Configure its authentication deliberately rather than disabling CSRF protection for ordinary browser routes.
- **Trying to fix the problem by disabling CSRF:** keep the protection enabled and fix the form, route middleware, or session flow instead.

CSRF is not authentication and is not authorization. The token helps establish that a state-changing browser request came from the expected session; the application must still verify who the user is and whether they are allowed to perform the operation.
