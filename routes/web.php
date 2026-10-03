<?php

use App\Http\Controllers\HomeController;

use PixelFix\Framework\Routing\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| All browser routes receive:
|
| - Session
| - CSRF Protection
|
*/

Route::middleware('web')
    ->group(function () {

        Route::get(
            '/',
            [HomeController::class, 'index']
        )->name('home');

    });

return Route::all();