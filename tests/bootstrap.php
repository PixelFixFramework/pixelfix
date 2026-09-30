<?php

declare(strict_types=1);

use PixelFix\Framework\Core\Application;
use PixelFix\Framework\Support\App;

// =========================================================
// ROOT
// =========================================================

define(
    'BASE_PATH',
    dirname(__DIR__)
);

// =========================================================
// AUTOLOAD
// =========================================================

require_once
    BASE_PATH
    . '/vendor/autoload.php';

// =========================================================
// BOOT APPLICATION
// =========================================================

/** @var Application $app */
$app =
    require BASE_PATH
    . '/bootstrap/app.php';

// =========================================================
// REGISTER GLOBAL CONTAINER
// =========================================================

App::setContainer(
    $app->container()
);

// =========================================================
// STORE APPLICATION
// =========================================================

$GLOBALS['app'] = $app;