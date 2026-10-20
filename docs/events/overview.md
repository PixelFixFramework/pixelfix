# Application Events

PixelFix includes a synchronous application event dispatcher. Resolve it with `events()` or through `PixelFix\Framework\Events\EventDispatcherInterface`. It is separate from ORM model lifecycle events and observers; those are documented in [Model Events and Observers](../database/model-events-observers.md).

## Register a listener

```php
events()->listen(OrderPlaced::class, function (OrderPlaced $event): void {
    // React to this event synchronously.
});

events()->dispatch(new OrderPlaced($orderId));
// Equivalent helper form:
event(new OrderPlaced($orderId));
```

`listen(string $event, callable|string|array $listener, int $priority = 0)` registers listeners. The dispatcher also accepts listener class names and listener collections. `subscribe()` registers a subscriber. Listener matching supports event classes and their class hierarchy, along with `*` wildcard patterns. Higher priority listeners run first; registration sequence breaks ties. Returning `false` from a listener stops further propagation.

The dispatcher offers `dispatch`, `dispatchWithContext`, `until`, `hasListeners`, `getListeners`, `forget`, `forgetListener`, `flush`, `enable`, `disable`, and `enabled`. `until()` is for dispatch where a listener result can short-circuit processing. `Dispatchable` is available for event classes that use the framework's dispatch trait.

## Failure behavior

Fail-fast behavior is enabled by default. Configure it through the dispatcher or use `failFast(bool)` where the application deliberately wants different listener-failure handling. Listener failure is represented by the framework's `FailedEvent`; do not silently assume exceptions from every listener are swallowed.

## Testing

```php
$fake = events()->fake();
event(new OrderPlaced($orderId));
// Assert using the fake's recorded event API, then restore/replace the fake
// according to the test's teardown strategy.
```

The dispatcher provides fake/restore and inspection APIs, including `fake`, `restoreFake`, `fakeInstance`, `currentContext`, `currentEnvelope`, and `dispatchedEnvelopes`. `event_cache()` returns the event manifest cache service; it is not a message queue.

## Configuration and boundaries

The starter config includes an `events` group and `events.cache.path`. Events are dispatched in the current process; dispatching an event does not automatically enqueue listeners or deliver events to another process. Use [Queues](../queue/overview.md) for asynchronous jobs and [Broadcasting](../broadcasting/overview.md) or [Redis Pub/Sub](../redis/overview.md) for cross-process delivery where appropriate.
