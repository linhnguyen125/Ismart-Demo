<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    //
    protected $fillable = ['id', 'name', 'gso_id'];

    function districts(){
        return $this->hasMany('App\District');
    }
}
