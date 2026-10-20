# Requirements

This page explains what must be installed before you can run a PixelFix application and why each requirement matters.

## PHP 8.2 or later

PixelFix requires PHP 8.2 or later. The version used by your terminal may differ from the version used by Apache, so check both when a web application behaves differently from a command-line check.

```powershell
php -v
```

The first line should report PHP 8.2 or a later compatible version.

## Composer

Composer downloads PHP packages and installs the application's dependencies. Check that it is available:

```powershell
composer --version
```

If Windows says the command is not recognized, install Composer and make sure its executable is on `PATH`, then open a new terminal.

## Web server

The public web root must be the application's `public/` directory. For local development, start PixelFix's development server from the application root:

```powershell
php pixel serve
```

You can also use PHP's built-in server directly:

```powershell
php -S 127.0.0.1:8000 -t public
```

Do not expose the project root as the document root. Directly exposing `app/`, `config/`, `.env`, `vendor/`, or other private files can disclose source code or secrets.

## Database and PHP extensions

Install the PHP extension for the database you intend to use. Examples include `pdo_mysql` for MySQL/MariaDB and `pdo_sqlite` for SQLite. SQL Server and PostgreSQL require their corresponding PHP drivers. A database server being installed does not mean PHP has the correct driver enabled.

You can inspect the terminal's PHP extensions with:

```powershell
php -m
```

For a small local tutorial, SQLite can be convenient if `pdo_sqlite` is enabled. MySQL or MariaDB are common choices for shared development and production.

## Before continuing

You need a working PHP CLI, Composer, an application directory, and a configured database driver if your application uses a database. Continue to [Installation](installation.md) and then [Build Your First PixelFix Page](first-application.md).
