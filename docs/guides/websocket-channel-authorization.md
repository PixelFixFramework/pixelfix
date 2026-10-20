# WebSocket Channel Authorization

PixelFix WebSocket channels are **closed by default**. Register every channel that clients may subscribe to. An unregistered channel is treated as private and its subscription is denied because it has no authorization policy.

## Register a public channel

Register a channel as public only when every connected client is allowed to receive its events:

```php
$server->publicChannel('status.public');
```

For a family of deliberately public channels, use a pattern:

```php
$server->publicChannelPattern('public.status.{region}');
```

## Register a private channel

A private channel requires an authorization callback. Pattern placeholders match one channel segment and are provided in the callback's `$parameters` array:

```php
$server->privateChannelPattern(
    'users.{userId}.notifications',
    static function ($connection, $auth, $channel, array $parameters): bool {
        $user = $connection->user();

        return $user !== null
            && (string) $user->getAuthIdentifier() === $parameters['userId'];
    },
);
```

The application must authenticate the WebSocket connection and set the authenticated principal on the connection before authorizing private subscriptions. A channel name containing a user ID is not a security control by itself.

## Authenticate connections with the HTTP session

For browser applications that use PixelFix's session guard, inject `SessionWebSocketAuthenticator` into an application-specific `WebSocketHandler`. In the handler's `connected()` method, call `authenticate($connection)` and set the returned principal on the connection only when it is an `Authenticatable`. The authenticator reads the session cookie from the WebSocket handshake and treats missing or invalid sessions as unauthenticated.

Generate the application handler with `php pixel make:websocket-handler ApplicationWebSocketHandler`. The command creates the handler and automatically creates or updates `App\Providers\WebSocketServiceProvider` to bind the framework `WebSocketHandler` contract to that class. Use `--no-register` only when you intentionally want to manage the binding yourself. Handler class names belong to application code, not `.env` configuration. Keep application channel names and authorization rules in the application; framework code should not assume a specific user, task, order, or other domain model.

## Security checklist

- Register public channels explicitly; never make arbitrary channel names public by default.
- Authorize private and presence channels on the server. Do not trust a channel name or client-supplied user ID.
- Fail closed when identity or authorization is missing.
- Protect the WebSocket endpoint with an appropriate origin policy and use `wss://` in production.
- Decide how authenticated WebSocket connections are revoked on logout or permission changes. Handshake authentication does not automatically terminate an already-open connection.
