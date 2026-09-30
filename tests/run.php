<?php

declare(strict_types=1);

use PixelFix\Framework\Testing\TestCase;
use PixelFix\Framework\Testing\TestRunner;
use PixelFix\Framework\Testing\TestSuite;

require_once __DIR__ . '/bootstrap.php';

// =========================================================
// OPTIONS
// =========================================================

$filter = null;

$dirOption = null;

/**
 * @var array<int, string>
 */
$excludeDirectories = [];

foreach ($argv as $argument) {

    if (str_starts_with($argument, '--filter=')) {

        $filter = substr(
            $argument,
            9
        );

        continue;
    }

    if (str_starts_with($argument, '--dir=')) {

        $dirOption = substr(
            $argument,
            6
        );

        continue;
    }

    if (str_starts_with($argument, '--directory=')) {

        $dirOption = substr(
            $argument,
            12
        );

        continue;
    }

    if (str_starts_with($argument, '--exclude=')) {

        $excludeDirectories =
            array_filter(

                array_map(
                    'trim',
                    explode(
                        ',',
                        substr(
                            $argument,
                            10
                        )
                    )
                )
            );

        continue;
    }
}

// =========================================================
// DIRECTORY
// =========================================================

$directory =
    $dirOption !== null
        ? $dirOption
        : __DIR__;

$directory =
    realpath(
        $directory
    );

if (
    $directory === false
    ||
    !is_dir($directory)
) {

    fwrite(
        STDERR,
        'Invalid directory: '
        . ($dirOption ?? __DIR__)
        . PHP_EOL
    );

    exit(1);
}

// =========================================================
// NORMALIZE EXCLUDED PATHS
// =========================================================

$excludedPaths = [];

foreach ($excludeDirectories as $excluded) {

    $path =
        realpath(

            $directory
            . DIRECTORY_SEPARATOR
            . $excluded
        );

    if ($path !== false) {

        $excludedPaths[] =
            $path;
    }
}

// =========================================================
// SUITE
// =========================================================

$suite =
    new TestSuite();

// =========================================================
// DISCOVER TEST FILES
// =========================================================

$iterator =
    new RecursiveIteratorIterator(

        new RecursiveDirectoryIterator(

            $directory,

            RecursiveDirectoryIterator::SKIP_DOTS
        )
    );

foreach ($iterator as $file) {

    $pathname =
        $file->getPathname();

    $excluded =
        false;

    foreach ($excludedPaths as $excludedPath) {

        if (
            str_starts_with(
                $pathname,
                $excludedPath
            )
        ) {

            $excluded = true;

            break;
        }
    }

    if ($excluded) {
        continue;
    }

    if (
        !$file->isFile()
        ||
        $file->getExtension() !== 'php'
    ) {

        continue;
    }

    if (

        in_array(

            $file->getFilename(),

            [
                'run.php',
                'bootstrap.php',
            ],

            true
        )
    ) {

        continue;
    }

    require_once
        $pathname;
}

// =========================================================
// DISCOVER TEST CLASSES
// =========================================================

foreach (get_declared_classes() as $class) {

    if (
        !is_subclass_of(
            $class,
            TestCase::class
        )
    ) {
        continue;
    }

    $reflection =
        new ReflectionClass(
            $class
        );

    if (
        $reflection->isAbstract()
    ) {
        continue;
    }

    $suite->add(
        $reflection
            ->newInstance()
    );
}

// =========================================================
// RUN TESTS
// =========================================================

$runner =
    new TestRunner();

$runner->run(
    $suite,
    $filter
);