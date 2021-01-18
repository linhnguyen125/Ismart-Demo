<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    protected $fillable = [
        'name'
    ];

    function roles()
    {
        return $this->belongsToMany('App\Roles');
    }
}
