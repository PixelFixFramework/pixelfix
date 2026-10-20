# Build Your First PixelFix Page

This tutorial builds one small page using PixelFix's normal structure: a **route** matches a URL, a **controller** prepares data, a **view** defines the page structure, and a **component** renders a reusable piece of the interface.

You do not need to understand the whole framework before starting. Complete the steps in order and test the page after each step.

## Before you start

Use an existing PixelFix application. If you still need a project, follow the separate PixelFix Installer's README. The installer creates the project; the application's `pixel` launcher is used after the project exists.

Run the commands below from the application root—the directory containing `composer.json`, `pixel`, and `routes/`.

## 1. Add a route

Open `routes/web.php` and add a GET route:

```php
use App\Http\Controllers\HomeController;
use PixelFix\Framework\Routing\Route;

Route::get('/hello', [HomeController::class, 'hello'])
    ->name('hello');
```

`Route::get()` means the route handles an HTTP GET request, which is what a browser normally sends when you open a page. `/hello` is the URL path. `HomeController::hello` is the method that will run. Naming the route `hello` lets you generate its URL later without repeating the path in templates.

## 2. Generate a controller

```powershell
php pixel make:controller HomeController
```

Open `app/Http/Controllers/HomeController.php` and add this method inside the controller class:

```php
public function hello()
{
    return view('hello', [
        'name' => 'PixelFix',
    ]);
}
```

The `view()` helper renders a Twig view. The first argument, `hello`, identifies `resources/views/hello.twig`. The array passes data to the view; the array key `name` becomes a Twig variable named `name`.

## 3. Generate a generic view and a component

Generate the view and a reusable component:

```powershell
php pixel make:view hello
php pixel make:component hello.message
```

The view is created at `resources/views/hello.twig`. The component is created at `resources/views/components/hello/message.twig`. These are separate files with separate purposes: the view is the page; the component is the reusable interface element displayed by that page.

Open `resources/views/components/hello/message.twig` and replace its starter content with:

```twig
<h1>Hello, {{ name }}!</h1>
```

The expression `{{ name }}` prints the value passed to the component. Twig escapes normal output by default, helping prevent a value from being interpreted as HTML.

Now open `resources/views/hello.twig` and use:

```twig
{% extends 'layouts/app.twig' %}

{% block content %}
    {% include 'components/hello/message.twig' with {'name': name} only %}
{% endblock %}
```

The view extends the shared application layout instead of repeating the document shell. Its `content` block fills the matching block in that layout. The `include` statement renders the component. The `with` expression passes only the `name` value to it, and `only` prevents unrelated variables from leaking into the component's context.

Creating a view does not automatically create or import components referenced by that view. Make sure the component file exists and that its path matches the include.

## 4. Start the development server

```powershell
php pixel serve
```

Open the local address printed by the server and visit `/hello`. You should see **Hello, PixelFix!** inside the application's shared layout.

## 5. Generate a link using the route name

Inside PHP code, use:

```php
$url = route('hello');
```

The helper returns the URL for the route named `hello`. If you later change `/hello` to another path but retain the route name, code using the route helper can follow the new path without being updated in multiple places.

## Follow the request

```text
Browser requests GET /hello
        ↓
The router matches the route
        ↓
HomeController::hello() prepares the name value
        ↓
hello.twig extends the shared layout
        ↓
hello/message.twig renders the headline component
        ↓
PixelFix returns the final HTML response
```

If the browser returns 404, confirm the route file is loaded and the URL matches the declared path. If Twig reports an unknown variable, compare the controller's array key with the variable name in the view and component. If a template cannot be found, verify the view name and include path.

## Continue learning

Read [Routing](../http/routing.md), [Controllers](../http/controllers.md), [Views](../views/overview.md), and [Templates and Components](../views/templates.md). Then follow the Task Manager tutorial to learn database access, validation, authentication, and authorization.
