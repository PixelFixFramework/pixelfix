<?php

declare(strict_types=1);

// =====================================================
// BASE PATHS
// =====================================================

$basePath =
    dirname(__DIR__);

$vendorPath =
    $basePath
    . DIRECTORY_SEPARATOR
    . 'vendor'
    . DIRECTORY_SEPARATOR
    . 'npm-asset';

$publicCssPath =
    $basePath
    . DIRECTORY_SEPARATOR
    . 'public'
    . DIRECTORY_SEPARATOR
    . 'assets'
    . DIRECTORY_SEPARATOR
    . 'css';

$publicJsPath =
    $basePath
    . DIRECTORY_SEPARATOR
    . 'public'
    . DIRECTORY_SEPARATOR
    . 'assets'
    . DIRECTORY_SEPARATOR
    . 'js';

// =====================================================
// ENSURE DIRECTORIES
// =====================================================

$zebraPublicBasePath =
    $publicCssPath
    . DIRECTORY_SEPARATOR
    . 'zebra';

$zebraThemes = [
    'classic',
    'flat',
    'materialize',
];

$directories = [

    $publicCssPath,

    $publicJsPath,

    $publicCssPath
    . DIRECTORY_SEPARATOR
    . 'fonts',

    $zebraPublicBasePath,

];

foreach ($zebraThemes as $zebraTheme) {

    $directories[] =
        $zebraPublicBasePath
        . DIRECTORY_SEPARATOR
        . $zebraTheme;
}

foreach ($directories as $directory) {

    if (!is_dir($directory)) {

        if (!mkdir($directory, 0777, true)) {

            fwrite(
                STDERR,
                "Unable to create directory: {$directory}"
                . PHP_EOL
            );

            exit(1);
        }
    }
}

// =====================================================
// COPY FILE
// =====================================================

$copyFile = static function (
    string $source,
    string $destination,
    string $name
): void {

    if (!is_file($source)) {

        fwrite(
            STDERR,
            "{$name} source file not found:"
            . PHP_EOL
            . "  {$source}"
            . PHP_EOL
        );

        exit(1);
    }

    if (
        !copy(
            $source,
            $destination
        )
    ) {

        fwrite(
            STDERR,
            "Unable to publish {$name}."
            . PHP_EOL
        );

        exit(1);
    }
};

// =====================================================
// BOOTSTRAP
// =====================================================

$bootstrapPath =
    $vendorPath
    . DIRECTORY_SEPARATOR
    . 'bootstrap';

$copyFile(
    $bootstrapPath
    . DIRECTORY_SEPARATOR
    . 'dist'
    . DIRECTORY_SEPARATOR
    . 'css'
    . DIRECTORY_SEPARATOR
    . 'bootstrap.min.css',

    $publicCssPath
    . DIRECTORY_SEPARATOR
    . 'bootstrap.min.css',

    'Bootstrap CSS'
);

$copyFile(
    $bootstrapPath
    . DIRECTORY_SEPARATOR
    . 'dist'
    . DIRECTORY_SEPARATOR
    . 'js'
    . DIRECTORY_SEPARATOR
    . 'bootstrap.bundle.min.js',

    $publicJsPath
    . DIRECTORY_SEPARATOR
    . 'bootstrap.bundle.min.js',

    'Bootstrap JavaScript'
);

// =====================================================
// BOOTSTRAP ICONS
// =====================================================

$bootstrapIconsPath =
    $vendorPath
    . DIRECTORY_SEPARATOR
    . 'bootstrap-icons'
    . DIRECTORY_SEPARATOR
    . 'font';

$bootstrapIconsPublicPath =
    $publicCssPath
    . DIRECTORY_SEPARATOR
    . 'fonts';

$copyFile(
    $bootstrapIconsPath
    . DIRECTORY_SEPARATOR
    . 'bootstrap-icons.min.css',

    $publicCssPath
    . DIRECTORY_SEPARATOR
    . 'bootstrap-icons.min.css',

    'Bootstrap Icons CSS'
);

$copyFile(
    $bootstrapIconsPath
    . DIRECTORY_SEPARATOR
    . 'fonts'
    . DIRECTORY_SEPARATOR
    . 'bootstrap-icons.woff2',

    $bootstrapIconsPublicPath
    . DIRECTORY_SEPARATOR
    . 'bootstrap-icons.woff2',

    'Bootstrap Icons WOFF2'
);

$copyFile(
    $bootstrapIconsPath
    . DIRECTORY_SEPARATOR
    . 'fonts'
    . DIRECTORY_SEPARATOR
    . 'bootstrap-icons.woff',

    $bootstrapIconsPublicPath
    . DIRECTORY_SEPARATOR
    . 'bootstrap-icons.woff',

    'Bootstrap Icons WOFF'
);

// =====================================================
// JQUERY
// =====================================================

