# Installation

## Requirements

PixelFix requires:

- PHP 8.2 or later
- Composer

Individual applications may require additional PHP extensions or database drivers depending on the services they enable.

## Install the framework package

Add PixelFix to an existing PHP project with Composer:

```bash
composer require pixelfix/framework
```

The current framework package is a Composer library named `pixelfix/framework`.

## Create a new application

The framework repository contains an application generator exposed through the `new` command:

```bash
php pixelfix new task-manager
```

The generator creates the application from PixelFix application stubs. It creates the application outside the framework repository and rejects reserved or invalid application names.

The generated application contains the standard project areas, including:

```text
app/
bootstrap/
config/
database/
docs/
public/
resources/
routes/
tests/
```

## Install application dependencies

From the generated or existing application directory:

```bash
composer install
```

When autoload metadata needs to be regenerated manually:

```bash
composer dump-autoload
```

## Configure the environment

Generated applications provide `.env.example`. Create the local environment file as required by the application:

```bash
cp .env.example .env
```

The current application bootstrap loads the environment before configuration.

A typical local setup can include values such as:

```env
APP_NAME=PIXELFIX
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost
TIMEZONE=Africa/Lusaka

DB_CONNECTION=sqlite
SQLITE_DATABASE=database/database.sqlite
```

The exact variables depend on the application's active configuration.

## Run migrations and seed data

```bash
php pixel migrate
php pixel db:seed
```

Use `migrate:status` to inspect migration state:

```bash
php pixel migrate:status
```

## Start local development

The framework provides a development server command:

```bash
php pixel serve
```

The PHP built-in server can also be used directly:

```bash
php -S localhost:8000 -t public
```

For Apache, point the document root at the application's `public/` directory.

## Verify the installation

Run:

```bash
php pixel help
php pixel route:list
```

A working help command confirms that the application can bootstrap its console environment. Route listing then confirms that the routing layer has loaded.
