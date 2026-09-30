# Validation Rule Reference

PixelFix parses validation rules from either pipe-delimited strings or arrays containing rule strings and rule objects.

Example:

```php
'required|string|max:255'
```

or:

```php
[
    'required',
    'string',
    'max:255',
]
```

## Rule list

| Rule | Parameters | Behavior |
| --- | --- | --- |
| `required` | none | Requires a non-null, non-empty string/array/value. |
| `required_if` | `field,value` | Requires the field when another field equals the expected value using string comparison. |
| `nullable` | none | Allows an empty value to short-circuit the field when `required` is not also present. |
| `bail` | none | Stops processing the field after its first failed validation rule. |
| `string` | none | Requires a PHP string. |
| `array` | none | Requires an array. |
| `integer` | none | Uses `FILTER_VALIDATE_INT`. |
| `numeric` | none | Uses PHP numeric detection. |
| `boolean` | none | Accepts `true`, `false`, `1`, `0`, `'1'`, and `'0'`. |
| `alpha` | none | Requires letters only. |
| `alpha_num` | none | Requires letters and numbers only. |
| `email` | none | Uses PHP email filtering. |
| `min` | number | Minimum string length, numeric value, array count, or uploaded-file size in KB. |
| `max` | number | Maximum string length, numeric value, array count, or uploaded-file size in KB. |
| `same` | `field` | Requires strict equality with another field's value. |
| `different` | `field` | Requires a different value from another field. |
| `confirmed` | none | Requires `{field}_confirmation` to exist and strictly equal the field value. |
| `in` | comma-separated values | Value must be strictly in the supplied list. |
| `not_in` | comma-separated values | Value must not be strictly in the supplied list. |
| `regex` | pattern | Passes when `preg_match()` returns a match. |
| `date` | none | Requires a string accepted by `DateTime`. |
| `date_format` | format | Requires an exact `DateTime::createFromFormat()` match. |
| `file` | none | Requires a valid uploaded file. |
| `image` | none | Requires a valid uploaded image with one of the supported image MIME types. |
| `mimes` | comma-separated MIME types | Requires a valid uploaded file whose detected MIME type is allowed. |
| `max_file_size` | KB | Requires an uploaded file no larger than the specified KB value. |
| `exists` | `table[,column]` | Requires a matching row in the configured table. |
| `unique` | `table[,column]` | Rejects a matching row in the configured table. |

## Parameter syntax

Parameters normally use commas:

```text
required_if:status,completed
in:pending,in_progress,completed
exists:users,id
```

The parser treats `regex` specially so commas in the regular-expression pattern are preserved:

```text
regex:/^(foo|bar)$/
```

An unknown rule name raises `InvalidArgumentException` instead of silently passing validation.

## `min` and `max`

The same rule adapts to the PHP value type:

```text
string → character count
number → numeric comparison
array  → element count
file   → size in KB
```

For files, the framework uses `size() / 1024` when comparing the configured limit.

## `required_if`

The dependent value is compared after converting both values to strings:

```text
status = 1
expected = '1'
→ required
```

If the dependent field is absent, `required_if` fails.

## `unique`

A unique rule can be created as a rule object when an update must ignore the current record:

```php
use PixelFix\Framework\Validation\Rules\UniqueRule;

Rule::unique('users', 'email')
    ->ignore($user->id);
```

The current rule implementation also supports the string syntax:

```text
unique:users,email
```

## `exists`

The first parameter is the table and the optional second parameter is the database column. If the column is omitted, the validated field name is used:

```text
exists:users
```

is equivalent to checking the `users` table's column with the same name as the field.

## File rules

`file`, `image`, `mimes`, and `max_file_size` expect PixelFix's `UploadedFile` object.

`image` additionally calls `getimagesize()` and accepts the following detected MIME types:

```text
image/jpeg
image/png
image/gif
image/webp
image/bmp
```

`mimes` checks the actual detected MIME type using PHP's `finfo`, not merely the filename extension.

## Custom rule objects

A custom rule implements:

```php
interface RuleInterface
{
    public function validate(
        string $field,
        mixed $value,
        array $data = []
    ): bool;

    public function message(string $field): string;
}
```

Rule objects can be passed directly in a rule array, so they do not need to be converted to strings.
