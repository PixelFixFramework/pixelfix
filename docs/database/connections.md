# Database Connections

A database connection tells PixelFix which database server or database file to use and which PHP driver should communicate with it. The application can define more than one named connection, then select a default for ordinary model queries.

## 1. Configure the connection

In this starter, database settings live in `config/database.php`. Environment variables are loaded before configuration, so credentials can live in `.env` rather than being committed to source code. A MySQL-style connection typically needs a host, port, database name, username, password, and driver.

Example environment values (replace them with values for your own machine):

```dotenv
DB_CONNECTION=mysql
MYSQL_HOST=127.0.0.1
MYSQL_PORT=3306
MYSQL_DATABASE=my_application
MYSQL_USER=my_application_user
MYSQL_PASSWORD=replace-this-locally
```

The active connection array must read the corresponding environment variables. Environment variable names alone do not create a connection; they must be consumed by `config/database.php`.

## 2. Enable the matching PHP driver

The database server and the PHP client driver are different things. For MySQL/MariaDB, enable `pdo_mysql`; for SQLite, enable `pdo_sqlite`; PostgreSQL needs `pdo_pgsql`; SQL Server uses a supported SQL Server driver/configuration. Restart the relevant PHP process after changing extensions.

Check the command-line PHP runtime:

```powershell
php -m
```

The extensions used by the terminal may differ from those used by Apache, so verify both environments if only one of them can connect.

## 3. Choose a connection

The database manager resolves the default connection from the application's configuration. Models and query builders use that connection unless the application explicitly selects another configured connection. See [Connections Reference](connections-reference.md) for the APIs and configuration shape exposed by the current version.

## 4. Verify before migrating

Confirm the connection settings and driver first. Then inspect migration status:

```powershell
php pixel migrate:status
```

If the database is new, run migrations after reviewing them:

```powershell
php pixel migrate
```

A connection failure usually means a wrong host/credential/database name, a stopped database server, or a missing PHP extension. Do not use a destructive migration command as a troubleshooting shortcut when the database contains important data.


## How to troubleshoot a failed connection

A database connection requires more than correct credentials. Check these items in order:

1. The active configuration reads the environment variables you changed.
2. The database server or local database file exists and is reachable.
3. The hostname, port, database name, username, and password match the database.
4. PHP has the matching PDO driver enabled (for example, `pdo_mysql` for MySQL/MariaDB or `pdo_sqlite` for SQLite).
5. The operating-system account running PHP has access to the SQLite directory/file or network endpoint.

A message such as “could not find driver” usually means the PHP driver is missing, not that the database password is wrong. A connection-refused message points more often to a server, host, port, firewall, or service-state problem.
