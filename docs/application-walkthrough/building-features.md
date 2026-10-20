# Building a record Feature from Route to Database

This guide follows one use case: a signed-in user creates a record. The same separation of responsibilities applies when you build other features in PixelFix.

## Understand the path first

```text
Browser form
    ↓ POST /records
Route + web/auth middleware
    ↓
RecordController::store(StoreRecordRequest $request)
    ↓
Form Request authorization and validation
    ↓
RecordPolicy authorization
    ↓
record model + database insert
    ↓
Flash message + redirect to records.index
    ↓
Controller queries records and returns Twig view
```

Each step has one job. The route maps the HTTP method and path; middleware establishes request protections; the Form Request rejects invalid or unauthorized input; the policy answers whether the user may perform the action; the model persists data; and the response tells the browser what to display next.

## 1. Define the route

The reference app's `routes/web.php` registers `POST /records` under the `web` and `auth` middleware groups and names it `records.store`. The form uses the route name rather than hard-coding a destination:

```twig
<form method="POST" action="{{ route('records.store') }}">
    {{ csrf|raw }}
    <!-- fields use title, description, status, due_date -->
</form>
```

The CSRF field matters because this is a state-changing browser request.

## 2. Validate input before persistence

The controller declares the request type:

```php
public function store(StoreRecordRequest $request)
{
    $data = $request->validated();
    // Perform the use case with validated fields.
}
```

`validated()` returns an array containing fields that were covered by the request rules and passed validation. If the request is invalid, the normal Form Request flow stops before the controller action can store the record. Do not use `request()->all()` as your database payload.

## 3. Authorize and assign ownership

The action authorizes the `create` ability against `Record::class`, then obtains the signed-in user. It assigns the ownership column on the server:

```php
$user = auth()->user();
$data['user_id'] = $user->id;
$data['status'] = $data['status'] ?? 'pending';

Record::create($data);
```

The browser must not be allowed to decide whose record is created. The `$fillable` list on the model is an additional assignment safeguard, not a replacement for request validation or authorization.

## 4. Return a clear result

After creating the record, the controller flashes a success message and redirects to the record list. This is the Post/Redirect/Get pattern: refreshing the resulting page does not normally resubmit the original POST.

## Update and delete follow the same structure

For `PUT /records/{record}`, the controller finds the record, authorizes `update` against that model, validates with `UpdateRecordRequest`, removes any ownership field from writable input, and saves. For `DELETE /records/{record}`, it finds the record, authorizes `delete`, then calls the model's delete behavior. Since `record` uses `SoftDeletes`, the row is marked deleted and omitted from normal queries rather than immediately erased.

## Debugging checklist

- A 404 usually means the route or record was not found.
- A validation redirect means one or more submitted values did not satisfy the Form Request rules.
- A forbidden response usually means the policy denied the action.
- A database error means you should inspect the migration, configured connection, and the shape of the inserted data.
- A successful insert but missing list item may mean the list query intentionally filters by the signed-in user's `user_id`.

For the specific route map, see [Example Application Routing](routing.md). For the security logic, see [Validation](validation.md), [Authentication](authentication.md), and [Authorization](authorization.md).
