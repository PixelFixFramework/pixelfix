<?php

declare(strict_types=1);

// =====================================================
// BASE PATH
// =====================================================

$basePath =
    dirname(__DIR__);

// =====================================================
// ENVIRONMENT FILES
// =====================================================

$examplePath =
    $basePath
    . DIRECTORY_SEPARATOR
    . '.env.example';

$environmentPath =
    $basePath
    . DIRECTORY_SEPARATOR
    . '.env';

// =====================================================
// EXAMPLE FILE
// =====================================================

if (!is_file($examplePath)) {

    fwrite(
        STDERR,
        '.env.example file was not found.'
        . PHP_EOL
        . "Expected: {$examplePath}"
        . PHP_EOL
    );

    exit(1);
}

// =====================================================
// EXISTING ENVIRONMENT
// =====================================================

if (is_file($environmentPath)) {

    fwrite(
        STDOUT,
        '.env already exists. Skipping environment setup.'
        . PHP_EOL
    );

    exit(0);
}

// =====================================================
// COPY ENVIRONMENT
// =====================================================

if (
    !copy(
        $examplePath,
        $environmentPath
    )
) {

    fwrite(
        STDERR,
        'Unable to create .env file.'
        . PHP_EOL
    );

    exit(1);
}

// =====================================================
// COMPLETE
// =====================================================

fwrite(
    STDOUT,
    '.env created successfully from .env.example.'
    . PHP_EOL
);

exit(0);