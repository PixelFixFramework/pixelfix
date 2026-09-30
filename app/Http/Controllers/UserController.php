<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Requests\StoreUserRequest;
use App\Requests\UpdateUserRequest;
use PixelFix\Framework\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(
        StoreUserRequest $request
    )
    {
        //
    }

    public function show(
        User $user
    )
    {
        //
    }

    public function edit(
        User $user
    )
    {
        //
    }

    public function update(
        UpdateUserRequest $request,
        User $user
    )
    {
        //
    }

    public function destroy(
        User $user
    )
    {
        //
    }
}