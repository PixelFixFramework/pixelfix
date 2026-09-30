# Configuration Reference

PixelFix exposes configuration through the `PixelFix\\Framework\\Config\\Config` class and its `Repository` subclass. Configuration is an in-memory nested array with dot-notation lookup.

## Reading values

```php
$value = app(\PixelFix\Framework\Config\Config::class)->get('app.name');

$value = app(\PixelFix\Framework\Config\Config::class)
    ->get('database.default', 'sqlite');
```

`get()` returns the supplied default when a segment does not exist.

## Checking values

```php
$config->has('database.default');
$config->missing('database.default');
```

## Setting values

```php
$config->set('app.name', 'Task Manager');
$config->set('database.connections.mysql.host', '127.0.0.1');
```

Intermediate arrays are created automatically when required.

## Merging configuration

```php
$config->merge([
    'app' => [
        'debug' => true,
    ],
]);
```

`merge()` uses recursive array replacement, so nested configuration can be extended without replacing unrelated siblings.

## Replacing and resetting

```php
$config->replace($items);
$config->reset();
$config->all();
```

`replace()` discards the current configuration and installs the supplied array. `reset()` clears everything. `all()` returns the complete configuration array.

## Application configuration loading

The framework provides the configuration repository as part of the application container. An application can load environment values and configuration during bootstrap before providers and the console are booted.

A typical Task Manager bootstrap sequence is:

```text
LoadEnvironment
    ↓
LoadConfiguration
    ↓
CoreBootstraper
    ↓
ProvidersBootstraper
    ↓
BootConsole
    ↓
Application::boot()
```

This ordering matters: services that depend on configuration should be created after configuration has been loaded.

## Configuration conventions

Keep configuration concerns separate from application logic. Prefer configuration keys such as:

```text
app.*
database.*
auth.*
session.*
view.*
```

The current Task Manager repository contains a central `config/config.php`; the framework also supports the configuration repository abstraction used by the bootstrap process. When describing an application's configuration, follow the actual files and bootstrap code present in that application rather than assuming every conventional config filename is loaded automatically.
