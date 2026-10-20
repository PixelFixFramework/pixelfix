# Notifications

The notification subsystem provides a notification manager, a `Notification` base class, the `Notifiable` trait, and mail, database, and broadcast channels. Resolve it with `notifications()`.

## Define and send a notification

A notification defines `via($notifiable): array` to select channel names. A minimal usage shape is:

```php
use PixelFix\Framework\Notifications\Notification;

final class TaskAssignedNotification extends Notification
{
    public function via(mixed $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(mixed $notifiable): array
    {
        return ['message' => 'A task was assigned to you.'];
    }
}

$user->notify(new TaskAssignedNotification());
```

The receiving model uses `PixelFix\Framework\Notifications\Notifiable`. The trait exposes `notify`, `notifyNow`, `routeNotificationFor`, `routeNotificationForMail`, and `routeNotificationForDatabase`. Mail routing reads the recipient's `email` value; database routing uses the authentication identifier or `id` as applicable.

The manager exposes `send`, `sendNow`, `channel`, `extend`, `forgetChannel`, `channels`, `runtimeMetadata`, and `reset`. Built-in channel names are `mail`, `database`, and `broadcast`.

## Channel payload contracts

- **Mail:** `toMail($notifiable)` returns a `Mailable`.
- **Database:** `toDatabase($notifiable)` or `toArray($notifiable)` returns an array. The configured notifications table stores the notification type, notifiable identity, JSON data, `read_at`, and timestamps. The default table is `notifications`; run the corresponding migration before using this channel.
- **Broadcast:** `toBroadcast($notifiable)` returns an array, and the notifiable exposes `broadcastChannels()` returning the channel destinations.

A channel must be selected by `via()`. Merely defining a `toDatabase()` or `toMail()` method does not send through that channel unless the channel name is returned.

## Queueing and delivery

Notifications are not all automatically queued. The base notification has queue-related settings such as queue name, delay, tries, timeout, backoff, middleware, and tags. `shouldQueue()` returns true when the notification implements the queue subsystem's `ShouldQueue` marker. Configure the queue and run a worker if queued delivery is required. See [Queues](../queue/overview.md).

## Configuration

The starter config includes a `notifications` group; `NOTIFICATIONS_CHANNELS` and `NOTIFICATIONS_TABLE` feed the starter config. Mail channel delivery additionally requires valid mail configuration. Broadcast delivery uses the broadcasting subsystem. Use the fake/inspection methods supplied by notification and channel classes to test delivery behavior without sending real email or broadcasts.
