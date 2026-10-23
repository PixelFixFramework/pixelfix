# Filesystem

The filesystem helper gives application code a consistent way to store and retrieve files without scattering low-level `file_put_contents()` and path-concatenation logic throughout controllers.

## Configure disks

The starter ships `config/filesystems.php`. `FILESYSTEM_DISK` selects the default disk (`local` by default), while the `disks` array defines each disk's driver, root directory, and optional URL prefix.

- `local` writes beneath `storage/app` and does not configure a public URL.
- `public` writes beneath `storage/app/public` and uses the `/storage` URL prefix.
- `links` maps a public path such as `public/storage` to the public disk directory.

Create configured links during local setup/deployment with:

```powershell
php pixel storage:link
```

The command creates missing target directories and configured links; it does not replace an existing path. Inspect an existing `public/storage` path before attempting link creation.

The local driver normalizes relative paths and rejects empty, absolute, null-byte, dot-segment and traversal paths; it also checks that existing filesystem ancestors remain inside the configured root. Continue to use application-level authorization and validate user-supplied names even with these checks.

## Store a file

The `storage()` helper resolves the configured storage service. Use it for application files that should not be served directly by the web server:

```php
$path = storage()->put('reports/summary.txt', 'Report content');
```

The returned path identifies the stored file according to the filesystem implementation. Store relative paths in application records rather than hard-coding machine-specific absolute paths.

## Read a stored file

```php
$content = storage()->get('reports/summary.txt');
```

Use the file's returned content only after checking the API's missing-file behavior for the configured driver. If the file is required for a business operation, handle a missing file as an expected failure rather than assuming that every read succeeds.

## Delete a stored file

```php
storage()->delete('reports/summary.txt');
```

Deleting a file is destructive. Validate that the path comes from a trusted application value; do not let an untrusted request supply an arbitrary filesystem path.

## Public files and private files

Files placed beneath `public/` can be directly reachable by a browser according to the web server configuration. Sensitive exports, identity documents, reports, and internal uploads should be stored outside the public document root and served only through a controller that checks authorization.

## Get a public URL

A disk with a configured URL prefix can create a URL for a relative path:

```php
$url = storage()->url('avatars/user-42.png');
```

Use `url()` only when that disk is intended to be public and its configured symbolic link/web-server mapping is active. The default `local` disk does not advertise a public URL; asking for one is an error. Do not expose private documents by switching their URL prefix.

## URLs are different from storage paths

A stored path identifies a file on the configured disk; a public URL is an address that a browser can request. Do not assume a private storage path can or should be converted into a public URL. For downloadable private content, authenticate the request, authorize access, and return the file through a response.


## A practical example: storing an upload

Before saving a user-supplied file, validate its type and size and decide whether it belongs in public storage or private storage. A profile image intended for browser display may belong in a public asset location; a private document should not be placed under the web server's public document root. A filesystem helper does not decide access permissions for you.

The usual sequence is: validate the request, choose a storage location, write the file, save its relative path in the database, and authorize future downloads. Store relative paths rather than machine-specific absolute paths so the application can run on another server.

## Common mistake

Do not assume that a successful file write makes a file safe to serve. Access control, file-name handling, allowed extensions, size limits, and the destination directory are application responsibilities. Keep private files outside `public/` and serve them through a controller that checks permission.
