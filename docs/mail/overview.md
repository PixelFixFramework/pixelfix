# Mail

PixelFix provides `PixelFix\Framework\Mail\Mail` and `MailManager` for sending application email. Use `mailer()` to resolve the fluent mail helper.

## Create a mailable

A mailable extends `PixelFix\Framework\Mail\Mailable` and defines `subject(): string` and `view(): string`. It can also define `data(): array` and `headers(): array`.

```php
use PixelFix\Framework\Mail\Mailable;

final class WelcomeMailable extends Mailable
{
    public function subject(): string
    {
        return 'Welcome';
    }

    public function view(): string
    {
        return 'emails.welcome';
    }

    public function data(): array
    {
        return ['recipientName' => 'Alex'];
    }
}
```

Send it to a recipient:

```php
mailer()->to('alex@example.test')->send(new WelcomeMailable());
```

The view is rendered through Twig. Create the referenced template in the application's view tree. `send()` returns a boolean result; the fluent recipient is cleared after the send attempt.

## Configuration

The current manager supports the `smtp` driver. The starter configuration uses `mail.default` / `MAIL_MAILER`, and reads `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_ENCRYPTION`, `MAIL_TIMEOUT`, `MAIL_FROM_ADDRESS`, and `MAIL_FROM_NAME`. Encryption may be `tls`, `ssl`, or `none`. Configure the real SMTP host and credentials before expecting delivery; a placeholder or invalid hostname will fail to connect.

## Testing

```php
mailer()->fake();
mailer()->to('alex@example.test')->send(new WelcomeMailable());
mailer()->assertSent(WelcomeMailable::class);
mailer()->assertCount(1);
```

`Mail` also provides `assertNotSent`, `runtimeMetadata`, and `reset`. Use the fake in tests rather than sending real messages. Do not log SMTP credentials, password-reset tokens, or sensitive mailable data.

## Boundaries

Mail sending is synchronous through the configured SMTP transport; sending a mailable does not itself put it on a queue. For asynchronous delivery, dispatch a job or use a queued notification. See [Queues](../queue/overview.md) and [Notifications](../notifications/overview.md).
