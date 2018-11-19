<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreate;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function store(UserCreate $request)
    {
        return new UserResource(User::create(
            [
                'email' => $request->get('email'),
                'name' => $request->get('name'),
                'password' => bcrypt($request->get('password')),
            ]
        ));
    }
}
