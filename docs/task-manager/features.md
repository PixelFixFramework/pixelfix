# Task Manager Feature Map

The Task Manager proof of concept demonstrates several complete application features.

## Public pages

The web route collection includes a named home route at `/` plus registration and login screens.

## Authentication

The application supports:

```text
GET  /register
POST /register
GET  /login
POST /login
POST /logout
```

Authenticated users are redirected away from the guest-only authentication screens.

## Tasks

The task workflow exposes:

```text
GET    /tasks/index
GET    /tasks/create
POST   /tasks
GET    /tasks/{task}
GET    /tasks/{task}/edit
PUT    /tasks/{task}
DELETE /tasks/{task}
```

The task parameter is constrained to digits in the route definition.

## Authorization example

The application also contains an `/admin-test` route that calls the `access-admin` gate. This demonstrates gate-based authorization separately from the model policy used for tasks.

## Views

The reference application includes authentication pages, task CRUD pages, error pages, an application layout, navigation, forms, feedback components, data tables, pagination, and other reusable Twig components.
