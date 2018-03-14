<?php

namespace App\Http\Controllers\Api\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UsersPublicController extends ApiController
{
    /**
     * Holds authenticated user's infos
     *
     * @var Auth
     */
    protected $auth;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->auth = Auth::guard('api')->user();
    }

    /**
     * Json response of all users
     *
     * @return Json
     */     
    public function showUsers()
    {
        $users = User::all();

        if ($users->count() == 0)
        {
            return $this->notFoundResponse('Oops, looks like there\'s nothing in there');
        }

        $response = [];

        foreach ($users as $user)
        {
            // Check user rights on ressources
            $isOwner = ($this->auth->role & User::ROLE['admin']) != 0 || $user->id == $this->auth->id;
            array_push($response, new UserResource($user, $isOwner));
        }

        return response()->json($response);
    }

    /**
     * Json response of unique user
     *
     * @param uInt $id
     * @return Json
     */
    public function showUser($id)
    {
        $user = User::find($id);

        if (is_null($user))
            return $this->notFoundResponse();

        // Check user rights on ressources
        $isOwner = ($this->auth->role & User::ROLE['admin']) != 0 || $user->id == $this->auth->id;
        $response = new UserResource($user, $isOwner);

        return response()->json($response);
    }
}
