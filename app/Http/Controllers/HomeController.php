<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use PixelFix\Framework\Http\Controllers\Controller;

class HomeController extends Controller
{
    // =====================================================
    // HOME PAGE
    // =====================================================

    public function index()
    {
        return view(
            'welcome'
        );
    }
}