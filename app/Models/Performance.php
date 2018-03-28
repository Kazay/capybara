<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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

    /**
     * Many to Many relationship
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ticketing()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function scopeOnlyCurrent($query)
    {
        return $query->where('date', '>', Carbon::today());
    }
}
