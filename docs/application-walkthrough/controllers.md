# Example Application Controllers

Controllers coordinate a request. They should not replace routing, validation, authorization, or model responsibilities; they connect those parts into one use case.

## The record controller's responsibilities

`RecordController` contains actions for listing records, showing the create form, storing a record, showing one record, editing, updating, and deleting. A common action has this flow:

1. Obtain the current user when ownership matters.
2. Find the requested record if the route contains an identifier.
3. Authorize the action through the controller's `authorize()` method.
4. Read validated data from a typed Form Request.
5. Ask the model to perform database work.
6. Return a view, redirect, or another HTTP response.

## A create action

The controller receives `StoreRecordRequest`, so PixelFix resolves the request's authorization and validation before the action uses its payload:

```php
public function store(StoreRecordRequest $request)
{
    $user = auth()->user();

    $this->authorize('create', Record::class);

    $data = $request->validated();
    $data['user_id'] = $user->id;
    $data['status'] = $data['status'] ?? 'pending';

    Record::create($data);

    flash('success', 'Record created successfully.');
    return redirect_to_route('records.index');
}
```

The code assigns `user_id` on the server so that form input cannot select another owner. `Record::create()` persists an allowed set of attributes and returns the created model; the controller then flashes a message and redirects instead of returning the whole HTML form response again.

## Show an existing record

The show/edit/update/delete actions must handle a missing record and authorize against the actual model instance. A route parameter is user-controlled input even if it matches the expected numeric pattern. Never assume that knowing a record ID proves ownership.

## Return JSON for an API endpoint

A controller can explicitly return JSON instead of a Twig view:

```php
public function indexJson()
{
    $user = auth()->user();
    $records = Record::query()
        ->where('user_id', $user->id)
        ->get();

    return response()->json($records);
}
```

This is an illustrative action; register a route to it and decide whether it should use authentication middleware. The ownership filter ensures the response only includes records for the current user. See [JSON Responses](../http/json-responses.md) before exposing model data through an API.

## Keep controllers understandable

If the same validation rules are repeated across controllers, move them into a Form Request. If the same ownership rule appears in several actions, keep it in a policy. If a query is reused, consider a model scope or a service. Avoid hiding a simple three-line operation behind many abstractions; extract code when doing so creates a clearer responsibility or reusable behavior.
