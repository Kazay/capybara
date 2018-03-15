<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Play extends Model
{
    protected $fillable = [ "name", "author", ];

    public function troupe()
    {
        return $this->belongsTo('App\Models\Troupe');
    }

    public function director()
    {
        return $this->belongsTo('App\Models\Director');
    }
}
