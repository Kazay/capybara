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
        // eager load
        $this->resource->load('ticketing', 'play', 'play.troupe', 'play.director');

        // retrieve ticketings
        $ticketing = [];
        foreach ($this->ticketing as $t)
        {
            array_push($ticketing, url('api/users/' . $t->id));
        }

        // resource output
        return [
            'id' => $this->id,
            'date' => $this->date,
            'play' => [ 
                'id' => $this->play->id,
                'name' => $this->play->name,
                'author' => $this->play->author,
                'link' => url('api/plays/' . $this->play->id),
                'troupe' => [
                    'id' => $this->play->troupe->id,
                    'name' => $this->play->troupe->name,
                    'link' => url('/api/troupe/' . $this->play->troupe->id),
                ],
                'director' => [
                    'id' => $this->play->director->id,
                    'name' => "{$this->play->director->firstname} {$this->play->director->lastname}",
                    'link' => url('/api/director/' . $this->play->director->id),
                ]
            ],
            'ticketing' => $ticketing,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
