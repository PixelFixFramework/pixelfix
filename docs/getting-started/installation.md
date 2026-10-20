# Installation

PixelFix applications can be created in either of two ways: directly through Composer or through the separate PixelFix CLI Installer. Choose the method that best fits your workflow.

Once an application has been created, both methods lead to the same next steps: configure the environment, prepare the database if required, run migrations, and start the application.

## 1. Create a new application

Choose one of the following installation methods.

### Option A: Create the application directly with Composer

Run the following command from the directory in which you want to create your application:

```powershell
composer create-project pixelfix/pixelfix my-app
```

Replace `my-app` with your preferred application directory name. Composer creates the project and installs its dependencies.

After the installation completes, enter the application directory:

```powershell
cd my-app
```

### Option B: Use the PixelFix CLI Installer

The **PixelFix Installer** is a separate command-line tool for creating PixelFix applications. See the [PixelFix Installer on Packagist](https://packagist.org/packages/pixelfix/installer) for package information and installer documentation.

**Step 1: Install the CLI Installer globally**

```powershell
composer global require pixelfix/installer
```

If the `pixelfix` command is not recognised, ensure Composer's global executable directory is included in your system `PATH`. You can find that directory with:

```powershell
composer global config bin-dir --absolute
```

Open a new terminal after updating `PATH`.

**Step 2: Create your application**

```powershell
pixelfix new my-app
```

Replace `my-app` with your preferred application directory name.

**Step 3: Enter the application directory**

```powershell
cd my-app
```

The global installer is used to create projects. The `php pixel` command, used in the following sections, belongs to the application itself.

## 2. Install or verify PHP dependencies

For a newly created project, Composer will normally have installed the dependencies already. If the `vendor/` directory is missing, or installation did not complete successfully, run this from the application root:

```powershell
composer install
```

Composer reads `composer.json` and installs the packages required by the application.

## 3. Check the local environment file

Look for `.env` in the application root.

If the project includes `.env.example` but no `.env`, copy the example to `.env` and replace placeholder values with settings for your own machine.

Do not commit `.env` to version control; it may contain database passwords and other secrets.

The application's configuration is assembled from its configuration files, which read environment variables after they are loaded. Adding a variable to `.env` does not change application behaviour unless the relevant configuration uses it.

## 4. Configure the database and PHP driver

Choose the database connection you intend to use, create the database if necessary, and enable the matching PHP driver.

For example, MySQL and MariaDB commonly require `pdo_mysql`, while SQLite requires `pdo_sqlite`.

See [Database Connections](../database/connections.md) for connection details.

## 5. Review and run migrations

Migrations define the database structure. Check the current migration state first:

```powershell
php pixel migrate:status
```

Apply pending migrations:

```powershell
php pixel migrate
```

Do not begin with `migrate:fresh` on a database containing data you need. It rebuilds the schema and can remove existing records.

## 6. Start the application

From the application root, run:

```powershell
php pixel serve
```

Open the local address printed by the server.

If the server does not start, confirm that you are in the application root, dependencies are installed, and the configured port is available.

## A successful setup

You should be able to start the application without dependency errors, connect to the configured database if the application uses one, and load a route in the browser.

Continue with [Build Your First PixelFix Page](first-application.md).
