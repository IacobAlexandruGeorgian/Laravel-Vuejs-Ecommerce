<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Microservices\UserService;
use App\Http\Resources\UserResource;

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

        return $resource->additional([
            'data' => [
                'revenue' => $user->revenue()
            ]
        ]);
    }
}
