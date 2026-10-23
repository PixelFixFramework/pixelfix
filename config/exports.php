<?php

return [
    // PDF output uses the optional dompdf/dompdf package.
    'pdf' => [
        'paper' => env('PDF_PAPER', 'A4') ?: 'A4',
        'orientation' => strtolower((string) (env('PDF_ORIENTATION', 'portrait') ?: 'portrait')),
        'encoding' => env('PDF_ENCODING', 'UTF-8') ?: 'UTF-8',
        'default_font' => env('PDF_DEFAULT_FONT', 'DejaVu Sans') ?: 'DejaVu Sans',
        'dpi' => (int) (env('PDF_DPI', 96) ?: 96),
        // Remote assets are disabled by default. Enable only for trusted HTML
        // and known remote hosts; rendering arbitrary remote URLs is unsafe.
        'remote_enabled' => filter_var(
            env('PDF_REMOTE_ENABLED', false),
            FILTER_VALIDATE_BOOL,
        ),
        // Local file access is restricted to app assets. Keep confidential files
        // outside these roots and do not render untrusted HTML as a PDF.
        'chroot' => array_values(array_filter([
            BASE_PATH . '/public',
            BASE_PATH . '/resources',
            BASE_PATH . '/storage/app/public',
        ], 'is_dir')),
    ],

    // Spreadsheet output uses the optional phpoffice/phpspreadsheet package.
    'spreadsheet' => [
        // Supported formats: xlsx, xls, csv, ods.
        'format' => strtolower((string) (env('SPREADSHEET_FORMAT', 'xlsx') ?: 'xlsx')),
        'sheet_name' => env('SPREADSHEET_SHEET_NAME', 'Sheet1') ?: 'Sheet1',
        'auto_size_columns' => filter_var(
            env('SPREADSHEET_AUTO_SIZE_COLUMNS', false),
            FILTER_VALIDATE_BOOL,
        ),
        'header_bold' => filter_var(
            env('SPREADSHEET_HEADER_BOLD', true),
            FILTER_VALIDATE_BOOL,
        ),
    ],
];
