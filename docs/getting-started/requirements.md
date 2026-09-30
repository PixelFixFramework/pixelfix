# Requirements

## PHP

PixelFix requires:

```text
PHP 8.2 or later
```

The framework declares this requirement in its Composer package definition as `^8.2`.

## Composer

Composer is required to install the framework and its PHP dependencies.

Install Composer through the official Composer installation process for your operating system, then verify it with:

```bash
composer --version
```

## Application web server

PixelFix applications expose a `public/` directory as the web root. The Task Manager application can be run with the PHP development server, while Apache can be configured to point its document root at `public/`.

For local development, the built-in PHP server can be used without a separate web server:

```bash
php -S localhost:8000 -t public
```

The framework also provides a `serve` console command for the development workflow.

## Database drivers

Database support depends on the connection driver and the PHP extensions available in the environment. The application configuration includes connection definitions for MySQL, MariaDB, PostgreSQL, SQLite, SQL Server, DBLIB, and MongoDB.

SQLite is particularly convenient for local development because it can use a file such as:

```text
database/database.sqlite
```

The application must still have the appropriate PHP database extension for the selected driver.

## Development dependencies

The framework's development dependencies include PHPUnit and Faker. Applications may add their own development dependencies as needed.
