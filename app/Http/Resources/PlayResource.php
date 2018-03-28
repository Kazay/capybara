<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayResource extends JsonResource
{
    protected $dates;

    // constructor overload to display current or all dates
    public function __construct($resource, $dates = "current")
    {
        $this->resource = $resource;

        $this->dates = $dates;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // eager load
        $this->resource->load('director', 'troupe', 'performances');

        return [
            "id" => $this->id,
            "name" => $this->name,
            "troupe" => [
                "id" => $this->troupe->id,
                "name" => $this->troupe->name,
                "link" => url('/api/troupe/' . $this->troupe->id),
            ],
            "director" => [
                "id" => $this->director->id,
                "name" => "{$this->director->firstname} {$this->director->lastname}",
                "link" => url('/api/director/' . $this->director->id),
            ],
            "performances" => $this->getPerformances(),
            "author" => $this->author,
            "created_at" => $this->created_at->toDateTimeString(),
            "updated_at" => $this->updated_at->toDateTimeString(),
        ];
    }

    protected function getPerformances()
    {
        // fill dates with the correct requested scope
        $performances;
        if ($this->dates != "all")
            $performances = $this->performances()->onlyCurrent()->get();
        else
            $performances = $this->performances()->get();

        $out = [];
        foreach ($performances as $p)
        {
            array_push($out, [
                'id' => $p->id,
                'date' => $p->date,
                'link' => url('/api/performances/' . $p->id),
            ]);
        }

        return $out;
    }
}
