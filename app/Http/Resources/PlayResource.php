<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayResource extends JsonResource
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
            "name" => $this->name,
            "troupe" => $this->troupe,
            "director" => $this->director,
            "author" => $this->author,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
