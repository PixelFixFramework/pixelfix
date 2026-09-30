# Filesystem

PixelFix provides a small storage abstraction backed by the local filesystem in the current implementation.

## Storage helper

The global `storage()` helper resolves the framework's `StorageManager`:

```php
storage()->put('avatars/user-1.txt', $contents);
```

The manager exposes:

```php
storage()->put($path, $contents);
storage()->get($path);
storage()->delete($path);
storage()->exists($path);
storage()->url($path);
storage()->driver();
```

## Local storage

The default local driver stores files under:

```text
storage/app
```

A path passed to the driver is relative to that root. Directories are created automatically when writing a file.

For example:

```php
storage()->put(
    'reports/daily.txt',
    'Daily report'
);
```

creates the file under `storage/app/reports/daily.txt`.

## Reading files

`get()` returns the file contents when the file exists and `null` when it does not.

```php
$contents = storage()->get('reports/daily.txt');
```

## Deleting files

```php
storage()->delete('reports/daily.txt');
```

The local driver returns `false` when the file does not exist.

## Public URLs

The local driver's `url()` method returns a `/storage/...` URL:

```php
$url = storage()->url('avatars/user-1.png');
```

The current implementation is deliberately simple: the storage manager delegates to one local driver. Treat the storage API as the application-facing abstraction and the driver as the implementation detail.
