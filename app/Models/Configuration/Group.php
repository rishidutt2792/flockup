<?php

namespace App\Models\Configuration;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'users_groups', 'group_id', 'user_id')->withTimestamps();
    }
}
