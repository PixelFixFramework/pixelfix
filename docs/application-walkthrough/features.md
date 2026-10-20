# Example Application Feature Map

This example application demonstrates how PixelFix features can work together. Use this page as a map; the linked guides explain the implementation step by step. The routes, models, and request classes shown here are illustrative examples, not framework-reserved names or requirements for every application.

## Public pages and authentication

The root route (`GET /`) displays the welcome page. Guests can view the registration and login forms and submit those forms through `POST /register` and `POST /login`. Signed-in users are redirected away from guest-only authentication pages. Logout uses `POST /logout` so it changes session state through a state-changing request protected by the `web` middleware group.

## Record-management workflow

The application exposes these record routes:

| Method | Path | Purpose |
|---|---|---|
| `GET` | `/records/index` | List the signed-in user's records |
| `GET` | `/records/create` | Display the record form |
| `POST` | `/records` | Validate and save a new record |
| `GET` | `/records/{record}` | Display one record |
| `GET` | `/records/{record}/edit` | Display the edit form |
| `PUT` | `/records/{record}` | Validate and save changes |
| `DELETE` | `/records/{record}` | Delete a record (soft delete in this app) |

The `{record}` segment is constrained to digits. Named routes such as `records.show` let templates generate URLs without hard-coding the path.

## Where each responsibility lives

- `routes/web.php` maps an HTTP method and URL to an action.
- `RecordController` coordinates the use case: find the record, authorize it, read validated input, persist the change, and choose the response.
- `StoreRecordRequest` and `UpdateRecordRequest` authorize and validate submitted fields.
- `RecordPolicy` checks whether the signed-in user may access or change the record.
- `Record` represents stored rows and defines the relation to `User`.
- migrations define the `users` and `records` tables.
- Twig views and reusable components display the pages and validation feedback.

## Try the application as a user

1. Open `/register` and create an account.
2. Sign in at `/login`.
3. Open `/records/create`, enter a title and the required fields, then submit.
4. Return to `/records/index` and open the record you created.
5. Edit the record and save it.
6. Try signing out and opening a record URL. The route's authentication middleware should prevent an unauthenticated request from reaching the record action.

The exact behavior depends on the app's environment and database being configured and migrated. Do not test ownership protection using only one account: create a second user to verify that the first user cannot access the second user's record.

## Continue learning

- [Quick Start](quick-start.md) runs the application.
- [Trace a Request](trace-a-request.md) explains what happens during one HTTP request.
- [Building Features](building-features.md) walks through the create/update/delete flow.
- [Authentication](authentication.md), [Validation](validation.md), and [Authorization](authorization.md) explain the critical security boundaries.
