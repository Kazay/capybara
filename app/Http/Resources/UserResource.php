<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "role" => $this->role,
            "username" => $this->username,
            "firstname" => $this->firstname,
            "lastname" => $this->lastname($request),
            "email" => $this->email($request),
            "created_at" => $this->created_at,
        ];
    }

    /**
     * Adapt lastname field to user permissions
     *
     * @param \Illuminate\Http\Request $req
     * @return String
     */
    public function lastName($req)
    {
        if (User::hasRole($req->user(), 'admin') || $this->isOwner($req))
        {
            return $this->lastname;
        }
        else
        {
            return substr($this->lastname, 0, 1);
        }
    }

    /**
     * Adapt email field to user permissions
     *
     * @param \Illuminate\Http\Request $req
     * @return String
     */
    public function email($req)
    {
        if (User::hasRole($req->user(), 'admin') || $this->isOwner($req))
        {
            return $this->email;
        }
        else
        {
            return "hidden";
        }
    }

    /**
     * Check if current user is the ressource owner
     *
     * @param \Illuminate\Http\Request $req
     * @return boolean
     */
    public function isOwner($req)
    {
        return ($req->user()->id == $this->id);
    }
}
