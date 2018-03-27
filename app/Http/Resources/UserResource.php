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
            "current_tickets" => $this->currentTickets(),
            "created_at" => $this->created_at->toDateTimeString(),
            "updated_at" => $this->updated_at->toDateTimeString(),
            $this->mergeWhen($this->isAdmin($request), [
                "active" => ($this->active == 1),
            ])
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
        if ($this->isAdmin($req) 
            || $this->isOwner($req)
            || $this->isPublic('lastname'))
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
        if ($this->isAdmin($req) 
            || $this->isOwner($req)
            || $this->isPublic('email'))
        {
            return $this->email;
        }
        else
        {
            return "hidden";
        }
    }

    public function isAdmin($req)
    {
        return User::hasRole($req->user(), 'admin');
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

    public function isPublic($string)
    {
        $property = 'is_'.$string.'_public';
        return $this->{$property};
    }

    public function currentTickets()
    {
        $tickets = $this->ticketing;

        $out = [];

        foreach($tickets as $ticket)
        {
            if (strtotime($ticket->date) >= strtotime('-1 day'))
                array_push($out, url('api/performances/' . $ticket->id));
        }

        return $out;
    }
}
