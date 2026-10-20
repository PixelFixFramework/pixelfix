# Task Manager Component Architecture

All route-level Twig views are now thin layout wrappers that include a page component. The route variables and business logic remain in their existing controllers and are passed through the normal Twig context.

Page components live under `resources/views/components/pages/`:

- `welcome.twig`
- `auth/login.twig`
- `auth/register.twig`
- `tasks/index.twig`
- `tasks/create.twig`
- `tasks/edit.twig`
- `tasks/show.twig`

The page components preserve the existing layout/navigation/form/table/card/sidebar includes and componentize route-level UI markup. The document shell, layout assets, scripts, debug output, and error document are also components under `resources/views/components/layout/` and `resources/views/components/system/`. The dashboard-specific stylesheet is stored in `public/assets/css/task-manager.css` rather than embedded in the page template.

The controllers, routes, validation, policies, database code, and existing reusable component definitions are unchanged.
