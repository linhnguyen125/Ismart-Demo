<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable = [
        'name'
    ];

    function users()
    {
        return $this->belongsToMany('App\User');
    }

    function permissions()
    {
        return $this->belongsToMany('App\RolePermission');
    }
}
