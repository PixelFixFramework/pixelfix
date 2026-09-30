<?php

declare(strict_types=1);

use PixelFix\Framework\Bootstrap\Core\CoreBootstraper;
use PixelFix\Framework\Bootstrap\Environment\LoadConfiguration;
use PixelFix\Framework\Bootstrap\Environment\LoadEnvironment;
use PixelFix\Framework\Bootstrap\Providers\ProvidersBootstraper;
use PixelFix\Framework\Bootstrap\Console\BootConsole;
use PixelFix\Framework\Core\Application;

// =========================================================
// APPLICATION PATH
// =========================================================

defined('BASE_PATH') || define(
    'BASE_PATH',
    dirname(__DIR__)
);

// =========================================================
// AUTOLOADER
// =========================================================

require_once BASE_PATH
    . '/vendor/autoload.php';

// =========================================================
// CREATE APPLICATION
// =========================================================

$app = new Application(
    BASE_PATH
);

// =========================================================
// BOOTSTRAP PIPELINE
// =========================================================

$app->bootstrapWith([

    // =============================================
    // ENVIRONMENT
    // =============================================

    LoadEnvironment::class,
    LoadConfiguration::class,

    // =============================================
    // CORE
    // =============================================

    CoreBootstraper::class,

    // =============================================
    // PROVIDERS
    // =============================================

    ProvidersBootstraper::class,

    // =============================================
    // CONSOLE
    // =============================================

    BootConsole::class,

]);

// =========================================================
// BOOT APPLICATION
// =========================================================

$app->boot();

// =========================================================
// RETURN APPLICATION
// =========================================================

return $app;