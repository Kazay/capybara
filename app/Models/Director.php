<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    protected $fillable = [ "firstname", "lastname", ];

    public function plays()
    {
        return $this->hasMany('App\Models\Play');
    }
}
