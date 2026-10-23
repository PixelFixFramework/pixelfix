# PDF and Spreadsheet Exports

PixelFix provides a small export API that delegates document rendering to optional adapters. The framework service is available through `exports()`; application code supplies the report data and Twig view, while the configured adapters create the output bytes or save them through the configured filesystem disk.

The export subsystem does not generate application-specific transcript layouts, financial calculations, certificates, invoices or report queries. Keep those in application views and services.

## Install only the export formats you use

PDF generation uses the optional `dompdf/dompdf` package:

```powershell
composer require dompdf/dompdf
```

Spreadsheet generation uses the optional `phpoffice/phpspreadsheet` package:

```powershell
composer require phpoffice/phpspreadsheet
```

Both are optional. A PixelFix application that never calls the corresponding exporter does not need to install those libraries merely to boot. If an exporter is called without its package, PixelFix throws a clear runtime error explaining which package is required. The installed package's Composer metadata describes the PHP extensions required by the selected release.

## Configure export defaults

The starter includes `config/exports.php`, and its documented defaults are in `.env.example`.

| Variable | Default | Purpose |
|---|---|---|
| `PDF_PAPER` | `A4` | Default PDF paper size (Dompdf also accepts supported custom paper-size arrays when passed as a call option). |
| `PDF_ORIENTATION` | `portrait` | Default orientation: `portrait` or `landscape`. |
| `PDF_ENCODING` | `UTF-8` | Character encoding for the HTML passed to the PDF renderer. |
| `PDF_DEFAULT_FONT` | `DejaVu Sans` | Default PDF font. |
| `PDF_DPI` | `96` | Rendering DPI; the adapter accepts values from 36 through 600. |
| `PDF_REMOTE_ENABLED` | `false` | Whether the renderer may fetch remote resources. Keep disabled unless the templates and allowed resource sources are trusted. |
| `SPREADSHEET_FORMAT` | `xlsx` | Default format: `xlsx`, `xls`, `csv` or `ods`. |
| `SPREADSHEET_SHEET_NAME` | `Sheet1` | Default worksheet name. |
| `SPREADSHEET_AUTO_SIZE_COLUMNS` | `false` | Auto-size populated columns when supported by the writer. |
| `SPREADSHEET_HEADER_BOLD` | `true` | Bold the first row when headers are supplied. |

Application code should consume `config()` after bootstrap instead of reading environment variables in controllers.

## Generate a PDF from a Twig view

Create an application view such as `resources/views/reports/statement.twig` and pass it the data the report needs:

```php
$pdfBytes = exports()->pdf()->renderView(
    'reports/statement',
    ['statement' => $statement],
);
```

`renderView()` returns the PDF document as a byte string. To render trusted HTML directly, use `renderHtml($html, $options = [])`. You may override configured PDF settings per call:

```php
$pdfBytes = exports()->pdf()->renderView(
    'reports/statement',
    ['statement' => $statement],
    ['paper' => 'A4', 'orientation' => 'landscape'],
);
```

To store the generated output on the application's default filesystem disk:

```php
$relativePath = exports()->pdf()->saveView(
    'reports/statement',
    'reports/statement.pdf',
    ['statement' => $statement],
);
```

`saveView()` returns the relative storage path, not a public URL or HTTP download response. The storage destination follows `config/filesystems.php`. Keep statements, transcripts and certificates on a private disk unless there is a deliberate, authorized public-delivery design.

## Generate a spreadsheet from rows

Pass an array of row arrays. Column names can be supplied with the `headers` option:

```php
$rows = [
    ['Alice', 'alice@example.test'],
    ['Brian', 'brian@example.test'],
];

$xlsxBytes = exports()->spreadsheet()->generate($rows, [
    'headers' => ['Name', 'Email'],
    'sheet_name' => 'Users',
    'format' => 'xlsx',
]);
```

`generate()` returns the encoded file bytes. To save the result to configured storage:

```php
$relativePath = exports()->spreadsheet()->save(
    $rows,
    'reports/users.xlsx',
    ['headers' => ['Name', 'Email']],
);
```

The output format defaults to `SPREADSHEET_FORMAT` and can be overridden per call. Supported formats in the built-in adapter are `xlsx`, `xls`, `csv` and `ods`. The worksheet name must be from 1 to 31 characters and cannot contain `\\`, `/`, `?`, `*`, `[`, `]` or `:`. Cells accept scalar/null values, dates, and `Stringable` values. String values are written as literal text in spreadsheet formats; formula-like untrusted strings are prefixed before writing CSV output.

For large reports, avoid constructing an unbounded in-memory row array. Use database chunking, pagination or a queued export workflow appropriate to your application's scale, and test memory/time limits with realistic data volumes.

## Security and operational boundaries

- PDF remote-resource loading is disabled by default. Do not enable `PDF_REMOTE_ENABLED` when rendering user-controlled HTML or arbitrary URLs; remote rendering can allow server-side request forgery (SSRF).
- The PDF adapter disables PHP execution inside rendered documents and limits local file access to configured trusted roots. Do not place confidential files under an allowed public/resource root and assume the renderer is an authorization boundary.
- Escape and validate user-supplied content in Twig templates. A generated document can contain sensitive information even when the output file is stored securely.
- Storage paths are relative to the configured disk root. The local filesystem driver rejects path traversal, but the application must still decide who may request, generate, view and download each export.
- `saveView()` and `save()` store bytes; they do not authorize a download, set a response header, or create a public link. For private exports, expose a controller endpoint that authenticates the requester, authorizes access to the record/file, and returns the file through an appropriate response.
- Financial totals, institutional transcript values, grading logic, signatures and certificate content remain application-level rules and must be tested independently from export encoding.

See [Filesystem](../application/filesystem.md), [Environment Reference](../reference/environment.md) and [Authorization](../authorization/overview.md) for the related configuration and access-control guidance.
