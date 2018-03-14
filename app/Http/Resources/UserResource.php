<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Expect an info about identified user who reads the ressource
     *
     * @var [type]
     */
    protected $isOwner;

    public function __construct($resource, $isOwner = false)
    {
        // Parent class constructor
        $this->resource = $resource;
        
        $this->isOwner = $isOwner;
    }
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
            "lastname" => ($this->is_lastname_public || $this->isOwner) ? $this->lastname : substr($this->lastname, 0, 1),
            "email" => ($this->is_email_public || $this->isOwner) ? $this->email : "hidden",
            "created_at" => $this->created_at,
        ];
    }
}
