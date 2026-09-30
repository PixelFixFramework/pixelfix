# Build Your First PixelFix Page

This guide shows the smallest useful PixelFix application flow: define a route, send it to a controller, and render a Twig view.

## 1. Create the application

Create an application from the PixelFix CLI:

```bash
php pixelfix new hello-pixelfix
cd hello-pixelfix
```

Install dependencies if the generated project has not already done so:

```bash
composer install
```

## 2. Define a route

Open `routes/web.php` and add a GET route:

```php
use App\Http\Controllers\HomeController;
use PixelFix\Framework\Routing\Route;

Route::get(
    '/hello',
    [
        HomeController::class,
        'hello',
    ]
)->name('hello');
```

The route maps the `/hello` URI to a controller method and assigns the name `hello`.

## 3. Generate the controller

```bash
php pixelfix make:controller HomeController
```

Then add the action:

```php
public function hello()
{
    return view('hello', [
        'name' => 'PixelFix',
    ]);
}
```

A controller can also use its protected `render()` method when working directly with the injected Twig environment.

## 4. Create the view

Create:

```text
resources/views/hello.twig
```

with:

```twig
{% extends 'layouts/app.twig' %}

{% block content %}
    <h1>Hello, {{ name }}</h1>
{% endblock %}
```

The exact block names depend on the application's layout. The Task Manager is the reference for the project's actual layout/component structure.

## 5. Start the application

```bash
php pixelfix serve
```

Then open:

```text
/hello
```

The request follows the normal PixelFix lifecycle:

```text
Request
  ↓
Route match
  ↓
Controller action
  ↓
Twig rendering
  ↓
HtmlResponse
  ↓
Browser
```

## 6. Generate a URL from the route name

Because the route has a name, application code can build its URL with:

```php
route('hello');
```

For redirects:

```php
return redirect('hello');
```

## 7. Add middleware later

Once the basic page works, protection can be attached without changing the controller action:

```php
Route::get(
    '/hello',
    [HomeController::class, 'hello']
)->middleware('auth');
```

This is the first step toward the layered request flow used by the Task Manager.

## What to learn next

After this page works, move through Routing, Controllers, Middleware, FormRequests/Validation, Views, Models, Authentication, and Authorization. The Task Manager documentation then shows the same pieces operating together in a complete application.
