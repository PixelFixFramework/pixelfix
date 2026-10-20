# Broadcasting

PixelFix broadcasting sends application events and payloads to named channels. Resolve `PixelFix\Framework\Broadcasting\BroadcastManager` through `broadcast()` without arguments or `broadcast_manager()`.

## Broadcast a payload

```php
broadcast()->broadcast(
    ['reports'],
    'report.completed',
    ['reportId' => $reportId],
);
```

The API requires at least one channel and a non-empty event name. Channels may be `Channel` instances or channel-name strings. Duplicate destinations are normalized. `BroadcastManager::event()` accepts an event implementing `ShouldBroadcast`, whose contract supplies `broadcastOn(): array`, `broadcastPayload(): array`, and `broadcastAs(): ?string`. If no non-empty alias is supplied, the event class name is used.

Available channel value types include `Channel`, `PrivateChannel`, and `PresenceChannel`. Use the appropriate access model in the WebSocket channel authorization layer; a channel name alone does not grant access.

## Driver and configuration

The starter config has `broadcasting.default` and Redis broadcast prefix settings, including the `BROADCAST_DRIVER` and `BROADCAST_REDIS_PREFIX` environment values. In the current application scaffold, broadcasting uses the Redis-backed broadcaster. Ensure Redis and the PHP Redis extension are available. `broadcast()` performs the broadcast immediately; it does not automatically enqueue the event. Use a queue explicitly when the application needs asynchronous preparation or delivery.

## Testing

`BroadcastManager` provides `fake()`, `restoreFake()`, `fakeInstance()`, `runtimeMetadata()`, and `reset()`. Use the fake in tests to inspect recorded broadcasts. See [Redis](../redis/overview.md) and [WebSockets](../websockets/overview.md) for the transport and browser connection path.
