# PixelFix Application

A starter application for building web applications with the PixelFix Framework.

## Requirements

- PHP 8.2+
- Composer
- Git

## Create an application

PixelFix applications are distributed through Packagist as the `pixelfix/pixelfix` project package.

```bash
composer create-project pixelfix/pixelfix my-app
```

The starter requires the privately distributed `pixelfix/framework` package. Authorized developers must configure GitHub Composer authentication before dependency installation can succeed.

```bash
composer config --global github-oauth.github.com YOUR_GITHUB_TOKEN
```

Never commit the token to source control.

## Run the application

```bash
cd my-app
php pixel serve
```

The framework is installed as a dependency under:

```text
vendor/pixelfix/framework/
```

Application development should take place in the project directories such as `app/`, `config/`, `database/`, `resources/`, `routes/`, and `tests/`.
