# Rate Limiting

PixelFix provides a cache-backed `PixelFix\Framework\RateLimiting\RateLimiter`, resolved by `rate_limiter()` (also `rateLimiter()`). It tracks attempts for a key and allows application code to enforce request or action limits.

## Common API

```php
$limiter = rate_limiter();
$key = 'login:' . strtolower($email);
$maxAttempts = 5;
$decaySeconds = 60;

if ($limiter->tooManyAttempts($key, $maxAttempts)) {
    $waitSeconds = $limiter->availableIn($key);
    // Return a throttled response or validation error.
} else {
    $limiter->hit($key, $decaySeconds);
}
```

The API includes `tooManyAttempts`, `hit`, `attempts`, `remaining`, `retriesLeft`, `resetAttempts` (also exposed as `clear`), `attempt`, `attemptWithLock`, and `availableIn`. Use a consistent key format and keep user-controlled values normalized before incorporating them into the key.

## Configuration

The starter config includes `rate_limiting.prefix`, login maximum attempts, and login decay settings. `RATE_LIMIT_PREFIX`, `AUTH_LOGIN_MAX_ATTEMPTS`, and `AUTH_LOGIN_DECAY_SECONDS` configure the corresponding starter values. Rate limiting uses the configured cache manager, so choose a cache strategy suitable for the runtime. The `array` cache is process-local and will not coordinate limits across multiple workers. The `file` cache is local filesystem-backed and is not a distributed store across multiple machines.

## Security guidance

Rate-limit authentication attempts, reset-link requests, and expensive actions independently with separate keys and policies. Rate limiting is not authorization: it must not replace authentication or policy checks. Test both under-limit and over-limit requests, reset behavior after the decay period, and concurrent attempts where the application depends on atomic coordination.
