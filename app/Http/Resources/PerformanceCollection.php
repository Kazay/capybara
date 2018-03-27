<?php

namespace App\Http\Resources;

use App\Http\Resources\PerformanceResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PerformanceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [ 
            'data' => $this->collection->transform(function($item) {
                $ticketing = [];

                foreach ($item->ticketing as $t)
                {
                    array_push($ticketing, url('api/users/' . $t->id));
                }

                return [
                    'id' => $item->id,
                    'date' => $item->date,
                    'play' => [ 
                        'id' => $item->play->id,
                        'name' => $item->play->name,
                        'author' => $item->play->author,
                        'link' => url('api/plays/' . $item->play->id),
                    ],
                    'ticketing' => $ticketing,
                    'created_at' => $item->created_at->toDateTimeString(),
                ];
            }), 
        ];
    }
}
