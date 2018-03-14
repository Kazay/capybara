<?php

namespace App\Http\Controllers\Api\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UsersPublicController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Json response of all users
     *
     * @return Json
     */     
    public function showUsers(Request $req)
    {
        $users = User::all();

        if ($users->count() == 0)
        {
            return $this->notFoundResponse('Oops, looks like there\'s nothing in there');
        }

        $response = [];

        foreach ($users as $user)
        {
            array_push($response, new UserResource($user));
        }

        return response()->json($response);
    }

    /**
     * Json response of unique user
     *
     * @param uInt $id
     * @return Json
     */
    public function showUser(Request $req, $id)
    {
        $user = User::find($id);

        if (is_null($user))
            return $this->notFoundResponse();

        $response = new UserResource($user);

        return response()->json($response);
    }
}
