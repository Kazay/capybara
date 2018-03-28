<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Troupe extends Model
{
    protected $fillable = [ "name", ];

    public function plays()
    {
        return $this->hasMany('App\Models\Plays');
    }
}
