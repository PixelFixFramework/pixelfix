# Redis Connections and Pub/Sub

PixelFix has a Redis manager and Redis Pub/Sub abstractions. Resolve `RedisManager` through `redis()` and request a configured connection by name:

```php
$connection = redis()->connection(); // configured redis.default
$connection = redis()->connection('default');
$connection->set('report:status', 'ready');
$status = $connection->get('report:status');
```

The connection abstraction provides operations including set/get/delete, exists, expire, increment/decrement, push/pop, publish, keys, and close/reset lifecycle handling. The actual Redis driver requires the PHP `ext-redis` extension and a reachable Redis service.

## Pub/Sub

Use `redis_publisher()` and `redis_subscriber()` for the framework Pub/Sub layer. `Publisher::publish(Channel|string $channel, mixed $payload)` publishes a payload. `Subscriber` supports `subscribe(array|string $channels, Closure $callback)` and `subscribePattern(array|string $patterns, Closure $callback)`. A message has a channel, payload, and publish timestamp. The framework serializes payload data for the Pub/Sub wire representation, so publish application data that can be serialized consistently by both producer and consumer.

```php
redis_publisher()->publish('application:events', [
    'type' => 'report.completed',
    'reportId' => $reportId,
]);
```

Subscription is a long-running operation and should normally be run in a supervised worker/command rather than inside a normal web request. Handle reconnects, duplicates, and idempotency in subscriber code; Redis Pub/Sub is not a durable job queue.

## Configuration

The starter config has `redis.default`, `redis.connections.*`, and `redis.pubsub.connection`. Environment settings include `REDIS_CONNECTION`, `REDIS_HOST`, `REDIS_PORT`, `REDIS_USERNAME`, `REDIS_PASSWORD`, `REDIS_DB`, `REDIS_TIMEOUT`, `REDIS_READ_TIMEOUT`, `REDIS_PERSISTENT`, `REDIS_PERSISTENT_ID`, and `REDIS_PUBSUB_CONNECTION`. See [Queues](../queue/overview.md) for the Redis queue driver and [Broadcasting](../broadcasting/overview.md) for broadcast traffic over Redis.
