<?php

declare(strict_types=1);

use PixelFix\Framework\Core\Application;
use PixelFix\Framework\Foundation\HttpKernelRunner;
use PixelFix\Framework\Http\Requests\Request;

/** @var Application $app */
$app = require_once
    __DIR__
    . '/../bootstrap/app.php';

/** @var HttpKernelRunner $runner */
$runner = $app->make(
    HttpKernelRunner::class
);

$response = $runner->run(
    Request::create()
);

$response->send();