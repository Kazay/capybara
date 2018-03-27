<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * Define roles for global use
     * Needed for ValidateRole Middleware
     */
    const ROLE = [
        "guest" => 1,
        "member" => 2,
        "admin" => 4,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function ticketing()
    {
        return $this->belongsToMany('App\Models\Performance');
    }

    /**
     * Check if user has role
     *
     * @param \App\Models\User $user
     * @param String $role
     * @return boolean
     */
    public static function hasRole(User $user, $role)
    {
        return ($user->role & User::ROLE[$role]) != 0;
    }
}
