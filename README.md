
# PixelFix Application

A starter application for building web applications with PixelFix.

## Requirements

- PHP 8.2 or later
- Composer 2.x
- Authorized access to the PixelFix framework repository while it remains private

## Installation

Choose either of the following methods to create your PixelFix application.

### Option 1: Install using Composer

Create a new application directly from the PixelFix starter package:

```powershell
composer create-project pixelfix/pixelfix my-app
```

Navigate to the application directory:

```powershell
cd my-app
```

### Option 2: Install using the PixelFix CLI Installer

**Step 1: Install the CLI Installer globally.**

```powershell
composer global require pixelfix/installer
```

Verify the installation:

```powershell
pixelfix --help
```

If PowerShell cannot find `pixelfix`, ensure Composer's global executable directory is included in your Windows `PATH`.

**Step 2: Create your application.**

```powershell
pixelfix new my-app
```

Navigate to the application directory:

```powershell
cd my-app
```

### Run the application

After creating your application using either method, display the available commands:

```powershell
php pixel help
```

Start the development server:

```powershell
php pixel serve
```

If dependencies are missing or incomplete, run the following from the application root:

```powershell
composer install
```

**Note:** Both installation methods require authorized access to `PixelFixFramework/framework` while the framework repository remains private. Configure Composer's GitHub authentication if prompted.

## Documentation

The complete developer documentation is available here:

**[Read the PixelFix Documentation](https://github.com/PixelFixFramework/pixelfix/blob/main/docs/documentation-map.md)**

Start with the [Getting Started guides](https://github.com/PixelFixFramework/pixelfix/tree/main/docs/getting-started).

## License

Proprietary.
