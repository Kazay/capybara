<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PerformanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $ticketing = [];

        foreach ($this->ticketing as $t)
        {
            array_push($ticketing, $t->id);
        }

        return [
            'id' => $this->id,
            'date' => $this->date,
            'play' => new PlayResource($this->play),
            'ticketing' => [ 
                'users' => $ticketing, 
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