$jqueryPath =
    $vendorPath
    . DIRECTORY_SEPARATOR
    . 'jquery'
    . DIRECTORY_SEPARATOR
    . 'dist';

$copyFile(
    $jqueryPath
    . DIRECTORY_SEPARATOR
    . 'jquery.min.js',

    $publicJsPath
    . DIRECTORY_SEPARATOR
    . 'jquery.min.js',

    'jQuery'
);

// =====================================================
// OVERLAYSCROLLBARS
// =====================================================

$overlayScrollbarsPath =
    $vendorPath
    . DIRECTORY_SEPARATOR
    . 'overlayscrollbars';

$copyFile(
    $overlayScrollbarsPath
    . DIRECTORY_SEPARATOR
    . 'styles'
    . DIRECTORY_SEPARATOR
    . 'overlayscrollbars.min.css',

    $publicCssPath
    . DIRECTORY_SEPARATOR
    . 'overlayscrollbars.min.css',

    'OverlayScrollbars CSS'
);

$copyFile(
    $overlayScrollbarsPath
    . DIRECTORY_SEPARATOR
    . 'browser'
    . DIRECTORY_SEPARATOR
    . 'overlayscrollbars.browser.es6.min.js',

    $publicJsPath
    . DIRECTORY_SEPARATOR
    . 'overlayscrollbars.browser.es6.min.js',

    'OverlayScrollbars JavaScript'
);

// =====================================================
// TOASTR
// =====================================================

$toastrPath =
    $vendorPath
    . DIRECTORY_SEPARATOR
    . 'toastr'
    . DIRECTORY_SEPARATOR
    . 'build';

$copyFile(
    $toastrPath
    . DIRECTORY_SEPARATOR
    . 'toastr.min.css',

    $publicCssPath
    . DIRECTORY_SEPARATOR
    . 'toastr.min.css',

    'Toastr CSS'
);

$copyFile(
    $toastrPath
    . DIRECTORY_SEPARATOR
    . 'toastr.min.js',

    $publicJsPath
    . DIRECTORY_SEPARATOR
    . 'toastr.min.js',

    'Toastr JavaScript'
);

// =====================================================
// ZEBRA DIALOG
// =====================================================

$zebraPath =
    $vendorPath
    . DIRECTORY_SEPARATOR
    . 'zebra_dialog'
    . DIRECTORY_SEPARATOR
    . 'dist';

$zebraPublicBasePath =
    $publicCssPath
    . DIRECTORY_SEPARATOR
    . 'zebra';

$copyFile(
    $zebraPath
    . DIRECTORY_SEPARATOR
    . 'zebra_dialog.min.js',

    $publicJsPath
    . DIRECTORY_SEPARATOR
    . 'zebra_dialog.min.js',

    'Zebra Dialog JavaScript'
);

// Publish every supported theme separately. Each stylesheet uses
// relative image URLs, so its theme assets must stay beside the CSS.
foreach ($zebraThemes as $zebraTheme) {

    $zebraSourceThemePath =
        $zebraPath
        . DIRECTORY_SEPARATOR
        . 'css'
        . DIRECTORY_SEPARATOR
        . $zebraTheme;

    $zebraPublicThemePath =
        $zebraPublicBasePath
        . DIRECTORY_SEPARATOR
        . $zebraTheme;

    $copyFile(
        $zebraSourceThemePath
        . DIRECTORY_SEPARATOR
        . 'zebra_dialog.min.css',

        $zebraPublicThemePath
        . DIRECTORY_SEPARATOR
        . 'zebra_dialog.min.css',

        "Zebra Dialog {$zebraTheme} CSS"
    );

    // Publish each runtime asset shipped with the theme. In particular,
    // PNG/GIF icon paths referenced by the stylesheet remain resolvable.
    $themeFiles = glob(
        $zebraSourceThemePath
        . DIRECTORY_SEPARATOR
        . '*'
    ) ?: [];

    foreach ($themeFiles as $themeFile) {

        if (!is_file($themeFile)) {
            continue;
        }

        $extension = strtolower(
            pathinfo($themeFile, PATHINFO_EXTENSION)
        );

        if (!in_array(
            $extension,
            ['png', 'gif', 'svg', 'jpg', 'jpeg', 'webp', 'woff', 'woff2', 'ttf', 'eot'],
            true
        )) {
            continue;
        }

        $assetName = basename($themeFile);

        $copyFile(
            $themeFile,
            $zebraPublicThemePath
            . DIRECTORY_SEPARATOR
            . $assetName,
            "Zebra Dialog {$zebraTheme} asset {$assetName}"
        );
    }
}

// =====================================================
// COMPLETE
// =====================================================

fwrite(
    STDOUT,
    'Frontend assets published successfully.'
    . PHP_EOL
);

exit(0);