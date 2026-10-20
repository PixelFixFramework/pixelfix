# Glossary for Beginners

Use this glossary when a documentation page introduces a term you have not seen before.

| Term | Meaning in PixelFix |
|---|---|
| **Application** | The project you build with PixelFix: its own routes, controllers, models, views, configuration, and tests. |
| **Artifact** | A file or coordinated set of files produced by a generator, such as a model, migration, or controller. |
| **Authentication** | Verifying who the current user is. |
| **Authorization** | Deciding whether an authenticated user may perform a particular action. |
| **Bootstrap** | The steps that load environment/configuration and prepare services before handling a request or command. |
| **Component** | A reusable Twig template included by views or other components. |
| **Container** | The dependency-injection service that builds and supplies objects with their dependencies. |
| **Controller** | Application code that handles a matched route and returns a response. |
| **Dependency injection** | Supplying an object with the services it needs instead of constructing all dependencies internally. |
| **Factory** | A definition for generating example model attributes, commonly used in tests and seed data. |
| **Form Request** | A class that groups validation rules and, where configured, authorization for request input. |
| **Global scope** | A query condition applied automatically to a model's queries unless the scope is removed. Soft deletes use a scope to hide deleted rows. |
| **Guard** | The mechanism that authenticates a request, such as a browser session or token. |
| **Migration** | A versioned description of a database schema change. It does not mean the same thing as inserting seed data. |
| **Middleware** | Code that runs around a request before it reaches the controller and/or after the controller returns. |
| **Model** | A PHP class that represents a type of database record and provides query/persistence behavior. |
| **ORM** | Object-relational mapping: the framework layer that maps database rows to model objects. |
| **Policy** | A set of authorization decisions usually associated with a model, such as whether a user can update a task. |
| **Provider** | A service-registration/initialization class. An authentication user provider has the narrower role of loading user records. Context determines the meaning. |
| **Query builder** | An object used to build and execute a database query. A call such as `Task::withTrashed()` returns a query builder; add `get()` or `count()` to execute it. |
| **Route** | A declaration matching an HTTP method and path to an action. |
| **Seeder** | A class that inserts known application data, often by using models and factories. |
| **Session** | Server-side data associated with a browser across multiple requests. |
| **Soft delete** | Marking a record as deleted by setting a timestamp while retaining the database row. |
| **Stub** | A source template used by a generator to create a starting file. |
| **Twig** | The template language used to render HTML views. |
| **Validated data** | Input that passed the application's validation rules. Use it instead of reading arbitrary request fields after validation. |

## Similar terms that are easy to confuse

### Migration and seeder

A migration changes database structure—for example, it adds a `tasks` table. A seeder inserts records into that table—for example, it creates a sample user and three sample tasks.

### Authentication and authorization

Authentication asks, “Who is making this request?” Authorization asks, “May this person do this?” A route may require a signed-in user and still need a policy check before updating a record.

### View and component

A view is a page template returned by a controller. A component is a reusable part of a page. A view can include several components; a component can include other components. Creating a view does not automatically import the components it references.

### Soft delete and permanent delete

A soft delete sets `deleted_at`, and normal queries hide the row. A force delete removes the row from the database. Use the permanent-delete API only when that loss is intended and authorized.
