<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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

    public function groups()
    {
        return $this->belongsToMany('App\Models\Configuration\Group', 'users_groups', 'user_id', 'group_id')->withTimestamps();
    }

    public function people()
    {
        return $this->morphOne('App\Models\Person\Person', 'personable');
    }
}
