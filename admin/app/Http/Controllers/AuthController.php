<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Microservices\UserService;
use Illuminate\Http\Request;

class AuthController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function user(Request $request)
    {
        $user = $this->userService->getUser();

        $resource = new UserResource($user);

        if ($user->isInfluencer()) {
            return $resource->additional([
                'data' => [
                    'revenue' => $user->revenue()
                ]
            ]);
        }

        return $resource->additional([
            'data' => [
                'role' => $user->role(),
                'permissions' => $user->permissions()
            ]
        ]);
    }
}
