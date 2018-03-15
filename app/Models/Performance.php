<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    protected $fillable = [ 'date' ];

    /**
     * One to Many (inverse) relationship
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function play()
    {
        return $this->belongsTo('App\Models\Play');
    }
}
