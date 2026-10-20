# Cache

PixelFix provides a cache manager through `PixelFix\Framework\Cache\CacheManager` and the `cache()` helper. The built-in stores in this version are `array` and `file`; this is a local application cache, not a Redis cache driver.

## Basic use

```php
cache()->put('reports:daily', $summary, 900); // TTL in seconds
$summary = cache()->get('reports:daily');
$summary = cache()->get('reports:daily', []);

if (cache()->has('reports:daily')) {
    cache()->forget('reports:daily');
}

$summary = cache()->remember('reports:daily', 900, function (): array {
    return buildDailySummary();
});
```

The manager also provides `missing`, `flush`, `forever`, `rememberForever`, `pull`, `increment`, `decrement`, `lock`, and `tags`. `pull` reads and removes an item. `lock($key, $seconds, $owner)` creates a cache lock. Tagged cache operations are available through `tags(array|string $tags)`.

## Configuration

The starter configuration exposes `cache.default`, `cache.path`, and `cache.locks.driver`. `CACHE_DRIVER`, `CACHE_PATH`, and `CACHE_LOCK_DRIVER` are read by the starter config. `cache.default` accepts `array` or `file` in this version. The array driver is process-local and is not shared across worker processes; the file driver stores serialized values below the configured cache path. Set cache paths to writable, application-owned storage directories.

TTL is measured in seconds. A zero or negative TTL is treated as immediately expired by the cache drivers. `flush()` removes all items from the selected store, so use it with care in environments where unrelated entries share that store.

## Testing and diagnostics

```php
$fake = cache()->fake();
cache()->put('sample', 'value');
cache()->assertStored('sample');
cache()->assertHas('sample');
cache()->assertMissing('not-present');
```

The manager exposes `operationCounters()` and `runtimeMetadata()` for runtime diagnostics, and `reset()` for test/runtime reset handling. `fake()` switches operations to the in-memory test fake; use the assertions only when caching has been faked.

## Boundaries

Route caching and Twig template caching are separate optimizations. The general application cache described here stores application values. It does not provide distributed cache consistency when using the `array` or `file` drivers across multiple hosts. See [Rate Limiting](../rate-limiting/overview.md) for cache-backed request counters and [Configuration](../reference/configuration.md) for the complete configuration groups.
