<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaginatedResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ((int) $request->input('page') === -1) {
            return User::all();
        }

        return PaginatedResource::collection(User::paginate(10));
    }

    public function show($id)
    {
        return User::find($id);
    }

    public function store(Request $request)
    {
        $data = $request->only('first_name', 'last_name', 'email') + ['password' => Hash::make($request->only('password'))];

        $user = User::create($data);

        return response($user, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $user->update($request->only('first_name', 'last_name', 'email'));

        return response($user, Response::HTTP_ACCEPTED);
    }

    public function destroy($id)
    {
        User::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
