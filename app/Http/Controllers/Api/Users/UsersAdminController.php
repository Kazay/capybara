<?php

namespace App\Http\Controllers\Api\Users;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\ApiController;

use App\Http\Resources\UserResource;

class UsersAdminController extends ApiController
{

    public function __construct()
    {
        $this->middleware(['auth:api', 'role:admin']);
    }

    /**
     * Change user's active field
     *
     * @param uInt $id
     * @return void
     */
    public function banUser($id)
    {
        $user = User::find($id);

        if (is_null($user))
            return $this->notFoundResponse();

        $user->active = false;

        $user->save();

        return new UserResource($user, true);
    }

    /**
     * Change use "active" field
     *
     * @param uInt $id
     * @return void
     */
    public function unbanUser($id)
    {
        $user = User::find($id);

        if (is_null($user))
            return $this->notFoundResponse();

        $user->active = true;

        $user->save();

        return new UserResource($user, true);
    }
    
}
