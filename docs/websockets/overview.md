# WebSockets

PixelFix includes a WebSocket server, channel authorization, connection/frame handling, presence support, and a Redis Pub/Sub broadcast relay. Browser WebSocket serving and broadcast relay are separate processes.

## Define channels

Resolve the server through `websockets()` and define public, private, or presence channels in application-owned provider/bootstrap code:

```php
websockets()->publicChannel('announcements');

websockets()->privateChannel('users.{userId}',
    static function ($connection, $auth, $channel, array $parameters): bool {
        // Replace this with your application's ownership/authorization check.
        return $auth !== null
            && isset($parameters['userId'])
            && applicationUserMayAccessChannel($auth, (string) $parameters['userId']);
    }
);
```

The server API includes `defineChannel`, `publicChannel`, `privateChannel`, `presenceChannel`, plus corresponding `*ChannelPattern` methods. Patterns may use placeholders such as `{userId}`. The authorization callback receives the WebSocket connection, the supplied authentication context, the matched channel, and the channel parameters, in that order. Private/presence channels require an authorization callback; check identity and ownership server-side. See [WebSocket Channel Authorization](../guides/websocket-channel-authorization.md).

Applications may provide a `WebSocketHandler` implementing `connected`, `disconnected`, and `received` lifecycle methods. The `make:websocket-handler` generator creates a handler scaffold and can register it through the application WebSocket service provider.

## Commands and development runtime

```powershell
php pixel websockets:serve
php pixel websockets:relay
php pixel dev
```

`websockets:serve` runs the WebSocket endpoint. `websockets:relay` listens for Redis broadcast messages and forwards them to the authenticated local WebSocket relay ingress. When `WEBSOCKETS_ENABLED=true`, `php pixel dev` manages both WebSocket and broadcast-relay processes along with the HTTP server and other enabled services. Keep the relay process running while browser broadcasting is enabled.

## Configuration and security

The starter config includes `websockets.enabled`, `host`, `port`, `allowed_origins`, frame/handshake size limits, and relay port/token/message limits. Environment values include `WEBSOCKETS_ENABLED`, `WEBSOCKETS_HOST`, `WEBSOCKETS_PORT`, `WEBSOCKETS_ALLOWED_ORIGINS`, `WEBSOCKETS_MAX_FRAME_SIZE`, `WEBSOCKETS_MAX_HANDSHAKE_SIZE`, `WEBSOCKETS_RELAY_PORT`, and `WEBSOCKETS_RELAY_MAX_BYTES`.

Restrict allowed origins for browser clients, keep the relay bound to loopback, and protect the relay token file. Do not expose the authenticated relay ingress to the public network. Public/private/presence channel declarations and payload filtering are application security responsibilities; hiding a link in the UI is not channel authorization.

## Relationship to broadcasting

`BroadcastManager` publishes broadcasts over the configured Redis broadcaster; the relay subscribes to `broadcast:*` and forwards messages to active WebSocket clients. Use [Broadcasting](../broadcasting/overview.md) for application payload APIs and [Redis](../redis/overview.md) for connection and Pub/Sub configuration.
