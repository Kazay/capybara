<?php

namespace App\Http\Controllers\Api\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Json response of all users
     *
     * @return Json
     */     
    public function index(Request $req)
    {
        $users = User::paginate();

        return UserResource::collection($users);
    }

    /**
     * Json response of unique user
     *
     * @param uInt $id
     * @return Json
     */
    public function show(Request $req, User $user)
    {
        return new UserResource($user);
    }

    /**
     * Toggle user's "active" field
     *
     * @param uInt $id
     * @return void
     */
    public function ban(User $user)
    {
        $user->active = ! $user->active;

        $user->save();

        return new UserResource($user);
    }
}
